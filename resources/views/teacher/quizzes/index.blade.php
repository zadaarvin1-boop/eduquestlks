@extends('teacher.quizzes.layout')

@section('title', 'Daftar Kuis - EduQuest')

@section('content')
    <div class="card">
        <div class="actions" style="justify-content: space-between;">
            <div>
                <h1>Kelola Kuis</h1>
                <p class="muted">Buat dan kelola kuis untuk siswa EduQuest.</p>
            </div>

            <a href="{{ route('teacher.quizzes.create') }}" class="btn primary">
                + Tambah Kuis
            </a>
        </div>
    </div>

    <div class="card">
        @if ($quizzes->isEmpty())
            <p>Belum ada kuis. Klik tombol <strong>Tambah Kuis</strong> untuk membuat kuis pertama.</p>
        @else
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Judul Kuis</th>
                            <th>Mata Pelajaran</th>
                            <th>Kelas</th>
                            <th>Soal</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($quizzes as $quiz)
                            <tr>
                                <td>
                                    <strong>{{ $quiz->title }}</strong>
                                    <br>
                                    <small class="muted">
                                        {{ $quiz->duration_minutes }} menit
                                    </small>
                                </td>

                                <td>{{ $quiz->subject->name }}</td>
                                <td>{{ $quiz->grade }}</td>
                                <td>{{ $quiz->questions_count }}</td>

                                <td>
                                    @if ($quiz->is_published)
                                        <span class="badge published">Terbit</span>
                                    @else
                                        <span class="badge draft">Draft</span>
                                    @endif
                                </td>


                                <td>
                                    <div class="actions">
                                        <a href="{{ route('teacher.quizzes.questions.index', $quiz) }}" class="btn primary">
                                            Kelola Soal ({{ $quiz->questions_count }})
                                        </a>

                                        <a href="{{ route('teacher.quizzes.edit', $quiz) }}" class="btn warning">
                                            Edit
                                        </a>

                                        <form action="{{ route('teacher.quizzes.destroy', $quiz) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus kuis ini?')">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn danger">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection