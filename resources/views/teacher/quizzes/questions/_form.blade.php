@php
    $editing = isset($question);
@endphp

<div class="card">
    <h1>{{ $editing ? 'Edit Soal' : 'Tambah Soal' }}</h1>
    <p class="muted">Kuis: {{ $quiz->title }}</p>

    @if ($errors->any())
        <div class="error">
            <strong>Periksa kembali isian berikut:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ $action }}" method="POST">
        @csrf

        @if ($editing)
            @method('PUT')
        @endif

        <div class="field">
            <label for="question_text">Pertanyaan</label>
            <textarea id="question_text" name="question_text" required>{{ old('question_text', $editing ? $question->question_text : '') }}</textarea>
        </div>

        @foreach (['a', 'b', 'c', 'd'] as $option)
            <div class="field">
                <label for="option_{{ $option }}">Pilihan {{ strtoupper($option) }}</label>
                <input
                    id="option_{{ $option }}"
                    type="text"
                    name="option_{{ $option }}"
                    value="{{ old('option_'.$option, $editing ? $question->{'option_'.$option} : '') }}"
                    required
                >
            </div>
        @endforeach

        <div class="field">
            <label for="correct_answer">Jawaban Benar</label>
            <select id="correct_answer" name="correct_answer" required>
                @foreach (['A', 'B', 'C', 'D'] as $answer)
                    <option
                        value="{{ $answer }}"
                        @selected(old('correct_answer', $editing ? $question->correct_answer : '') === $answer)
                    >
                        {{ $answer }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="field">
            <label for="explanation">Penjelasan Jawaban (opsional)</label>
            <textarea id="explanation" name="explanation">{{ old('explanation', $editing ? $question->explanation : '') }}</textarea>
        </div>

        <div class="field">
            <label for="points">Poin</label>
            <input
                id="points"
                type="number"
                name="points"
                min="1"
                max="100"
                value="{{ old('points', $editing ? $question->points : 1) }}"
                required
            >
        </div>

        <div class="actions">
            <button type="submit" class="btn primary">
                {{ $editing ? 'Simpan Perubahan' : 'Simpan Soal' }}
            </button>

            <a href="{{ route('teacher.quizzes.questions.index', $quiz) }}"
               class="btn secondary">
                Kembali
            </a>
        </div>
    </form>
</div>