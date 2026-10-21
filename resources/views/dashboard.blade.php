<!DOCTYPE html>
@php
    $user = auth()->user();

    $materialsLearned = \App\Models\MaterialCompletion::where(
        'user_id',
        $user->id
    )->count();

    $quizzesCompleted = \App\Models\QuizAttempt::where(
        'user_id',
        $user->id
    )
        ->whereNotNull('completed_at')
        ->distinct()
        ->count('quiz_id');
@endphp
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - EduQuest</title>
    <style>
        * {
            box-sizing: border-box;
        }

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
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
        }

        .logo {
            color: #6558e8;
            font-size: 24px;
            font-weight: 800;
            text-decoration: none;
        }

        .container {
            width: min(1000px, 90%);
            margin: 35px auto;
        }

        .card {
            background: white;
            border: 1px solid #ecebf5;
            border-radius: 18px;
            padding: 24px;
            margin-bottom: 20px;
        }

        .muted {
            color: #70718c;
            line-height: 1.6;
        }

        .button {
            display: inline-block;
            border: 0;
            border-radius: 9px;
            padding: 11px 16px;
            background: #6558e8;
            color: white;
            text-decoration: none;
            font-weight: 700;
            cursor: pointer;
        }

        .secondary {
            background: #efedff;
            color: #5144cc;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
        }

        .stat {
            padding: 20px;
            border-radius: 14px;
            background: #f5f4ff;
        }

        .stat strong {
            display: block;
            font-size: 24px;
            margin-top: 8px;
        }

        @media(max-width: 650px) {
            .stats {
                grid-template-columns: 1fr;
            }

            header {
                align-items: flex-start;
            }
        }
    </style>
</head>

<body>
    <header>
        <a class="logo" href="{{ route('home') }}">EduQuest.</a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="button secondary" type="submit">Keluar</button>
        </form>
    </header>

    <main class="container">
        <div class="card">
            <p class="muted">Dashboard anggota EduQuest</p>
            <h1>Halo, {{ auth()->user()->name }}! 👋</h1>
            <p class="muted">
                Selamat datang kembali. Mari lanjutkan perjalanan belajarmu.
            </p>
            <p>
                Peran:
                <strong>{{ ucfirst(auth()->user()->role) }}</strong>
                @if (auth()->user()->grade)
                    &middot; Kelas {{ auth()->user()->grade }}
                @endif
            </p>
        </div>

        <div class="stats">
            <div class="stat">
                <span>⭐ Total XP</span>
                <strong>{{ number_format(auth()->user()->xp ?? 0) }} XP</strong>
                <p class="muted">Poin penghargaan dari aktivitas belajar.</p>
            </div>
            <div class="stat">
                <span>📚 Materi dipelajari</span>
                <strong>{{ $materialsLearned }}</strong>
                <p class="muted">
                    Jumlah materi yang telah selesai dipelajari.
                </p>
            </div>
            <div class="stat">
                <span>🧩 Kuis diselesaikan</span>
                <strong>{{ $quizzesCompleted }}</strong>
                <p class="muted">
                    Jumlah kuis berbeda yang telah selesai dikerjakan.
                </p>
            </div>
        </div>


        <div class="card">
            <h2>Langkah selanjutnya</h2>

            <p class="muted">
                Dashboard EduQuest. Lanjutkan perjalanan belajarmu
                melalui materi pembelajaran dan fitur lainnya.
            </p>

            <a class="button" href="{{ route('home') }}">
                Kembali ke beranda
            </a>

            @if (in_array(auth()->user()->role, ['teacher', 'admin'], true))
                <a class="button" href="{{ route('teacher.materials.index') }}">
                    Kelola Materi
                </a>

                <a class="button" href="{{ route('teacher.quizzes.index') }}">
                    Kelola Kuis
                </a>
            @endif
        </div>

    </main>
</body>

</html>