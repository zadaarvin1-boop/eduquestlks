<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Kelola Kuis - EduQuest')</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f7fb;
            color: #1e293b;
        }

        header {
            background: #4338ca;
            color: white;
            padding: 18px 24px;
        }

        header a {
            color: white;
            text-decoration: none;
            font-size: 20px;
            font-weight: bold;
        }

        main {
            width: min(1000px, 92%);
            margin: 30px auto;
        }

        .card {
            background: white;
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 3px 12px rgba(0, 0, 0, 0.05);
            margin-bottom: 20px;
        }

        h1 {
            margin-top: 0;
            font-size: 26px;
        }

        .muted {
            color: #64748b;
        }

        .actions {
            display: flex;
            gap: 8px;
            align-items: center;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-block;
            padding: 10px 14px;
            border: none;
            border-radius: 7px;
            text-decoration: none;
            cursor: pointer;
            font-size: 14px;
            font-weight: bold;
        }

        .primary {
            background: #4338ca;
            color: white;
        }

        .secondary {
            background: #e2e8f0;
            color: #1e293b;
        }

        .warning {
            background: #fef3c7;
            color: #92400e;
        }

        .danger {
            background: #fee2e2;
            color: #b91c1c;
        }

        .field {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-weight: bold;
        }

        input:not([type="checkbox"]),
        select,
        textarea {
            width: 100%;
            padding: 11px;
            border: 1px solid #cbd5e1;
            border-radius: 7px;
            font: inherit;
            background: white;
        }

        textarea {
            min-height: 100px;
            resize: vertical;
        }

        .checkbox-row {
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 18px 0;
        }

        .checkbox-row label {
            margin: 0;
        }

        .success {
            background: #dcfce7;
            color: #166534;
            padding: 12px;
            border-radius: 7px;
            margin-bottom: 18px;
        }

        .error {
            color: #b91c1c;
            font-size: 14px;
            margin-top: 5px;
        }

        .badge {
            padding: 5px 9px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            white-space: nowrap;
        }

        .published {
            background: #dcfce7;
            color: #166534;
        }

        .draft {
            background: #f1f5f9;
            color: #475569;
        }

        .table-wrap {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 650px;
        }

        th, td {
            text-align: left;
            padding: 13px 10px;
            border-bottom: 1px solid #e2e8f0;
        }

        th {
            background: #f8fafc;
            font-size: 13px;
        }

        form {
            margin: 0;
        }

        @media (max-width: 600px) {
            .card {
                padding: 17px;
            }

            h1 {
                font-size: 22px;
            }
        }
    </style>
</head>
<body>
    <header>
        <a href="{{ route('teacher.quizzes.index') }}">EduQuest | Kelola Kuis</a>
    </header>

    <main>
        @if (session('success'))
            <div class="success">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>
