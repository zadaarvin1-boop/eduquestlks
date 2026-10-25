<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - EduQuest</title>

    <style>
        * {
            box-sizing: border-box;
        }

        :root {
            --ink: #20231f;
            --muted: #73776f;
            --line: #e5e7df;
            --paper: #f7f8f4;
            --green: #c9f36b;
            --white: #ffffff;
        }

        body {
            margin: 0;
            font-family: Arial, Helvetica, sans-serif;
            color: var(--ink);
            background: var(--paper);
            line-height: 1.6;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            padding: 20px max(6%, calc((100% - 1120px) / 2));
            background: var(--white);
            border-bottom: 1px solid var(--line);
        }

        .logo {
            font-size: 25px;
            font-weight: 800;
            letter-spacing: -1.2px;
        }

        .logo span {
            color: #638c20;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .container {
            width: min(1120px, 88%);
            margin: 42px auto;
        }

        .hero {
            padding: 36px;
            background: var(--white);
            border: 1px solid var(--line);
            border-radius: 18px;
        }

        .eyebrow {
            margin: 0 0 10px;
            color: #638c20;
            font-size: 12px;
            font-weight: 800;
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }

        h1,
        h2,
        h3,
        p {
            margin-top: 0;
        }

        h1 {
            margin-bottom: 12px;
            font-size: clamp(28px, 5vw, 44px);
            line-height: 1.15;
            letter-spacing: -1.8px;
        }

        h2 {
            font-size: 23px;
            letter-spacing: -0.6px;
        }

        .muted {
            color: var(--muted);
        }

        .hero .muted {
            max-width: 620px;
        }

        .role {
            display: inline-block;
            margin-top: 8px;
            padding: 5px 11px;
            border: 1px solid var(--line);
            border-radius: 30px;
            font-size: 13px;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 16px;
            margin: 22px 0 36px;
        }

        .stat {
            padding: 24px;
            background: var(--white);
            border: 1px solid var(--line);
            border-radius: 16px;
        }


        .level-card {
            margin: 22px 0;
            padding: 28px;
            background: #20231f;
            color: #ffffff;
            border-radius: 16px;
        }

        .level-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            margin-bottom: 24px;
        }

        .level-label {
            margin-bottom: 5px;
            color: #c9f36b;
            font-size: 12px;
            font-weight: 800;
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }

        .level-name {
            margin: 0;
            font-size: 30px;
            letter-spacing: -1px;
        }

        .level-badge {
            display: grid;
            place-items: center;
            width: 64px;
            height: 64px;
            flex-shrink: 0;
            border: 1px solid #53574e;
            border-radius: 14px;
            color: #c9f36b;
            font-size: 24px;
            font-weight: 800;
        }

        .level-progress-info {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 10px;
            font-size: 13px;
        }

        .level-track {
            height: 10px;
            overflow: hidden;
            background: #454940;
            border-radius: 99px;
        }

        .level-fill {
            height: 100%;
            background: #c9f36b;
            border-radius: 99px;
            transition: width 0.3s ease;
        }

        .level-note {
            margin: 12px 0 0;
            color: #d0d2cb;
            font-size: 13px;
        }

        @media (max-width: 700px) {
            .level-card {
                padding: 22px;
            }

            .level-name {
                font-size: 25px;
            }
        }


        .stat-label {
            display: block;
            color: var(--muted);
            font-size: 14px;
        }

        .stat strong {
            display: block;
            margin: 10px 0 5px;
            font-size: 36px;
            line-height: 1.2;
            letter-spacing: -1px;
        }

        .stat p {
            margin-bottom: 0;
            font-size: 13px;
        }

        .section {
            margin-top: 28px;
            padding: 28px;
            background: var(--white);
            border: 1px solid var(--line);
            border-radius: 16px;
        }

        .section-heading {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 16px;
            margin-bottom: 20px;
        }

        .section-heading h2 {
            margin-bottom: 4px;
        }

        .section-heading p {
            margin-bottom: 0;
        }

        .history-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            padding: 18px 0;
            border-top: 1px solid var(--line);
        }

        .history-item h3 {
            margin-bottom: 6px;
            font-size: 16px;
        }

        .history-item p {
            margin: 3px 0;
            color: var(--muted);
            font-size: 14px;
        }

        .history-item time {
            flex-shrink: 0;
            color: var(--muted);
            font-size: 12px;
        }

        .actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 22px;
        }

        .button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 11px 17px;
            border: 1px solid var(--ink);
            border-radius: 8px;
            background: var(--ink);
            color: var(--white);
            font: inherit;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: transform 0.15s ease, opacity 0.15s ease;
        }

        .button:hover {
            transform: translateY(-1px);
            opacity: 0.85;
        }

        .button.secondary {
            background: var(--white);
            color: var(--ink);
            border-color: var(--line);
        }

        .empty {
            padding: 20px 0 4px;
            color: var(--muted);
        }

        .badge-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 16px;
        }

        .badge-card {
            min-width: 0;
            padding: 22px;
            border: 1px solid var(--line);
            border-radius: 14px;
            background: var(--white);
        }

        .badge-card.earned {
            border-color: #d6e9a9;
            background: #fbfdf5;
        }

        .badge-card.locked {
            opacity: 0.68;
        }

        .badge-icon {
            display: grid;
            place-items: center;
            width: 52px;
            height: 52px;
            margin-bottom: 16px;
            border-radius: 14px;
            background: #edf0e7;
            font-size: 26px;
        }

        .badge-card.earned .badge-icon {
            background: var(--green);
        }

        .badge-card h3 {
            margin-bottom: 8px;
            font-size: 16px;
        }

        .badge-card p {
            min-height: 44px;
            margin-bottom: 14px;
            color: var(--muted);
            font-size: 13px;
        }

        .badge-status {
            font-size: 12px;
            font-weight: 700;
            color: #638c20;
        }

        .badge-card.locked .badge-status {
            color: var(--muted);
        }

        @media (max-width: 700px) {
            .badge-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 10px;
            }

            .badge-card {
                padding: 16px;
            }
        }

        @media (max-width: 420px) {
            .badge-grid {
                grid-template-columns: 1fr;
            }
        }

        footer {
            padding: 24px;
            color: var(--muted);
            text-align: center;
            font-size: 12px;
        }

        @media (max-width: 700px) {
            header {
                padding: 16px 6%;
            }

            .container {
                width: 90%;
                margin: 24px auto;
            }

            .hero,
            .section {
                padding: 22px;
            }

            .stats {
                grid-template-columns: 1fr;
                gap: 12px;
            }

            .section-heading,
            .history-item {
                align-items: flex-start;
                flex-direction: column;
            }

            .history-item time {
                white-space: normal;
            }
        }
    </style>
</head>

<body>
    <header>
        <a class="logo" href="{{ route('home') }}">EduQuest<span>.</span></a>

        <div class="header-actions">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="button secondary" type="submit">Keluar</button>
            </form>
        </div>
    </header>

    <main class="container">
        <section class="hero">
            <p class="eyebrow">Dashboard anggota</p>

            <h1>Halo, {{ $user->name }}!</h1>

            <p class="muted">
                Selamat datang kembali. Lanjutkan perjalanan belajarmu
                dan lihat perkembanganmu di EduQuest.
            </p>

            <span class="role">
                Peran: {{ ucfirst($user->role) }}
                @if ($user->grade)
                &middot; Kelas {{ $user->grade }}
                @endif
            </span>

            <div class="actions">
                <a class="button" href="{{ route('home') }}">Jelajahi EduQuest</a>

                @if (in_array($user->role, ['teacher', 'admin'], true))
                <a class="button secondary" href="{{ route('teacher.materials.index') }}">
                    Kelola Materi
                </a>

                <a class="button secondary" href="{{ route('teacher.quizzes.index') }}">
                    Kelola Kuis
                </a>
                @endif
            </div>
        </section>

        <section class="level-card" aria-label="Level dan progres XP">
            <div class="level-top">
                <div>
                    <p class="level-label">Perjalanan belajarmu</p>
                    <h2 class="level-name">
                        Level {{ $user->level }} &mdash; {{ $user->levelTitle }}
                    </h2>
                    <p class="level-note">
                        Total {{ number_format((int) $user->xp) }} XP terkumpul
                    </p>
                </div>

                <div class="level-badge">
                    {{ str_pad((string) $user->level, 2, '0', STR_PAD_LEFT) }}
                </div>
            </div>

            <div class="level-progress-info">
                <span>Progres level berikutnya</span>
                @if ($user->level < 5)
                    <strong>{{ $user->xpProgress }}%</strong>
                    @else
                    <strong>Level Maksimal</strong>
                    @endif
            </div>

            <div class="level-track"
                role="progressbar"
                aria-valuemin="0"
                aria-valuemax="100"
                aria-valuenow="{{ $user->xpProgress }}">
                <div class="level-fill"
                    @style(['width'=> $user->xpProgress . '%'])></div>
            </div>

            <p class="level-note">
                @if ($user->level < 5)
                    Butuh {{ number_format($user->xpToNextLevel) }} XP lagi
                    untuk mencapai Level {{ $user->level + 1 }}.
                    @else
                    Selamat! Kamu telah mencapai level tertinggi EduQuest.
                    @endif
                    </p>
        </section>

        <section class="stats" aria-label="Statistik pembelajaran">
            <article class="stat">
                <span class="stat-label">Materi selesai</span>
                <strong>{{ $materialsCompleted }}</strong>
                <p class="muted">Materi yang telah ditandai selesai.</p>
            </article>

            <article class="stat">
                <span class="stat-label">Kuis diselesaikan</span>
                <strong>{{ $quizzesCompleted }}</strong>
                <p class="muted">Jumlah kuis berbeda yang telah kamu kerjakan.</p>
            </article>

            <article class="stat">
                <span class="stat-label">Total XP</span>
                <strong>{{ $user->xp ?? 0 }}</strong>
                <p class="muted">Poin pengalaman belajarmu.</p>
            </article>
            {{-- Lencana Pencapaian --}}
            <section class="section">
                <div class="section-heading">
                    <div>
                        <h2>Lencana Pencapaian</h2>
                        <p class="muted">
                            Terus belajar dan kumpulkan semua lencana EduQuest.
                        </p>
                    </div>

                    <span class="role">
                        {{ count($earnedBadgeIds) }}/{{ $badges->count() }} diperoleh
                    </span>
                </div>

                <div class="badge-grid">
                    @forelse ($badges as $badge)
                    @php
                    $earned = in_array($badge->id, $earnedBadgeIds);
                    @endphp

                    <article class="badge-card {{ $earned ? 'earned' : 'locked' }}">
                        <div class="badge-icon" aria-hidden="true">
                            @if ($earned)
                            @switch($badge->icon)
                            @case('book-open')
                            📚
                            @break
                            @case('trophy')
                            🏆
                            @break
                            @case('star')
                            ⭐
                            @break
                            @case('crown')
                            👑
                            @break
                            @default
                            🏅
                            @endswitch
                            @else
                            🔒
                            @endif
                        </div>

                        <h3>{{ $badge->name }}</h3>

                        <p>{{ $badge->description }}</p>

                        <span class="badge-status">
                            {{ $earned ? '✓ Berhasil diperoleh' : 'Belum diperoleh' }}
                        </span>
                    </article>
                    @empty
                    <p class="empty">Belum ada lencana tersedia.</p>
                    @endforelse
                </div>
            </section>
        </section>

        <section class="section">
            <div class="section-heading">
                <div>
                    <h2>Riwayat kuis</h2>
                    <p class="muted">Lihat hasil dari kuis yang terakhir kamu selesaikan.</p>
                </div>

                <a class="button secondary" href="{{ route('home') }}">Kembali ke beranda</a>
            </div>

            @forelse ($recentAttempts as $attempt)
            <article class="history-item">
                <div>
                    <h3>
                        {{ $attempt->quiz?->title ?? 'Kuis tidak tersedia' }}
                    </h3>

                    <p>
                        Jawaban benar:
                        {{ $attempt->correct_answers }}/{{ $attempt->total_questions }}
                    </p>

                    <p>
                        Nilai:
                        {{ $attempt->score }}/{{ $attempt->total_points }}
                    </p>
                </div>

                @if ($attempt->completed_at)
                <time datetime="{{ $attempt->completed_at->toIso8601String() }}">
                    {{ $attempt->completed_at->format('d M Y, H:i') }}
                </time>
                @endif
            </article>
            @empty
            <p class="empty">
                Belum ada kuis yang diselesaikan. Yuk, coba kuis pertamamu!
            </p>
            @endforelse
        </section>
    </main>

    <footer>
        EduQuest &mdash; Belajar, berlatih, berkembang.
    </footer>
</body>

</html>