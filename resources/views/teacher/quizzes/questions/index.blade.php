@extends('teacher.quizzes.layout')

@section('title', 'Kelola Soal - EduQuest')

@section('content')
    <div class="card">
        <h1>Kelola Soal</h1>
        <p><strong>Kuis:</strong> {{ $quiz->title }}</p>
        <p class="muted">Jumlah soal: {{ $questions->count() }}</p>

        <div class="actions">
            <a href="{{ route('teacher.quizzes.questions.create', $quiz) }}"
               class="btn primary">
                + Tambah Soal
            </a>

            <a href="{{ route('teacher.quizzes.index') }}"
               class="btn secondary">
                Kembali ke Daftar Kuis
            </a>
        </div>
    </div>

    @forelse ($questions as $question)
        <div class="card">
            <h3>
                Soal {{ $loop->iteration }}
                <span class="muted">({{ $question->points }} poin)</span>
            </h3>

            <p>{{ $question->question_text }}</p>

            <p>A. {{ $question->option_a }}</p>
            <p>B. {{ $question->option_b }}</p>
            <p>C. {{ $question->option_c }}</p>
            <p>D. {{ $question->option_d }}</p>

            <p>
                <strong>Jawaban benar:</strong>
                {{ $question->correct_answer }}
            </p>

            @if ($question->explanation)
                <p><strong>Penjelasan:</strong> {{ $question->explanation }}</p>
            @endif

            <div class="actions">
                <a href="{{ route('teacher.quizzes.questions.edit', [$quiz, $question]) }}"
                   class="btn warning">
                    Edit
                </a>

                <form
                    action="{{ route('teacher.quizzes.questions.destroy', [$quiz, $question]) }}"
                    method="POST"
                    onsubmit="return confirm('Yakin ingin menghapus soal ini?')"
                >
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn danger">Hapus</button>
                </form>
            </div>
        </div>
    @empty
        <div class="card">
            <p>Belum ada soal untuk kuis ini.</p>
            <p class="muted">Klik tombol Tambah Soal untuk mulai membuat pertanyaan.</p>
        </div>
    @endforelse
@endsection