<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Riwayat Bagi Hasil</title>
    <style>
        @page {
            margin: 20mm;
            size: A4 portrait;
        }
        
        body {
            font-family: 'DejaVu Sans', 'Arial', 'Helvetica', sans-serif;
            font-size: 10px;
            line-height: 1.4;
            color: #000000;
        }
        
        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #000000;
        }
        
        .header h1 {
            font-size: 18px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 0 0 8px 0;
            color: #000000;
        }
        
        .header .subtitle {
            font-size: 11px;
            color: #666666;
            margin: 0;
        }
        
        .info-box {
            margin-bottom: 15px;
            padding: 10px;
            background: #f9f9f9;
            border: 1px solid #cccccc;
        }
        
        .info-row {
            margin-bottom: 5px;
            font-size: 10px;
        }
        
        .info-label {
            font-weight: bold;
            display: inline-block;
            width: 120px;
        }
        
        .summary {
            text-align: center;
            padding: 12px;
            margin-bottom: 15px;
            background: #e8f5e9;
            border: 2px solid #4caf50;
        }
        
        .summary-label {
            font-size: 10px;
            font-weight: bold;
            color: #333333;
            margin-bottom: 5px;
        }
        
        .summary-value {
            font-size: 18px;
            font-weight: bold;
            color: #2e7d32;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            margin-bottom: 15px;
        }
        
        th, td {
            border: 1px solid #cccccc;
            padding: 8px 6px;
            vertical-align: top;
            word-wrap: break-word;
        }
        
        thead {
            background: #f2f2f2;
        }
        
        th {
            font-weight: bold;
            font-size: 9px;
            text-align: center;
            text-transform: uppercase;
            color: #000000;
        }
        
        td {
            font-size: 10px;
        }
        
        tbody tr:nth-child(even) {
            background: #fafafa;
        }
        
        tbody tr:nth-child(odd) {
            background: #ffffff;
        }
        
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-bold { font-weight: bold; }
        
        .motor-name {
            font-weight: bold;
            font-size: 10px;
            margin-bottom: 3px;
        }
        
        .motor-detail {
            font-size: 9px;
            color: #666666;
        }
        
        .penyewa-name {
            font-weight: bold;
            font-size: 10px;
            margin-bottom: 3px;
        }
        
        .penyewa-email {
            font-size: 9px;
            color: #666666;
        }
        
        .periode-date {
            font-size: 9px;
            margin-bottom: 2px;
        }
        
        .periode-type {
            font-size: 9px;
            color: #666666;
        }
        
        .status-pending { color: #e65100; font-weight: bold; }
        .status-tersedia { color: #2e7d32; font-weight: bold; }
        .status-disewa { color: #1565c0; font-weight: bold; }
        .status-perawatan { color: #616161; font-weight: bold; }
        .status-maintenance { color: #616161; font-weight: bold; }
        .status-rejected { color: #c62828; font-weight: bold; }
        .status-gagal { color: #d32f2f; font-weight: bold; }
        
        tfoot {
            background: #f2f2f2;
            border-top: 2px solid #000000;
        }
        
        tfoot td {
            font-weight: bold;
            font-size: 11px;
        }
        
        .footer {
            margin-top: 25px;
            padding-top: 10px;
            text-align: right;
            font-size: 9px;
            color: #999999;
            border-top: 1px solid #cccccc;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN RIWAYAT BAGI HASIL</h1>
        <p class="subtitle">Sistem Penyewaan Motor</p>
    </div>

    <div class="info-box">
        <div class="info-row">
            <span class="info-label">Nama Pemilik:</span>
            <span>{{ $owner->name }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Email:</span>
            <span>{{ $owner->email }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">No. Telepon:</span>
            <span>{{ $owner->no_tlpn ?? '-' }}</span>
        </div>
    </div>

    <div class="summary">
        <div class="summary-label">TOTAL PENDAPATAN (70% BAGIAN PEMILIK)</div>
        <div class="summary-value">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
    </div>

    @if($revenues->count() > 0)
    <table>
        <thead>
            <tr>
                <th style="width: 4%;">No</th>
                <th style="width: 10%;">Tanggal</th>
                <th style="width: 22%;">Motor</th>
                <th style="width: 18%;">Penyewa</th>
                <th style="width: 18%;">Periode Sewa</th>
                <th style="width: 14%;">Bagi Hasil</th>
                <th style="width: 14%;">Status Motor</th>
            </tr>
        </thead>
        <tbody>
            @foreach($revenues as $index => $revenue)
            @if($revenue->transaksi && $revenue->transaksi->penyewaan && $revenue->transaksi->penyewaan->motor)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-center">
                    {{ $revenue->created_at ? $revenue->created_at->format('d/m/Y') : '-' }}
                </td>
                <td>
                    <div class="motor-name">{{ $revenue->transaksi->penyewaan->motor->merk }}</div>
                    <div class="motor-detail">
                        {{ $revenue->transaksi->penyewaan->motor->no_plat }} • 
                        {{ $revenue->transaksi->penyewaan->motor->tipe_cc }}cc
                    </div>
                </td>
                <td>
                    <div class="penyewa-name">{{ $revenue->transaksi->penyewaan->penyewa->name ?? '-' }}</div>
                    <div class="penyewa-email">{{ $revenue->transaksi->penyewaan->penyewa->email ?? '-' }}</div>
                </td>
                <td>
                    <div class="periode-date">
                        {{ $revenue->transaksi->penyewaan->tanggal_mulai ? $revenue->transaksi->penyewaan->tanggal_mulai->format('d/m/Y') : '-' }}
                    </div>
                    <div class="periode-date">s/d</div>
                    <div class="periode-date">
                        {{ $revenue->transaksi->penyewaan->tanggal_selesai ? $revenue->transaksi->penyewaan->tanggal_selesai->format('d/m/Y') : '-' }}
                    </div>
                    <div class="periode-type">
                        ({{ ucfirst($revenue->transaksi->penyewaan->tipe_durasi ?? 'harian') }})
                    </div>
                </td>
                <td class="text-right text-bold">
                    Rp {{ number_format($revenue->jumlah, 0, ',', '.') }}
                </td>
                <td class="text-center">
                    @php
                        $motorStatus = $revenue->transaksi->penyewaan->motor->status ?? 'pending';
                        $statusClass = 'status-' . strtolower($motorStatus);
                        $statusLabels = [
                            'pending' => 'Pending',
                            'tersedia' => 'Tersedia',
                            'disewa' => 'Disewa',
                            'perawatan' => 'Perawatan',
                            'maintenance' => 'Perawatan',
                            'rejected' => 'Rejected',
                            'gagal' => 'Gagal'
                        ];
                        $statusLabel = $statusLabels[$motorStatus] ?? ucfirst($motorStatus);
                    @endphp
                    <span class="{{ $statusClass }}">{{ $statusLabel }}</span>
                </td>
            </tr>
            @endif
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5" class="text-right">TOTAL PENDAPATAN:</td>
                <td class="text-right" style="color: #2e7d32;">
                    Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                </td>
                <td></td>
            </tr>
        </tfoot>
    </table>
    @else
    <div style="text-align: center; padding: 30px; background: #f5f5f5; border: 1px solid #cccccc;">
        <p>Belum ada data pendapatan</p>
    </div>
    @endif

    <div class="footer">
        Dicetak pada: {{ $date }}
    </div>
</body>
</html>
