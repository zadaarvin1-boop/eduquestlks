<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kuis EduQuest</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: Arial, sans-serif; background: #f7f7ff; color: #202044; }
        header { background: white; padding: 18px 5%; border-bottom: 1px solid #ecebf5; }
        .nav { display: flex; justify-content: space-between; align-items: center; gap: 15px; flex-wrap: wrap; }
        .logo { font-size: 25px; font-weight: 800; color: #6558e8; text-decoration: none; }
        main { width: min(1100px, 92%); margin: 35px auto; }
        .muted { color: #70718c; line-height: 1.6; }
        .button { display: inline-block; padding: 11px 15px; border: 0; border-radius: 9px; background: #6558e8; color: white; text-decoration: none; font-weight: 700; cursor: pointer; }
        .secondary { background: #efedff; color: #5144cc; }
        .filters { display: grid; grid-template-columns: 2fr 1fr 1fr auto; gap: 12px; background: white; padding: 18px; border-radius: 14px; margin: 25px 0; }
        input, select { width: 100%; min-width: 0; padding: 11px; border: 1px solid #deddee; border-radius: 8px; background: white; font: inherit; }
        .grid { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 18px; }
        .card { background: white; border: 1px solid #ecebf5; padding: 22px; border-radius: 15px; overflow-wrap: anywhere; }
        .tag { display: inline-block; padding: 5px 9px; border-radius: 20px; background: #efedff; color: #5144cc; font-size: 12px; font-weight: bold; }
        .card h2 { font-size: 20px; }
        .empty { background: white; padding: 30px; border-radius: 14px; grid-column: 1 / -1; }
        .alert { background: #fff4d8; color: #855500; padding: 12px; border-radius: 9px; margin-bottom: 16px; }
        a.text-link { color: #6558e8; font-weight: bold; text-decoration: none; }
        .pagination { margin-top: 24px; }
        @media(max-width: 800px) { .grid { grid-template-columns: repeat(2, minmax(0, 1fr)); } .filters { grid-template-columns: 1fr 1fr; } }
        @media(max-width: 520px) { .grid, .filters { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
<header>
    <div class="nav">
        <a class="logo" href="{{ route('home') }}">EduQuest.</a>
        <nav>
            <a class="text-link" href="{{ route('materials.index') }}">Materi</a>
            &nbsp;&nbsp;
            @auth
                <a class="text-link" href="{{ route('dashboard') }}">Dashboard</a>
            @else
                <a class="text-link" href="{{ route('login') }}">Sign In</a>
                &nbsp;&nbsp;
                <a class="button" href="{{ route('register') }}">Sign Up</a>
            @endauth
        </nav>
    </div>
</header>

<main>
    <h1>Kuis dan Latihan 🧩</h1>
    <p class="muted">
        Pilih kuis untuk menguji pemahamanmu. Guest juga dapat mencoba
        kuis publik tanpa membuat akun.
    </p>

    @if (session('error'))
        <div class="alert">{{ session('error') }}</div>
    @endif

    @if (auth()->check() && auth()->user()->role === 'student')
        <p class="muted">
            Kuis ditampilkan untuk kelas {{ auth()->user()->grade }}.
        </p>
    @endif

    <form class="filters" method="GET" action="{{ route('quizzes.index') }}">
        <input
            type="search"
            name="q"
            value="{{ request('q') }}"
            placeholder="Cari kuis..."
        >

        <select name="subject">
            <option value="">Semua mata pelajaran</option>
            @foreach ($subjects as $subject)
                <option value="{{ $subject->slug }}" @selected(request('subject') === $subject->slug)>
                    {{ $subject->name }}
                </option>
            @endforeach
        </select>

        @if ($studentGrade !== null)
            <input type="hidden" name="grade" value="{{ $studentGrade }}">
            <input value="Kelas {{ $studentGrade }}" aria-label="Kelas akun" disabled>
        @else
            <select name="grade">
                <option value="">Semua kelas</option>
                @foreach (['7', '8', '9', '10', '11', '12'] as $grade)
                    <option value="{{ $grade }}" @selected(request('grade') === $grade)>
                        Kelas {{ $grade }}
                    </option>
                @endforeach
            </select>
        @endif

        <button class="button" type="submit">Cari</button>
    </form>

    <p class="muted">Ditemukan {{ $quizzes->total() }} kuis.</p>

    <div class="grid">
        @forelse ($quizzes as $quiz)
            <article class="card">
                <span class="tag">
                    {{ $quiz->subject->name }} · Kelas {{ $quiz->grade }}
                </span>

                <h2>{{ $quiz->title }}</h2>

                <p class="muted">
                    {{ $quiz->summary ?: 'Uji pemahamanmu melalui latihan soal ini.' }}
                </p>

                <p class="muted">
                    {{ $quiz->questions_count }} soal · {{ $quiz->duration_minutes }} menit
                </p>

                <a class="button" href="{{ route('quizzes.show', $quiz->slug) }}">
                    Mulai Kuis
                </a>
            </article>
        @empty
            <div class="empty">
                <h2>Belum ada kuis yang tersedia</h2>
                <p class="muted">
                    Kuis harus sudah diterbitkan dan memiliki minimal satu soal
                    sebelum bisa dikerjakan.
                </p>
            </div>
        @endforelse
    </div>

    <div class="pagination">{{ $quizzes->links() }}</div>
</main>
</body>
</html>
