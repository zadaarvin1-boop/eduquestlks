<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pencapaian Saya | EduQuest</title>

    <style>
        :root {
            --primary: #635bff;
            --primary-light: #eeedff;
            --background: #f6f7fb;
            --text: #20243a;
            --muted: #73788c;
            --success: #15966a;
            --border: #e8eaf2;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: var(--background);
            color: var(--text);
            font-family: Arial, sans-serif;
        }

        .container {
            width: min(1100px, 92%);
            margin: 40px auto;
        }

        .back-link {
            display: inline-block;
            margin-bottom: 24px;
            color: var(--primary);
            text-decoration: none;
            font-weight: 700;
        }

        .hero {
            padding: 32px;
            border-radius: 22px;
            color: white;
            background: linear-gradient(135deg, #635bff, #8b5cf6);
        }

        .hero h1 {
            margin: 0 0 10px;
            font-size: 30px;
        }

        .hero p {
            margin: 0;
            line-height: 1.7;
            opacity: .92;
        }

        .progress-area {
            margin-top: 24px;
        }

        .progress-info {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 10px;
            font-size: 14px;
        }

        .progress-track {
            height: 10px;
            overflow: hidden;
            border-radius: 20px;
            background: rgba(255, 255, 255, .3);
        }

        .progress-fill {
            height: 100%;
            width: var(--progress, 0%);
            border-radius: inherit;
            background: white;
            transition: width .3s ease;
        }

        .section-heading {
            margin: 34px 0 18px;
        }

        .section-heading h2 {
            margin: 0 0 7px;
            font-size: 22px;
        }

        .section-heading p {
            margin: 0;
            color: var(--muted);
        }

        .badge-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 18px;
        }

        .badge-card {
            padding: 24px;
            background: white;
            border: 1px solid var(--border);
            border-radius: 18px;
            box-shadow: 0 5px 20px rgba(25, 35, 70, .035);
        }

        .badge-card.earned {
            border-color: #c6eadb;
            background: linear-gradient(180deg, #fff, #f5fffa);
        }

        .badge-icon {
            display: grid;
            width: 58px;
            height: 58px;
            place-items: center;
            margin-bottom: 18px;
            border-radius: 16px;
            background: var(--primary-light);
            font-size: 28px;
        }

        .badge-card:not(.earned) .badge-icon {
            filter: grayscale(1);
            opacity: .55;
        }

        .badge-card h3 {
            margin: 0 0 9px;
            font-size: 17px;
        }

        .badge-card p {
            min-height: 42px;
            margin: 0 0 18px;
            color: var(--muted);
            font-size: 14px;
            line-height: 1.6;
        }

        .badge-status {
            display: inline-block;
            padding: 7px 11px;
            border-radius: 20px;
            background: #f0f1f5;
            color: #686d7e;
            font-size: 12px;
            font-weight: 700;
        }

        .earned .badge-status {
            background: #dcf8eb;
            color: var(--success);
        }

        .earned-date {
            margin-top: 12px;
            color: var(--muted);
            font-size: 12px;
        }

        @media (max-width: 760px) {
            .badge-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .hero {
                padding: 24px;
            }
        }

        @media (max-width: 480px) {
            .badge-grid {
                grid-template-columns: 1fr;
            }

            .hero h1 {
                font-size: 25px;
            }
        }
    </style>
</head>

<body>
    <main class="container">
        <a href="{{ route('dashboard') }}" class="back-link">
            ← Kembali ke Dashboard
        </a>

        <section class="hero">
            <h1>🏆 Pencapaian Saya</h1>
            <p>
                Terus belajar, selesaikan tantangan, dan kumpulkan
                semua lencana EduQuest!
            </p>


            <div class="progress-area">
                <div class="progress-info">
                    <span>Lencana diperoleh</span>
                    <strong>{{ $totalEarned }} dari {{ $totalBadges }}</strong>
                </div>

                <div
                    class="progress-track"
                    role="progressbar"
                    aria-valuenow="{{ $progress }}"
                    aria-valuemin="0"
                    aria-valuemax="100"
                    aria-label="Progres pencapaian">
                    <div
                        class="progress-fill"
                        style="--progress: {{ (int) $progress }}%;"></div>
                </div>

                <p style="margin-top: 10px">
                    {{ $progress }}% pencapaian selesai
                </p>
            </div>
        </section>


        <section class="section-heading">
            <h2>Semua Lencana</h2>
            <p>
                Lencana yang sudah diperoleh dan tantangan yang masih
                bisa kamu selesaikan.
            </p>
        </section>

        <section class="badge-grid">
            @forelse ($badges as $badge)
            @php
            $earned = in_array($badge->id, $earnedBadgeIds);
            $earnedRecord = $earnedBadges->get($badge->id);

            $icons = [
            'award' => '🏅',
            'book-open' => '📚',
            'trophy' => '🏆',
            'star' => '⭐',
            'crown' => '👑',
            ];

            $icon = $icons[$badge->icon] ?? '🎖️';
            @endphp

            <article class="badge-card {{ $earned ? 'earned' : '' }}">
                <div class="badge-icon" aria-hidden="true">
                    {{ $icon }}
                </div>

                <h3>{{ $badge->name }}</h3>
                <p>{{ $badge->description }}</p>

                @if ($earned)
                <span class="badge-status">
                    ✓ Berhasil diperoleh
                </span>

                <div class="earned-date">
                    Diperoleh:
                    {{ $earnedRecord->pivot->earned_at
                                ? \Illuminate\Support\Carbon::parse(
                                    $earnedRecord->pivot->earned_at
                                )->format('d M Y')
                                : 'Tanggal tidak tersedia' }}
                </div>
                @else
                <span class="badge-status">
                    Belum diperoleh
                </span>
                @endif
            </article>
            @empty
            <p>Belum ada lencana yang tersedia.</p>
            @endforelse
        </section>
    </main>
</body>

</html>