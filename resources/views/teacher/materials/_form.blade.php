@if ($errors->any())
    <div class="error-box">
        <strong>Periksa kembali data berikut:</strong>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="field">
    <label for="title">Judul materi</label>
    <input
        id="title"
        name="title"
        value="{{ old('title', $material->title) }}"
        maxlength="255"
        required
    >
</div>

<div class="field">
    <label for="subject_id">Mata pelajaran</label>
    <select id="subject_id" name="subject_id" required>
        <option value="">Pilih mata pelajaran</option>

        @foreach ($subjects as $subject)
            <option
                value="{{ $subject->id }}"
                @selected((string) old('subject_id', $material->subject_id) === (string) $subject->id)
            >
                {{ $subject->name }}
            </option>
        @endforeach
    </select>

    @if ($subjects->isEmpty())
        <p class="hint">
            Belum ada mata pelajaran. Tambahkan mata pelajaran terlebih dahulu.
        </p>
    @endif
</div>

<div class="field">
    <label for="grade">Kelas</label>
    <select id="grade" name="grade" required>
        <option value="">Pilih kelas</option>

        @foreach (['7', '8', '9', '10', '11', '12'] as $grade)
            <option
                value="{{ $grade }}"
                @selected((string) old('grade', $material->grade) === $grade)
            >
                Kelas {{ $grade }}
            </option>
        @endforeach
    </select>
</div>

<div class="field">
    <label for="summary">Ringkasan materi</label>
    <textarea
        id="summary"
        name="summary"
        rows="3"
        maxlength="1000"
    >{{ old('summary', $material->summary) }}</textarea>
</div>

<div class="field">
    <label for="content">Isi materi</label>
    <textarea
        id="content"
        name="content"
        rows="12"
        required
    >{{ old('content', $material->content) }}</textarea>
</div>

<div class="field check-field">
    <input type="hidden" name="is_published" value="0">

    <input
        type="checkbox"
        id="is_published"
        name="is_published"
        value="1"
        @checked((string) old('is_published', (int) $material->is_published) === '1')
    >

    <label for="is_published">
        Publikasikan materi agar bisa dibaca Guest dan siswa
    </label>
</div>
