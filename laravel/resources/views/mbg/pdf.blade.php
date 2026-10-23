@php
    $reportTheme = request('theme') === 'dark' ? 'dark' : 'light';
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Laporan MBG - {{ \Carbon\Carbon::parse($selectedDate)->translatedFormat('d F Y') }}</title>
    <style>
        :root {
            --pdf-bg: #ffffff;
            --pdf-text: #1f2937;
            --pdf-subtle: #526a82;
            --pdf-border: #dfeaf5;
            --pdf-header: #15324d;
            --pdf-panel: #f4f9ff;
            --pdf-table-head: #edf7ff;
        }

        body[data-theme="dark"] {
            --pdf-bg: #0d1723;
            --pdf-text: #edf6ff;
            --pdf-subtle: #bdd7f2;
            --pdf-border: rgba(169, 214, 255, 0.18);
            --pdf-header: #eaf6ff;
            --pdf-panel: #122536;
            --pdf-table-head: #162f45;
        }

        body {
            font-family: Arial, sans-serif;
            color: var(--pdf-text);
            background: var(--pdf-bg);
            margin: 30px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #2f7ed1;
            padding-bottom: 12px;
        }

        h1 {
            margin: 0;
            font-size: 24px;
            color: var(--pdf-header);
        }

        .subtitle {
            margin-top: 6px;
            font-size: 13px;
            color: var(--pdf-subtle);
        }

        .summary {
            display: flex;
            justify-content: space-between;
            margin: 18px 0;
            font-size: 14px;
        }

        .summary-box {
            border: 1px solid var(--pdf-border);
            background: var(--pdf-panel);
            border-radius: 8px;
            padding: 12px 16px;
            width: 48%;
        }

        .summary-box strong {
            display: block;
            font-size: 18px;
            margin-top: 6px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
            font-size: 12px;
        }

        th, td {
            border: 1px solid var(--pdf-border);
            padding: 8px;
            text-align: left;
        }

        th {
            background: var(--pdf-table-head);
            color: var(--pdf-header);
        }

        .footer {
            margin-top: 24px;
            font-size: 11px;
            color: var(--pdf-subtle);
            text-align: right;
        }
    </style>
</head>
<body data-theme="{{ $reportTheme }}">
    <div class="header">
        <h1>Laporan Pengambilan MBG</h1>
        <div class="subtitle">Tanggal: {{ \Carbon\Carbon::parse($selectedDate)->translatedFormat('d F Y') }}</div>
    </div>

    <div class="summary">
        <div class="summary-box">
            Total Penerima
            <strong>{{ $totalPenerima }}</strong>
        </div>
        <div class="summary-box">
            Total Porsi
            <strong>{{ $totalPorsi }}</strong>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Kelas</th>
                <th>Jumlah</th>
                <th>Waktu</th>
                <th>Catatan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($records as $index => $record)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $record->nama }}</td>
                    <td>{{ $record->kelas }}</td>
                    <td>{{ $record->jumlah }}</td>
                    <td>{{ \Carbon\Carbon::parse($record->waktu_pengambilan)->translatedFormat('d M Y, H:i') }}</td>
                    <td>{{ $record->catatan ?: '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center;">Tidak ada data pengambilan pada tanggal ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dibuat otomatis oleh sistem MBG Tracker
    </div>
</body>
</html>
