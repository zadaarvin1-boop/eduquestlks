<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - EduQuest</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0; font-family: Arial, sans-serif;
            background: #f5f4ff; color: #202044;
            min-height: 100vh; display: grid; place-items: center;
            padding: 24px;
        }
        .card {
            background: white; width: 100%; max-width: 430px;
            padding: 32px; border-radius: 20px;
            box-shadow: 0 15px 45px #38308015;
        }
        .logo { color: #6558e8; font-size: 27px; font-weight: 800; text-decoration: none; }
        h1 { margin-bottom: 8px; }
        p { color: #70718c; font-size: 14px; line-height: 1.5; }
        label { display: block; margin: 18px 0 7px; font-weight: 600; font-size: 14px; }
        input[type=email], input[type=password] {
            width: 100%; padding: 12px; border: 1px solid #deddee;
            border-radius: 9px; font: inherit;
        }
        button {
            width: 100%; margin-top: 22px; padding: 13px;
            border: 0; border-radius: 10px; background: #6558e8;
            color: white; font-weight: 700; font-size: 15px; cursor: pointer;
        }
        .remember { display: flex; align-items: center; gap: 8px; margin-top: 16px; font-size: 14px; }
        .error { color: #b42318; font-size: 13px; margin-top: 5px; }
        .alert { padding: 12px; background: #fff0f0; border-radius: 9px; }
        .footer { text-align: center; margin-top: 20px; font-size: 14px; }
        a { color: #6558e8; font-weight: 600; }
    </style>
</head>
<body>
    <main class="card">
        <a class="logo" href="{{ route('home') }}">EduQuest.</a>
        <h1>Selamat datang kembali!</h1>
        <p>Masuk untuk melanjutkan petualangan belajarmu.</p>

        @if ($errors->any())
            <div class="alert">
                @foreach ($errors->all() as $error)
                    <div class="error">{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('login.store') }}">
            @csrf

            <label for="email">Email</label>
            <input id="email" type="email" name="email"
                   value="{{ old('email') }}" autocomplete="email" required>
            @error('email') <div class="error">{{ $message }}</div> @enderror

            <label for="password">Password</label>
            <input id="password" type="password" name="password"
                   autocomplete="current-password" required>

            <label class="remember">
                <input type="checkbox" name="remember" value="1">
                Ingat saya di perangkat ini
            </label>

            <button type="submit">Masuk</button>
        </form>

        <div class="footer">
            Belum punya akun?
            <a href="{{ route('register') }}">Daftar sekarang</a>
        </div>
    </main>
</body>
</html>
