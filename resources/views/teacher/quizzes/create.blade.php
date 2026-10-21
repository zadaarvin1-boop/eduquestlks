@extends('teacher.quizzes.layout')

@section('title', 'Tambah Kuis - EduQuest')

@section('content')
    <div class="card">
        <h1>Tambah Kuis</h1>
        <p class="muted">Isi informasi dasar kuis terlebih dahulu.</p>

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

        <form action="{{ route('teacher.quizzes.store') }}" method="POST">
            @csrf

            <div class="field">
                <label for="title">Judul Kuis</label>
                <input
                    type="text"
                    id="title"
                    name="title"
                    value="{{ old('title') }}"
                    placeholder="Contoh: Kuis Matematika Bab 1"
                    required
                >
            </div>

            <div class="field">
                <label for="subject_id">Mata Pelajaran</label>
                <select id="subject_id" name="subject_id" required>
                    <option value="">-- Pilih Mata Pelajaran --</option>

                    @foreach ($subjects as $subject)
                        <option
                            value="{{ $subject->id }}"
                            @selected(old('subject_id') == $subject->id)
                        >
                            {{ $subject->name }}
                        </option>
                    @endforeach
                </select>

                @if ($subjects->isEmpty())
                    <p class="error">
                        Belum ada mata pelajaran. Tambahkan mata pelajaran terlebih dahulu.
                    </p>
                @endif
            </div>

            <div class="field">
                <label for="grade">Kelas</label>
                <select id="grade" name="grade" required>
                    <option value="">-- Pilih Kelas --</option>

                    @foreach (['7', '8', '9', '10', '11', '12'] as $grade)
                        <option
                            value="{{ $grade }}"
                            @selected(old('grade') == $grade)
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
                    value="{{ old('duration_minutes', 10) }}"
                    required
                >
            </div>

            <div class="field">
                <label for="summary">Deskripsi Kuis</label>
                <textarea
                    id="summary"
                    name="summary"
                    placeholder="Jelaskan materi yang akan diuji..."
                >{{ old('summary') }}</textarea>
            </div>

            <div class="checkbox-row">
                <input
                    type="checkbox"
                    id="is_published"
                    name="is_published"
                    value="1"
                    @checked(old('is_published'))
                >
                <label for="is_published">Terbitkan kuis</label>
            </div>

            <div class="actions">
                <button type="submit" class="btn primary">Simpan Kuis</button>

                <a href="{{ route('teacher.quizzes.index') }}" class="btn secondary">
                    Kembali
                </a>
            </div>
        </form>
    </div>
@endsection
