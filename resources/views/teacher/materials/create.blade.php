<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Materi - EduQuest</title>

    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: Arial, sans-serif; background: #f7f7ff; color: #202044; }
        header { background: white; padding: 18px 5%; border-bottom: 1px solid #ecebf5; }
        .logo { color: #6558e8; font-size: 24px; font-weight: 800; text-decoration: none; }
        main { width: min(760px, 92%); margin: 32px auto; background: white; padding: 28px; border-radius: 16px; border: 1px solid #ecebf5; }
        .muted, .hint { color: #70718c; line-height: 1.6; }
        .field { margin: 18px 0; }
        label { display: block; font-size: 14px; font-weight: 700; margin-bottom: 8px; }
        input:not([type=checkbox]), select, textarea { width: 100%; padding: 12px; border: 1px solid #deddee; border-radius: 9px; font: inherit; background: white; }
        textarea { resize: vertical; }
        .check-field { display: flex; align-items: flex-start; gap: 10px; }
        .check-field input { margin-top: 3px; }
        .check-field label { line-height: 1.5; }
        .button { display: inline-block; border: 0; border-radius: 9px; padding: 12px 16px; background: #6558e8; color: white; text-decoration: none; font-weight: 700; cursor: pointer; }
        .secondary { background: #efedff; color: #5144cc; }
        .error-box { padding: 12px 16px; background: #fff0f0; color: #a51d1d; border-radius: 9px; }
        .error-box li { margin-top: 5px; }
        .actions { display: flex; gap: 10px; flex-wrap: wrap; margin-top: 22px; }
    </style>
</head>
<body>
<header>
    <a class="logo" href="{{ route('home') }}">EduQuest.</a>
</header>

<main>
    <h1>Tambah Materi</h1>
    <p class="muted">
        Lengkapi data materi. Kamu bisa menyimpannya sebagai draft
        atau langsung memublikasikannya.
    </p>

    <form method="POST" action="{{ route('teacher.materials.store') }}">
        @csrf

        @include('teacher.materials._form')

        <div class="actions">
            <button class="button" type="submit">Simpan Materi</button>
            <a class="button secondary" href="{{ route('teacher.materials.index') }}">
                Batal
            </a>
        </div>
    </form>
</main>
</body>
</html>
