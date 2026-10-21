<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Materi - EduQuest</title>

    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f7f7ff;
            color: #202044;
        }
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            padding: 18px 5%;
            background: white;
            border-bottom: 1px solid #ecebf5;
        }
        .logo {
            color: #6558e8;
            font-size: 24px;
            font-weight: 800;
            text-decoration: none;
        }
        main { width: min(1100px, 92%); margin: 32px auto; }
        .top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
            margin-bottom: 22px;
        }
        .muted { color: #70718c; line-height: 1.6; }
        .button {
            display: inline-block;
            padding: 10px 14px;
            border: 0;
            border-radius: 9px;
            background: #6558e8;
            color: white;
            text-decoration: none;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
        }
        .secondary { background: #efedff; color: #5144cc; }
        .danger { background: #fff0f0; color: #b42318; }
        .notice {
            background: #e9f9f0;
            color: #176b3a;
            padding: 13px 16px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .table-wrap {
            overflow-x: auto;
            background: white;
            border: 1px solid #ecebf5;
            border-radius: 14px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 720px;
        }
        th, td {
            padding: 15px;
            border-bottom: 1px solid #ecebf5;
            text-align: left;
            vertical-align: top;
        }
        th { background: #f5f4ff; font-size: 13px; }
        td { font-size: 14px; }
        .status {
            display: inline-block;
            padding: 5px 9px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
        }
        .published { color: #176b3a; background: #e9f9f0; }
        .draft { color: #855500; background: #fff4d8; }
        .actions { display: flex; flex-wrap: wrap; gap: 7px; }
        .actions form { margin: 0; }
        .empty {
            background: white;
            padding: 32px;
            text-align: center;
            border-radius: 14px;
        }
        .pagination { margin: 20px 0; }
        @media(max-width: 600px) {
            header { align-items: flex-start; flex-wrap: wrap; }
        }
    </style>
</head>

<body>
<header>
    <a class="logo" href="{{ route('home') }}">EduQuest.</a>

    <nav>
        <a class="button secondary" href="{{ route('materials.index') }}">
            Lihat Materi Publik
        </a>
        <a class="button secondary" href="{{ route('dashboard') }}">
            Dashboard
        </a>
    </nav>
</header>

<main>
    <div class="top">
        <div>
            <h1>Kelola Materi Pembelajaran</h1>
            <p class="muted">
                Tambahkan, perbarui, atau terbitkan materi EduQuest.
            </p>
        </div>

        <a class="button" href="{{ route('teacher.materials.create') }}">
            + Tambah Materi
        </a>
    </div>

    @if (session('success'))
        <div class="notice">{{ session('success') }}</div>
    @endif

    @if ($materials->isEmpty())
        <div class="empty">
            <h2>Belum ada materi yang dikelola</h2>
            <p class="muted">
                Tambahkan materi pertama untuk memulai.
            </p>
            <a class="button" href="{{ route('teacher.materials.create') }}">
                Tambah Materi
            </a>
        </div>
    @else
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Judul Materi</th>
                        <th>Mata Pelajaran</th>
                        <th>Kelas</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($materials as $material)
                        <tr>
                            <td>
                                <strong>{{ $material->title }}</strong>
                            </td>

                            <td>{{ $material->subject->name }}</td>
                            <td>{{ $material->grade }}</td>

                            <td>
                                @if ($material->is_published)
                                    <span class="status published">
                                        Dipublikasikan
                                    </span>
                                @else
                                    <span class="status draft">Draft</span>
                                @endif
                            </td>

                            <td>
                                <div class="actions">
                                    <a class="button secondary"
                                       href="{{ route('teacher.materials.edit', $material) }}">
                                        Edit
                                    </a>

                                    @if ($material->is_published)
                                        <a class="button secondary"
                                           href="{{ route('materials.show', $material->slug) }}">
                                            Lihat
                                        </a>
                                    @endif

                                    <form method="POST"
                                          action="{{ route('teacher.materials.destroy', $material) }}"
                                          onsubmit="return confirm('Yakin ingin menghapus materi ini?')">
                                        @csrf
                                        @method('DELETE')

                                        <button class="button danger" type="submit">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="pagination">
            {{ $materials->links() }}
        </div>
    @endif
</main>
</body>
</html>
