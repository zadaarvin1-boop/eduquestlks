<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $material->title }} - EduQuest</title>

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
        }

        .logo {
            color: #6558e8;
            font-size: 25px;
            font-weight: 800;
            text-decoration: none;
        }

        main {
            width: min(850px, 90%);
            margin: 40px auto;
            background: white;
            border: 1px solid #ecebf5;
            border-radius: 20px;
            padding: clamp(22px, 5vw, 45px);
        }

        .muted {
            color: #70718c;
            line-height: 1.7;
        }

        .tag {
            display: inline-block;
            color: #5144cc;
            background: #efedff;
            border-radius: 20px;
            padding: 6px 12px;
            font-size: 13px;
            font-weight: 700;
        }

        h1 {
            line-height: 1.25;
        }

        .content {
            margin-top: 28px;
            line-height: 1.9;
            white-space: pre-line;
            overflow-wrap: anywhere;
        }

        .link {
            display: inline-block;
            margin-top: 28px;
            color: #6558e8;
            font-weight: 700;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <header>
        <a href="{{ route('home') }}" class="logo">EduQuest.</a>
    </header>

    <main>
        <a class="link" href="{{ route('materials.index') }}">← Kembali ke daftar materi</a>

        <p>
            <span class="tag">
                {{ $material->subject->name }} · Kelas {{ $material->grade }}
            </span>
        </p>

        <h1>{{ $material->title }}</h1>

        @if ($material->summary)
            <p class="muted">{{ $material->summary }}</p>
        @endif

        <hr style="border: 0; border-top: 1px solid #ecebf5; margin: 25px 0;">

        <div class="content">{{ $material->content }}</div>

        <hr style="border: 0; border-top: 1px solid #ecebf5; margin: 25px 0;">

        @if (session('success'))
            <p class="muted">{{ session('success') }}</p>
        @endif

        @auth
            @php
                $isCompleted = \App\Models\MaterialCompletion::where(
                    'user_id',
                    auth()->id()
                )->where(
                        'material_id',
                        $material->id
                    )->exists();
            @endphp

            @if ($isCompleted)
                <p class="muted">
                    ✅ Materi ini sudah selesai dipelajari.
                </p>
            @else
                <form action="{{ route('materials.complete', $material->slug) }}" method="POST">
                    @csrf

                    <button type="submit" style="background: #6558e8; color: white; border: 0;
                               padding: 12px 20px; border-radius: 10px;
                               font-weight: bold; cursor: pointer;">
                        Tandai Selesai Dipelajari
                    </button>
                </form>
            @endif
        @else
            <p class="muted">
                Masuk ke akun untuk menandai materi sebagai selesai dipelajari.
            </p>
        @endauth

    </main>
</body>

</html>
</body>

</html>