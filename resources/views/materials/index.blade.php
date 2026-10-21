<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Materi Pembelajaran - EduQuest</title>

    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f7f7ff;
            color: #202044;
        }
        header {
            background: white;
            border-bottom: 1px solid #ecebf5;
            padding: 18px 5%;
        }
        .nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
        }
        .logo {
            color: #6558e8;
            font-size: 25px;
            font-weight: 800;
            text-decoration: none;
        }
        .container { width: min(1100px, 90%); margin: 35px auto; }
        .muted { color: #70718c; line-height: 1.6; }
        .button {
            display: inline-block;
            background: #6558e8;
            color: white;
            text-decoration: none;
            border: 0;
            border-radius: 9px;
            padding: 11px 16px;
            cursor: pointer;
            font-weight: 700;
        }
        .filters {
            background: white;
            border: 1px solid #ecebf5;
            border-radius: 16px;
            padding: 20px;
            display: grid;
            grid-template-columns: 2fr 1fr 1fr auto;
            gap: 12px;
            margin: 25px 0;
        }
        input, select {
            min-width: 0;
            width: 100%;
            padding: 12px;
            border: 1px solid #deddee;
            border-radius: 9px;
            background: white;
            font: inherit;
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 20px;
        }
        .card {
            background: white;
            border: 1px solid #ecebf5;
            border-radius: 16px;
            padding: 22px;
            overflow-wrap: anywhere;
        }
        .tag {
            display: inline-block;
            color: #5144cc;
            background: #efedff;
            border-radius: 20px;
            padding: 5px 10px;
            font-size: 12px;
            font-weight: 700;
        }
        .card h2 { font-size: 20px; margin-bottom: 8px; }
        .card p { line-height: 1.6; }
        .link {
            color: #6558e8;
            font-weight: 700;
            text-decoration: none;
        }
        .empty {
            background: white;
            border-radius: 16px;
            padding: 30px;
            text-align: center;
            grid-column: 1 / -1;
        }
        .pagination { margin-top: 25px; }
        footer { padding: 28px 5%; color: #70718c; text-align: center; }
        @media (max-width: 800px) {
            .grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
            .filters { grid-template-columns: 1fr 1fr; }
        }
        @media (max-width: 520px) {
            .grid, .filters { grid-template-columns: 1fr; }
            .nav { align-items: flex-start; flex-wrap: wrap; }
        }
    </style>
</head>
<body>
    <header>
        <div class="nav">
            <a href="{{ route('home') }}" class="logo">EduQuest.</a>
            <nav>
                <a class="link" href="{{ route('home') }}">Beranda</a>
                &nbsp;&nbsp;
                <a class="link" href="{{ route('login') }}">Sign In</a>
                &nbsp;&nbsp;
                <a class="button" href="{{ route('register') }}">Sign Up</a>
            </nav>
        </div>
    </header>

    <main class="container">
        <h1>Materi Pembelajaran 📚</h1>
        <p class="muted">
            Temukan materi sesuai mata pelajaran dan kelasmu.
            Kamu dapat membaca materi publik tanpa harus login.
        </p>

        <form class="filters" method="GET" action="{{ route('materials.index') }}">
            <input
                type="search"
                name="q"
                placeholder="Cari judul atau ringkasan materi..."
                value="{{ request('q') }}"
            >

            <select name="subject">
                <option value="">Semua mata pelajaran</option>
                @foreach ($subjects as $subject)
                    <option
                        value="{{ $subject->slug }}"
                        @selected(request('subject') === $subject->slug)
                    >
                        {{ $subject->name }}
                    </option>
                @endforeach
            </select>

            <select name="grade">
                <option value="">Semua kelas</option>
                @foreach (['7', '8', '9', '10', '11', '12'] as $grade)
                    <option
                        value="{{ $grade }}"
                        @selected(request('grade') === $grade)
                    >
                        Kelas {{ $grade }}
                    </option>
                @endforeach
            </select>

            <button class="button" type="submit">Cari</button>
        </form>

        <p class="muted">Ditemukan {{ $materials->total() }} materi.</p>

        <div class="grid">
            @forelse ($materials as $material)
                <article class="card">
                    <span class="tag">
                        {{ $material->subject->name }} · Kelas {{ $material->grade }}
                    </span>

                    <h2>{{ $material->title }}</h2>

                    <p class="muted">
                        {{ $material->summary ?: 'Buka materi ini untuk membaca penjelasan selengkapnya.' }}
                    </p>

                    <a
                        class="link"
                        href="{{ route('materials.show', $material->slug) }}"
                    >
                        Baca materi →
                    </a>
                </article>
            @empty
                <div class="empty">
                    <h2>Belum ada materi yang cocok</h2>
                    <p class="muted">
                        Coba kata kunci, mata pelajaran, atau kelas lain.
                        Materi yang belum dipublikasikan tidak ditampilkan di sini.
                    </p>
                </div>
            @endforelse
        </div>

        <div class="pagination">
            {{ $materials->links() }}
        </div>
    </main>

    <footer>© 2026 EduQuest — Belajar, Bertumbuh, Berprestasi.</footer>
</body>
</html>
