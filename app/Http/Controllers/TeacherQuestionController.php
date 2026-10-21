<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Http\Request;

class TeacherQuestionController extends Controller
{
    public function index(Quiz $quiz)
    {
        $this->ensureCanManage($quiz);

        $questions = $quiz->questions()->orderBy('id')->get();

        return view(
            'teacher.quizzes.questions.index',
            compact('quiz', 'questions')
        );
    }

    public function create(Quiz $quiz)
    {
        $this->ensureCanManage($quiz);

        return view('teacher.quizzes.questions.create', compact('quiz'));
    }

    public function store(Request $request, Quiz $quiz)
    {
        $this->ensureCanManage($quiz);

        $data = $request->validate([
            'question_text' => 'required|string',
            'option_a' => 'required|string',
            'option_b' => 'required|string',
            'option_c' => 'required|string',
            'option_d' => 'required|string',
            'correct_answer' => 'required|in:A,B,C,D',
            'explanation' => 'nullable|string',
            'points' => 'required|integer|min:1|max:100',
        ]);

        $quiz->questions()->create($data);

        return redirect()
            ->route('teacher.quizzes.questions.index', $quiz)
            ->with('success', 'Soal berhasil ditambahkan!');
    }

    public function edit(Quiz $quiz, Question $question)
    {
        $this->ensureCanManage($quiz);

        abort_unless($question->quiz_id === $quiz->id, 404);

        return view(
            'teacher.quizzes.questions.edit',
            compact('quiz', 'question')
        );
    }

    public function update(
        Request $request,
        Quiz $quiz,
        Question $question
    ) {
        $this->ensureCanManage($quiz);

        abort_unless($question->quiz_id === $quiz->id, 404);

        $data = $request->validate([
            'question_text' => 'required|string',
            'option_a' => 'required|string',
            'option_b' => 'required|string',
            'option_c' => 'required|string',
            'option_d' => 'required|string',
            'correct_answer' => 'required|in:A,B,C,D',
            'explanation' => 'nullable|string',
            'points' => 'required|integer|min:1|max:100',
        ]);

        $question->update($data);

        return redirect()
            ->route('teacher.quizzes.questions.index', $quiz)
            ->with('success', 'Soal berhasil diperbarui!');
    }

    public function destroy(Quiz $quiz, Question $question)
    {
        $this->ensureCanManage($quiz);

        abort_unless($question->quiz_id === $quiz->id, 404);

        $question->delete();

        return redirect()
            ->route('teacher.quizzes.questions.index', $quiz)
            ->with('success', 'Soal berhasil dihapus!');
    }

    private function ensureCanManage(Quiz $quiz): void
    {
        $user = auth()->user();

        abort_unless(
            $user &&
            (
                $user->role === 'admin' ||
                (int) $quiz->created_by === (int) $user->id
            ),
            403
        );
    }
}
