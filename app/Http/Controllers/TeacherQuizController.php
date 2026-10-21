<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TeacherQuizController extends Controller
{
    public function index()
    {
        $query = Quiz::with('subject')
            ->withCount('questions')
            ->latest();

        if (auth()->user()->role !== 'admin') {
            $query->where('created_by', auth()->id());
        }

        $quizzes = $query->get();

        return view('teacher.quizzes.index', compact('quizzes'));
    }

    public function create()
    {
        $subjects = Subject::orderBy('name')->get();

        return view('teacher.quizzes.create', compact('subjects'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'title' => 'required|string|max:255',
            'grade' => 'required|in:7,8,9,10,11,12',
            'summary' => 'nullable|string',
            'duration_minutes' => 'required|integer|min:1|max:240',
        ]);

        $data['slug'] = $this->uniqueSlug($data['title']);
        $data['created_by'] = auth()->id();
        $data['is_published'] = $request->boolean('is_published');

        Quiz::create($data);

        return redirect()
            ->route('teacher.quizzes.index')
            ->with('success', 'Kuis berhasil ditambahkan!');
    }

    public function edit(Quiz $quiz)
    {
        $this->ensureCanManage($quiz);

        $subjects = Subject::orderBy('name')->get();

        return view(
            'teacher.quizzes.edit',
            compact('quiz', 'subjects')
        );
    }

    public function update(Request $request, Quiz $quiz)
    {
        $this->ensureCanManage($quiz);

        $data = $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'title' => 'required|string|max:255',
            'grade' => 'required|in:7,8,9,10,11,12',
            'summary' => 'nullable|string',
            'duration_minutes' => 'required|integer|min:1|max:240',
        ]);

        $data['slug'] = $this->uniqueSlug(
            $data['title'],
            $quiz->id
        );

        $data['is_published'] = $request->boolean('is_published');

        $quiz->update($data);

        return redirect()
            ->route('teacher.quizzes.index')
            ->with('success', 'Kuis berhasil diperbarui!');
    }

    public function destroy(Quiz $quiz)
    {
        $this->ensureCanManage($quiz);

        $quiz->delete();

        return redirect()
            ->route('teacher.quizzes.index')
            ->with('success', 'Kuis berhasil dihapus!');
    }

    private function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title) ?: 'kuis';
        $slug = $base;
        $number = 2;

        while (
            Quiz::where('slug', $slug)
                ->when(
                    $ignoreId,
                    fn ($query) => $query->where('id', '!=', $ignoreId)
                )
                ->exists()
        ) {
            $slug = $base . '-' . $number;
            $number++;
        }

        return $slug;
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
