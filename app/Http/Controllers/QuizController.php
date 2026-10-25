<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Services\BadgeAwardService;

class QuizController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $request->validate([
            'q' => ['nullable', 'string', 'max:100'],
            'subject' => ['nullable', 'string', 'max:255'],
            'grade' => ['nullable', 'in:7,8,9,10,11,12'],
        ]);

        $query = Quiz::with('subject')
            ->withCount('questions')
            ->where('is_published', true)
            ->whereHas('questions');

        $studentGrade = null;

        if ($request->user()?->role === 'student') {
            $studentGrade = $request->user()->grade;

            if ($studentGrade) {
                $query->where('grade', $studentGrade);
            } else {
                $query->whereRaw('1 = 0');
            }
        } else {
            if (!empty($filters['grade'])) {
                $query->where('grade', $filters['grade']);
            }
        }

        if (!empty($filters['subject'])) {
            $query->whereHas('subject', function ($subjectQuery) use ($filters) {
                $subjectQuery->where('slug', $filters['subject']);
            });
        }

        if (!empty($filters['q'])) {
            $search = trim($filters['q']);

            $query->where(function ($builder) use ($search) {
                $builder->where('title', 'like', "%{$search}%")
                    ->orWhere('summary', 'like', "%{$search}%");
            });
        }

        $quizzes = $query->latest()->paginate(9)->withQueryString();
        $subjects = Subject::orderBy('name')->get();

        return view('quizzes.index', compact(
            'quizzes',
            'subjects',
            'studentGrade'
        ));
    }

    public function show(Request $request, string $slug): View
    {
        $quiz = $this->findPublishedQuiz($slug);

        $this->ensureGradeAccess($request, $quiz);

        $sessionKey = $this->timerKey($quiz);

        if (!$request->session()->has($sessionKey)) {
            $request->session()->put($sessionKey, now()->timestamp);
        }

        $startedAt = (int) $request->session()->get($sessionKey);

        $remainingSeconds = max(
            0,
            ($quiz->duration_minutes * 60)
                - (now()->timestamp - $startedAt)
        );

        return view('quizzes.show', compact(
            'quiz',
            'remainingSeconds'
        ));
    }

    public function submit(Request $request, string $slug): RedirectResponse
    {
        $quiz = $this->findPublishedQuiz($slug);

        $this->ensureGradeAccess($request, $quiz);

        $validated = $request->validate([
            'answers' => ['sometimes', 'array'],
            'answers.*' => ['nullable', 'in:A,B,C,D'],
        ]);

        $sessionKey = $this->timerKey($quiz);
        $startedAt = $request->session()->get($sessionKey);

        if (!$startedAt) {
            return redirect()
                ->route('quizzes.show', $quiz->slug)
                ->with('error', 'Mulai kuis terlebih dahulu.');
        }

        $expired = now()->timestamp >
            ((int) $startedAt + ($quiz->duration_minutes * 60) + 5);

        $answers = $expired ? [] : ($validated['answers'] ?? []);

        $questions = $quiz->questions;
        $totalPoints = (int) $questions->sum('points');
        $correctAnswers = 0;
        $score = 0;

        foreach ($questions as $question) {
            $answer = $answers[$question->id] ?? null;

            if (
                $answer !== null &&
                $answer === $question->correct_answer
            ) {
                $correctAnswers++;
                $score += (int) $question->points;
            }
        }

        $submission = DB::transaction(function () use ($request, $quiz, $score, $totalPoints, $correctAnswers, $questions, $startedAt) {
            $account = $request->user();
            $lockedStudent = null;
            $xpAwarded = 0;
            $firstStudentAttempt = false;

            if ($account && $account->role === 'student') {
                $lockedStudent = User::query()
                    ->whereKey($account->id)
                    ->lockForUpdate()
                    ->firstOrFail();

                $hasPreviousAttempt = QuizAttempt::query()
                    ->where('quiz_id', $quiz->id)
                    ->where('user_id', $lockedStudent->id)
                    ->exists();

                $firstStudentAttempt = !$hasPreviousAttempt;

                if ($firstStudentAttempt) {
                    $xpAwarded = $correctAnswers * 10;
                }
            }

            $attempt = QuizAttempt::create([
                'quiz_id' => $quiz->id,
                'user_id' => $account?->id,
                'score' => $score,
                'total_points' => $totalPoints,
                'correct_answers' => $correctAnswers,
                'total_questions' => $questions->count(),
                'started_at' => Carbon::createFromTimestamp((int) $startedAt),
                'completed_at' => now(),
                'xp_awarded' => $xpAwarded,
            ]);

            if ($lockedStudent && $xpAwarded > 0) {
                $lockedStudent->increment('xp', $xpAwarded);
            }

            return [
                'attempt' => $attempt,
                'xp_awarded' => $xpAwarded,
                'first_student_attempt' => $firstStudentAttempt,
            ];
        });

        if ($request->user()?->role === 'student') {
            app(BadgeAwardService::class)->check($request->user());
        }

        $request->session()->forget($sessionKey);

        return redirect()
            ->route('quizzes.result', $quiz->slug)
            ->with('quiz_result', [
                'attempt_id' => $submission['attempt']->id,
                'quiz_slug' => $quiz->slug,
                'quiz_title' => $quiz->title,
                'score' => $score,
                'total_points' => $totalPoints,
                'correct_answers' => $correctAnswers,
                'total_questions' => $questions->count(),
                'expired' => $expired,
                'is_student' => $request->user()?->role === 'student',
                'is_guest' => !$request->user(),
                'xp_awarded' => $submission['xp_awarded'],
                'first_student_attempt' => $submission['first_student_attempt'],
            ]);
    }

    public function result(Request $request, string $slug): View|RedirectResponse
    {
        $result = $request->session()->get('quiz_result');

        if (!$result || $result['quiz_slug'] !== $slug) {
            return redirect()
                ->route('quizzes.index')
                ->with('error', 'Hasil kuis tidak tersedia. Silakan kerjakan kuis kembali.');
        }

        return view('quizzes.result', compact('result'));
    }

    private function findPublishedQuiz(string $slug): Quiz
    {
        return Quiz::with([
            'subject',
            'questions' => fn($query) => $query->orderBy('id'),
        ])
            ->where('slug', $slug)
            ->where('is_published', true)
            ->whereHas('questions')
            ->firstOrFail();
    }

    private function ensureGradeAccess(Request $request, Quiz $quiz): void
    {
        $user = $request->user();

        if ($user?->role === 'student') {
            abort_unless(
                (string) $user->grade === (string) $quiz->grade,
                403,
                'Kuis ini tidak tersedia untuk kelas akunmu.'
            );
        }
    }

    private function timerKey(Quiz $quiz): string
    {
        return 'quiz_started_at_' . $quiz->id;
    }
}
