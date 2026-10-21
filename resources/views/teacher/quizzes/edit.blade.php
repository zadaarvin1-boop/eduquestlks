@extends('teacher.quizzes.layout')

@section('title', 'Edit Kuis - EduQuest')

@section('content')
    <div class="card">
        <h1>Edit Kuis</h1>
        <p class="muted">Perbarui informasi kuis yang sudah dibuat.</p>

        @if ($errors->any())
            <div class="error" style="margin-bottom: 18px;">
                <strong>Periksa kembali data berikut:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('teacher.quizzes.update', $quiz) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="field">
                <label for="title">Judul Kuis</label>
                <input
                    type="text"
                    id="title"
                    name="title"
                    value="{{ old('title', $quiz->title) }}"
                    required
                >
            </div>

            <div class="field">
                <label for="subject_id">Mata Pelajaran</label>
                <select id="subject_id" name="subject_id" required>
                    @foreach ($subjects as $subject)
                        <option
                            value="{{ $subject->id }}"
                            @selected(old('subject_id', $quiz->subject_id) == $subject->id)
                        >
                            {{ $subject->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="field">
                <label for="grade">Kelas</label>
                <select id="grade" name="grade" required>
                    @foreach (['7', '8', '9', '10', '11', '12'] as $grade)
                        <option
                            value="{{ $grade }}"
                            @selected(old('grade', $quiz->grade) == $grade)
                        >
                            Kelas {{ $grade }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="field">
                <label for="duration_minutes">Durasi (menit)</label>
                <input
                    type="number"
                    id="duration_minutes"
                    name="duration_minutes"
                    min="1"
                    max="240"
                    value="{{ old('duration_minutes', $quiz->duration_minutes) }}"
                    required
                >
            </div>

            <div class="field">
                <label for="summary">Deskripsi Kuis</label>
                <textarea
                    id="summary"
                    name="summary"
                >{{ old('summary', $quiz->summary) }}</textarea>
            </div>

            <div class="checkbox-row">
                <input
                    type="checkbox"
                    id="is_published"
                    name="is_published"
                    value="1"
                    @checked(old('is_published', $quiz->is_published))
                >
                <label for="is_published">Terbitkan kuis</label>
            </div>

            <div class="actions">
                <button type="submit" class="btn primary">Simpan Perubahan</button>

                <a href="{{ route('teacher.quizzes.index') }}" class="btn secondary">
                    Kembali
                </a>
            </div>
        </form>
    </div>
@endsection
