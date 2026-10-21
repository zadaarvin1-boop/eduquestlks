<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - EduQuest</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 24px;
            min-height: 100vh;
            display: grid;
            place-items: center;
            font-family: Arial, sans-serif;
            color: #202044;
            background: #f5f4ff;
        }

        .card {
            width: 100%;
            max-width: 460px;
            padding: 32px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 15px 45px rgba(56, 48, 128, 0.08);
        }

        .logo {
            color: #6558e8;
            font-size: 27px;
            font-weight: 800;
            text-decoration: none;
        }

        h1 {
            margin-bottom: 8px;
        }

        .muted {
            color: #70718c;
            font-size: 14px;
            line-height: 1.6;
        }

        label {
            display: block;
            margin: 16px 0 7px;
            font-size: 14px;
            font-weight: 600;
        }

        input,
        select {
            width: 100%;
            padding: 12px;
            border: 1px solid #deddee;
            border-radius: 9px;
            font: inherit;
            background: white;
        }

        input:focus,
        select:focus {
            outline: 2px solid #c7c2ff;
            border-color: #6558e8;
        }

        button {
            width: 100%;
            margin-top: 22px;
            padding: 13px;
            border: 0;
            border-radius: 10px;
            background: #6558e8;
            color: white;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
        }

        button:hover {
            background: #5144cc;
        }

        .error {
            margin-top: 5px;
            color: #b42318;
            font-size: 13px;
        }

        .alert {
            padding: 12px;
            border-radius: 9px;
            background: #fff0f0;
        }

        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 14px;
        }

        a {
            color: #6558e8;
        }

        .footer a {
            font-weight: 600;
        }
    </style>
</head>

<body>
    <main class="card">
        <a class="logo" href="{{ route('home') }}">EduQuest.</a>

        <h1>Buat akun baru</h1>
        <p class="muted">
            Daftar untuk menyimpan nilai, XP, dan progres belajarmu.
        </p>

        @if ($errors->any())
            <div class="alert">
                <strong>Periksa kembali data kamu.</strong>

                @foreach ($errors->all() as $error)
                    <div class="error">{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('register.store') }}">
            @csrf

            <label for="name">Nama lengkap</label>
            <input
                id="name"
                name="name"
                value="{{ old('name') }}"
                autocomplete="name"
                maxlength="255"
                required
            >
            @error('name')
                <div class="error">{{ $message }}</div>
            @enderror

            <label for="email">Email</label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                autocomplete="email"
                maxlength="255"
                required
            >
            @error('email')
                <div class="error">{{ $message }}</div>
            @enderror

            <label for="grade">Kelas</label>
            <select id="grade" name="grade" required>
                <option value="">Pilih kelas</option>

                @foreach (['7', '8', '9', '10', '11', '12'] as $grade)
                    <option
                        value="{{ $grade }}"
                        @selected(old('grade') == $grade)
                    >
                        Kelas {{ $grade }}
                    </option>
                @endforeach
            </select>
            @error('grade')
                <div class="error">{{ $message }}</div>
            @enderror

            <label for="password">Password (minimal 8 karakter)</label>
            <input
                id="password"
                type="password"
                name="password"
                autocomplete="new-password"
                minlength="8"
                required
            >
            @error('password')
                <div class="error">{{ $message }}</div>
            @enderror

            <label for="password_confirmation">Konfirmasi password</label>
            <input
                id="password_confirmation"
                type="password"
                name="password_confirmation"
                autocomplete="new-password"
                minlength="8"
                required
            >

            <button type="submit">Daftar Sekarang</button>
        </form>

        <div class="footer">
            Sudah punya akun?
            <a href="{{ route('login') }}">Masuk</a>
        </div>
    </main>
</body>
</html>
