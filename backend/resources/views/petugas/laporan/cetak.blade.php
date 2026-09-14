<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Peminjaman</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f3f4f6;
            margin: 0;
            padding: 30px;
            color: #1f2937;
        }

        .page {
            max-width: 1100px;
            margin: 0 auto;
            background: #ffffff;
            padding: 24px 30px 18px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.08);
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 18px;
            font-size: 13px;
            color: #374151;
        }

        .header {
            text-align: center;
            margin-bottom: 12px;
        }

        .header h1 {
            margin: 0;
            font-size: 22px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .subtitle {
            margin-top: 6px;
            font-size: 13px;
            color: #4b5563;
        }

        .divider {
            border-top: 2px solid #111827;
            margin: 18px 0 12px;
        }

        .meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
            font-size: 12px;
            color: #374151;
        }

        .meta-right {
            text-align: right;
            font-weight: 600;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
            margin-top: 8px;
        }

        th, td {
            border: 1px solid #d1d5db;
            padding: 8px;
            vertical-align: top;
            text-align: left;
        }

        th {
            background: #f3f4f6;
            font-weight: 700;
        }

        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 999px;
            font-weight: bold;
            font-size: 10px;
            background: #e5e7eb;
        }

        .footer {
            margin-top: 30px;
            display: flex;
            justify-content: flex-end;
            font-size: 12px;
            text-align: center;
        }

        .signature {
            width: 220px;
            text-align: center;
        }

        .signature .line {
            margin-top: 60px;
            border-top: 1px solid #111827;
        }

        .no-print {
            text-align: center;
            margin-top: 20px;
        }

        .no-print button {
            background: #111827;
            color: #ffffff;
            border: none;
            border-radius: 6px;
            padding: 10px 20px;
            font-size: 13px;
            cursor: pointer;
        }

        @media print {
            body {
                background: #ffffff;
                padding: 0;
            }

            .page {
                box-shadow: none;
                max-width: none;
                padding: 0;
            }

            .no-print {
                display: none;
            }

            @page {
                size: A4 portrait;
                margin: 12mm;
            }
        }
    </style>
</head>
<body>
    <div class="page">
        <div class="topbar">
            <div>Dicetak pada: {{ now()->format('d-m-Y H:i') }}</div>
            <div>Filter: {{ $status ?: 'Semua Status' }}</div>
        </div>

        <div class="header">
            <h1>LAPORAN PEMINJAMAN DAN PENGEMBALIAN ALAT</h1>
            <div class="subtitle">Sistem Informasi Manajemen Peminjaman Alat</div>
        </div>

        <div class="divider"></div>

        <div class="meta">
            <div>
                <div><strong>Periode:</strong> {{ $dariTanggal ?: '-' }} s/d {{ $sampaiTanggal ?: '-' }}</div>
            </div>
            <div class="meta-right">
                <div>Total Data: {{ $ringkasan['total'] }}</div>
                <div>Total Denda: Rp {{ number_format($ringkasan['denda'], 0, ',', '.') }}</div>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Peminjam</th>
                    <th>Tgl Pinjam</th>
                    <th>Rencana Kembali</th>
                    <th>Status</th>
                    <th>Detail Alat</th>
                    <th>Denda</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($peminjamans as $index => $peminjaman)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $peminjaman->user->name ?? '-' }}</td>
                        <td>{{ $peminjaman->tgl_pinjam?->format('d-m-Y') ?? '-' }}</td>
                        <td>{{ $peminjaman->tgl_kembali_plan?->format('d-m-Y') ?? '-' }}</td>
                        <td>
                            <span class="badge">{{ ucfirst($peminjaman->status) }}</span>
                        </td>
                        <td>
                            @if ($peminjaman->detailPinjams && $peminjaman->detailPinjams->isNotEmpty())
                                @foreach ($peminjaman->detailPinjams as $detail)
                                    {{ $detail->alat->nama_alat ?? '-' }} ({{ $detail->jumlah }})<br>
                                @endforeach
                            @else
                                -
                            @endif
                        </td>
                        <td>Rp {{ number_format($peminjaman->pengembalian?->denda ?? 0, 0, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center;">Tidak ada data laporan yang sesuai filter.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="footer">
            <div class="signature">
                <div>Balendah, {{ now()->format('d F Y') }}</div>
                <div class="line"></div>
                <div>Petugas Pengelola</div>
            </div>
        </div>
    </div>

    <div class="no-print">
        <button type="button" onclick="window.print()">Cetak Sekarang</button>
    </div>
</body>
</html>
