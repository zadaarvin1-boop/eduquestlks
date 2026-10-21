<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Materi - EduQuest</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 40px auto;
            padding: 0 20px;
            color: #222;
        }
        label {
            display: block;
            margin-top: 18px;
            font-weight: bold;
        }
        input:not([type="checkbox"]), select, textarea {
            display: block;
            width: 100%;
            box-sizing: border-box;
            padding: 10px;
            margin-top: 7px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }
        textarea { min-height: 120px; }
        .button {
            display: inline-block;
            margin-top: 20px;
            padding: 11px 16px;
            background: #2563eb;
            color: white;
            border: 0;
            border-radius: 6px;
            text-decoration: none;
            cursor: pointer;
        }
        .error { color: #dc2626; }
    </style>
</head>
<body>
    <h1>Edit Materi</h1>
    <p>Perbarui materi pembelajaran EduQuest.</p>

    @if ($errors->any())
        <div class="error">
            <strong>Periksa kembali isianmu:</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form
        action="{{ route('teacher.materials.update', $material) }}"
        method="POST"
    >
        @csrf
        @method('PUT')

        <label for="title">Judul Materi</label>
        <input
            id="title"
            name="title"
            value="{{ old('title', $material->title) }}"
            required
        >

        <label for="subject_id">Mata Pelajaran</label>
        <select id="subject_id" name="subject_id" required>
            @foreach ($subjects as $subject)
                <option
                    value="{{ $subject->id }}"
                    @selected(old('subject_id', $material->subject_id) == $subject->id)
                >
                    {{ $subject->name }}
                </option>
            @endforeach
        </select>

        <label for="grade">Kelas</label>
        <select id="grade" name="grade" required>
            @foreach ([7, 8, 9, 10, 11, 12] as $grade)
                <option
                    value="{{ $grade }}"
                    @selected(old('grade', $material->grade) == $grade)
                >
                    Kelas {{ $grade }}
                </option>
            @endforeach
        </select>

        <label for="summary">Ringkasan</label>
        <textarea id="summary" name="summary">{{ old('summary', $material->summary) }}</textarea>

        <label for="content">Isi Materi</label>
        <textarea id="content" name="content" required>{{ old('content', $material->content) }}</textarea>

        <label>
            <input
                type="checkbox"
                name="is_published"
                value="1"
                @checked(old('is_published', $material->is_published))
            >
            Publikasikan materi
        </label>

        <button type="submit" class="button">Simpan Perubahan</button>
        <a href="{{ route('teacher.materials.index') }}" class="button">
            Kembali
        </a>
    </form>
</body>
</html>
