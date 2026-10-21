<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Kuis - EduQuest</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f7f7ff;
            color: #202044;
        }

        header {
            background: white;
            padding: 18px 5%;
            border-bottom: 1px solid #ecebf5;
        }

        .logo {
            color: #6558e8;
            text-decoration: none;
            font-size: 24px;
            font-weight: 800;
        }

        main {
            width: min(650px, 92%);
            margin: 50px auto;
        }

        .card {
            background: white;
            padding: 30px;
            border-radius: 18px;
            border: 1px solid #ecebf5;
            text-align: center;
        }

        .score {
            font-size: 42px;
            font-weight: 800;
            color: #6558e8;
            margin: 20px 0;
        }

        .muted {
            color: #70718c;
            line-height: 1.6;
        }

        .button {
            display: inline-block;
            padding: 12px 17px;
            border-radius: 9px;
            background: #6558e8;
            color: white;
            text-decoration: none;
            font-weight: bold;
            margin: 5px;
        }

        .secondary {
            background: #efedff;
            color: #5144cc;
        }

        .alert {
            background: #fff4d8;
            color: #855500;
            padding: 12px;
            border-radius: 9px;
        }
    </style>
</head>

<body>
    <header>
        <a class="logo" href="{{ route('home') }}">EduQuest.</a>
    </header>

    <main>
        <div class="card">
            <h1>Hasil Kuis</h1>
            <h2>{{ $result['quiz_title'] }}</h2>

            @if ($result['expired'])
                <p class="alert">
                    Waktu pengerjaan telah habis. Nilai dihitung tanpa memberikan poin
                    untuk jawaban yang masuk setelah batas waktu.
                </p>
            @endif

            <div class="score">
                {{ $result['score'] }} / {{ $result['total_points'] }}
            </div>

            <p class="muted">Total poin yang diperoleh</p>

            <h3>
                {{ $result['correct_answers'] }} dari
                {{ $result['total_questions'] }} jawaban benar
            </h3>

            @if ($result['total_points'] > 0)
                <p>
                    Nilai:
                    <strong>
                        {{ round(($result['score'] / $result['total_points']) * 100) }}%
                    </strong>
                </p>
            @endif


            @if ($result['is_student'])
                @if ($result['first_student_attempt'])
                    <h3>⭐ XP diperoleh: {{ $result['xp_awarded'] }} XP</h3>
                    <p class="muted">
                        Kamu memperoleh 10 XP untuk setiap jawaban benar pada
                        percobaan pertama kuis ini.
                    </p>
                @else
                    <h3>⭐ XP tambahan: 0 XP</h3>
                    <p class="muted">
                        XP untuk kuis ini hanya diberikan pada percobaan pertama.
                        Nilai percobaanmu saat ini tetap dicatat.
                    </p>
                @endif
            @elseif ($result['is_guest'])
                <p class="muted">
                    Hasil kuis ini dicatat sebagai percobaan Guest. Login atau daftar
                    untuk menyimpan progres belajar pada akunmu.
                </p>
            @else
                <p class="muted">
                    Hasil kuis berhasil dicatat. XP diberikan kepada akun siswa,
                    bukan akun guru atau admin.
                </p>
            @endif

            <a class="button" href="{{ route('quizzes.index') }}">Kuis Lainnya</a>
            <a class="button secondary" href="{{ route('home') }}">Beranda</a>
        </div>
    </main>
</body>

</html>