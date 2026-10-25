<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduQuest - Belajar Jadi Petualangan</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --primary: #6558e8;
            --primary-dark: #5144cc;
            --dark: #202044;
            --muted: #70718c;
            --background: #f8f8ff;
            --white: #ffffff;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            color: var(--dark);
            background: var(--background);
            line-height: 1.6;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        .container {
            width: min(1120px, 90%);
            margin: 0 auto;
        }

        header {
            background: rgba(255, 255, 255, 0.95);
            border-bottom: 1px solid #ededf7;
        }

        .navbar {
            min-height: 76px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 24px;
        }

        .logo {
            color: var(--primary);
            font-size: 27px;
            font-weight: 800;
            letter-spacing: -1px;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 28px;
            color: #555570;
            font-size: 14px;
            font-weight: 600;
        }

        .nav-links a:hover {
            color: var(--primary);
        }

        .button {
            display: inline-block;
            padding: 12px 20px;
            border-radius: 12px;
            background: var(--primary);
            color: white;
            font-weight: 700;
            transition: 0.2s;
        }

        .button:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
        }

        .button-light {
            background: white;
            color: var(--primary);
            border: 1px solid #e5e2ff;
        }

        .button-light:hover {
            background: #f0eeff;
        }

        .hero {
            padding: 75px 0 85px;
            background:
                radial-gradient(circle at 85% 20%, #e6e3ff 0, transparent 28%),
                linear-gradient(135deg, #fafaff, #f0efff);
        }

        .hero-grid {
            display: grid;
            grid-template-columns: 1.1fr 0.9fr;
            gap: 55px;
            align-items: center;
        }

        .eyebrow {
            display: inline-block;
            padding: 8px 13px;
            border-radius: 30px;
            color: var(--primary);
            background: #e9e7ff;
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 22px;
        }

        h1 {
            font-size: clamp(38px, 5vw, 58px);
            line-height: 1.12;
            letter-spacing: -2px;
            margin-bottom: 22px;
        }

        h1 span {
            color: var(--primary);
        }

        .hero-description {
            color: var(--muted);
            font-size: 17px;
            max-width: 510px;
            margin-bottom: 30px;
        }

        .hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }

        .hero-note {
            margin-top: 22px;
            font-size: 13px;
            color: var(--muted);
        }

        .learning-card {
            background: white;
            padding: 28px;
            border: 1px solid #eeeeFA;
            border-radius: 24px;
            box-shadow: 0 20px 60px rgba(70, 60, 150, 0.12);
            transform: rotate(1deg);
        }

        .learning-card h3 {
            font-size: 19px;
            margin-bottom: 6px;
        }

        .card-description {
            font-size: 13px;
            color: var(--muted);
            margin-bottom: 24px;
        }

        .progress-box {
            background: #f5f4ff;
            padding: 17px;
            border-radius: 16px;
            margin-bottom: 14px;
        }

        .progress-header {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .progress-track {
            height: 9px;
            border-radius: 20px;
            background: #dedbfa;
            overflow: hidden;
        }

        .progress-fill {
            height: 100%;
            width: 0;
            background: var(--primary);
            border-radius: 20px;
            transition: width 0.3s ease;
        }

        .mini-stats {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-top: 18px;
        }

        .mini-stat {
            padding: 16px;
            border-radius: 15px;
            background: #fff7e7;
        }

        .mini-stat:nth-child(2) {
            background: #e9f9f0;
        }

        .mini-stat strong {
            display: block;
            font-size: 22px;
        }

        .mini-stat span {
            font-size: 12px;
            color: var(--muted);
        }

        section {
            padding: 75px 0;
        }

        .section-heading {
            text-align: center;
            max-width: 650px;
            margin: 0 auto 40px;
        }

        .section-heading h2 {
            font-size: clamp(27px, 4vw, 37px);
            line-height: 1.2;
            margin-bottom: 13px;
        }

        .section-heading p {
            color: var(--muted);
        }

        .subject-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 22px;
        }

        .subject-card {
            background: white;
            padding: 25px;
            border: 1px solid #ededf7;
            border-radius: 20px;
            transition: 0.2s;
        }

        .subject-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 30px rgba(70, 60, 150, 0.09);
        }

        .subject-icon {
            width: 56px;
            height: 56px;
            display: grid;
            place-items: center;
            border-radius: 17px;
            background: #eeecff;
            font-size: 28px;
            margin-bottom: 18px;
        }

        .subject-card:nth-child(2) .subject-icon {
            background: #e3f8ec;
        }

        .subject-card:nth-child(3) .subject-icon {
            background: #fff0df;
        }

        .subject-card h3 {
            margin-bottom: 8px;
        }

        .subject-card p {
            color: var(--muted);
            font-size: 14px;
            margin-bottom: 18px;
        }

        .text-link {
            color: var(--primary);
            font-size: 14px;
            font-weight: 700;
        }

        .features {
            background: white;
        }

        .feature-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
        }

        .feature {
            text-align: center;
            padding: 15px;
        }

        .feature-icon {
            font-size: 32px;
            margin-bottom: 12px;
        }

        .feature h3 {
            margin-bottom: 8px;
        }

        .feature p {
            color: var(--muted);
            font-size: 14px;
        }

        .cta {
            text-align: center;
            padding: 48px 25px;
            border-radius: 25px;
            background: linear-gradient(135deg, #6558e8, #8977f5);
            color: white;
        }

        .cta h2 {
            font-size: clamp(26px, 4vw, 36px);
            margin-bottom: 12px;
        }

        .cta p {
            color: #eeecff;
            margin-bottom: 24px;
        }

        footer {
            padding: 28px 0;
            background: white;
            border-top: 1px solid #ededf7;
            color: var(--muted);
            font-size: 13px;
        }

        .footer-content {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
        }

        @media (max-width: 800px) {
            .hero-grid {
                grid-template-columns: 1fr;
                gap: 40px;
            }

            .subject-grid,
            .feature-grid {
                grid-template-columns: 1fr;
            }

            .nav-links {
                gap: 12px;
                flex-wrap: wrap;
            }

            .navbar {
                padding: 15px 0;
                align-items: flex-start;
            }

            .hero {
                padding: 55px 0;
            }
        }

        @media (max-width: 520px) {
            .navbar {
                flex-direction: column;
            }

            .nav-links {
                gap: 16px;
            }

            h1 {
                letter-spacing: -1px;
            }
        }

        .progress-track {
            width: 100%;
            height: 8px;
            overflow: hidden;
            border-radius: 999px;
            background: #e5e7eb;
        }

        .progress-fill {
            height: 100%;
            border-radius: 999px;
            background: #6366f1;
            transition: width 0.3s ease;
        }
    </style>
</head>

<body>
    <header>
        <div class="container navbar">
            <a class="logo" href="#beranda">EduQuest.</a>


            <nav class="nav-links">
                <a href="#beranda">Beranda</a>
                <a href="{{ route('materials.index') }}">Materi</a>
                <a href="{{ route('quizzes.index') }}">Kuis</a>
                <a href="#fitur">Fitur</a>
                <a href="#bergabung">Tentang</a>

                <a href="{{ route('login') }}">Sign In</a>
                <a class="button" href="{{ route('register') }}">Sign Up</a>
            </nav>

        </div>
    </header>

    <main>
        <section class="hero" id="beranda">
            <div class="container hero-grid">
                <div>
                    <span class="eyebrow">✨ Teman Belajar SMP & SMA</span>

                    <h1>
                        Belajar Jadi <span>Petualangan</span> Seru!
                    </h1>

                    <p class="hero-description">
                        Jelajahi materi pelajaran, tantang dirimu dengan kuis,
                        kumpulkan poin, dan jadilah juara di EduQuest.
                    </p>

                    <div class="hero-actions">
                        <a href="#materi" class="button">
                            Jelajahi Materi →
                        </a>
                        <a href="#fitur" class="button button-light">
                            Kenali EduQuest
                        </a>
                    </div>

                    <p class="hero-note">
                        📚 Belajar fleksibel · 🎯 Tantangan seru · 🏆 Raih prestasi
                    </p>
                </div>


                <div class="learning-card">
                    <h3>🚀 Perjalanan Belajarmu</h3>
                    <p class="card-description">
                        Setiap langkah kecil membawamu lebih dekat ke tujuan.
                    </p>

                    @auth
                    @php
                    $homeXp = (int) auth()->user()->xp;
                    $homeMaterialsCompleted = auth()->user()
                    ->materialCompletions()
                    ->count();

                    $dailyGoal = 3;

                    $todayQuizzes = auth()->user()
                    ->quizAttempts()
                    ->whereNotNull('completed_at')
                    ->whereDate('completed_at', today())
                    ->distinct('quiz_id')
                    ->count('quiz_id');

                    $dailyProgress = min(
                    100,
                    (int) round(($todayQuizzes / $dailyGoal) * 100)
                    );
                    @endphp

                    <div class="progress-box">
                        <div class="progress-header">
                            <span>Target belajar harian</span>
                            <span>{{ $dailyProgress }}%</span>
                        </div>

                        <div class="progress-track"
                            role="progressbar"
                            aria-label="Progres target belajar harian"
                            aria-valuemin="0"
                            aria-valuemax="100"
                            aria-valuenow="{{ $dailyProgress }}">
                            <div class="progress-fill"
                                @style(['width'=> $dailyProgress . '%'])></div>
                        </div>

                        <p class="card-description" style="margin: 10px 0 0;">
                            {{ $todayQuizzes }} dari {{ $dailyGoal }} kuis selesai hari ini.
                        </p>
                    </div>

                    <div class="mini-stats">
                        <div class="mini-stat">
                            <strong>📖 {{ $homeMaterialsCompleted }}</strong>
                            <span>Materi selesai</span>
                        </div>

                        <div class="mini-stat">
                            <strong>⭐ {{ number_format($homeXp) }}</strong>
                            <span>Total XP</span>
                        </div>
                    </div>
                    @else
                    <div class="progress-box">
                        <div class="progress-header">
                            <span>Perjalanan belajarmu dimulai di sini</span>
                            <span>0%</span>
                        </div>

                        <div class="progress-track">
                            <div class="progress-fill" style="width: 0%"></div>
                        </div>
                    </div>

                    <div class="mini-stats">
                        <div class="mini-stat">
                            <strong>📖 Materi</strong>
                            <span>Tandai materi yang selesai</span>
                        </div>

                        <div class="mini-stat">
                            <strong>⭐ XP</strong>
                            <span>Kumpulkan poin dari kuis</span>
                        </div>
                    </div>

                    <p class="card-description" style="margin: 18px 0 0;">
                        Masuk atau daftar untuk mulai mencatat perjalanan belajarmu.
                    </p>
                    @endauth
                </div>
            </div>
        </section>

        <section id="materi">
            <div class="container">
                <div class="section-heading">
                    <h2>Temukan Materi Favoritmu</h2>
                    <p>
                        Mulai menjelajahi berbagai bidang pelajaran dan
                        temukan cara belajar yang cocok untukmu.
                    </p>
                </div>

                <div class="subject-grid">
                    <article class="subject-card">
                        <div class="subject-icon">🔢</div>
                        <h3>Matematika</h3>
                        <p>
                            Latih kemampuan berhitung dan pecahkan soal
                            dengan cara yang menyenangkan.
                        </p>
                        <a class="text-link" href="{{ route('materials.index', ['subject' => 'matematika']) }}">
                            Jelajahi materi →
                        </a>
                    </article>

                    <article class="subject-card">
                        <div class="subject-icon">🔬</div>
                        <h3>Ilmu Pengetahuan Alam</h3>
                        <p>
                            Kenali sains, alam, dan berbagai fenomena
                            menarik di sekitarmu.
                        </p>
                        <a class="text-link" href="{{ route('materials.index', ['subject' => 'ipa']) }}">
                            Jelajahi materi →
                        </a>
                    </article>

                    <article class="subject-card">
                        <div class="subject-icon">🌍</div>
                        <h3>Bahasa Inggris</h3>
                        <p>
                            Perluas kosakata dan latih kemampuan bahasa
                            melalui aktivitas belajar.
                        </p>
                        <a class="text-link" href="{{ route('materials.index', ['subject' => 'bahasa-inggris']) }}">
                            Jelajahi materi →
                        </a>
                    </article>
                </div>
            </div>
        </section>

        <section class="features" id="fitur">
            <div class="container">
                <div class="section-heading">
                    <h2>Satu Tempat untuk Belajar dan Berkembang</h2>
                    <p>
                        EduQuest dirancang agar belajar lebih terarah,
                        interaktif, dan memotivasi.
                    </p>
                </div>

                <div class="feature-grid">
                    <div class="feature">
                        <div class="feature-icon">📚</div>
                        <h3>Materi Terstruktur</h3>
                        <p>
                            Pelajari materi sesuai kategori dan topik
                            yang ingin kamu kuasai.
                        </p>
                    </div>

                    <div class="feature">
                        <div class="feature-icon">🧩</div>
                        <h3>Kuis Interaktif</h3>
                        <p>
                            Uji pemahamanmu dengan latihan soal dan
                            dapatkan hasil pengerjaan.
                        </p>
                    </div>

                    <div class="feature">
                        <div class="feature-icon">🏆</div>
                        <h3>Leaderboard</h3>
                        <p>
                            Pantau perolehan poin dan semangat belajar
                            bersama pengguna lainnya.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <section id="bergabung">
            <div class="container">
                <div class="cta">
                    <h2>Siap Memulai Petualangan Belajarmu?</h2>
                    <p>
                        Mulai dengan menjelajahi halaman EduQuest.
                        Fitur akun dan penyimpanan progres akan kita bangun
                        pada tahap berikutnya.
                    </p>
                    <a href="#materi" class="button button-light">
                        Mulai Jelajahi Materi
                    </a>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <div class="container footer-content">
            <strong>EduQuest.</strong>
            <span>© 2026 EduQuest — Belajar, Bertumbuh, Berprestasi.</span>
        </div>
    </footer>
</body>

</html>