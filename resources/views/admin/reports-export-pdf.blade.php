<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Transaksi</title>
    <style>
        @page {
            margin: 15mm;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: Arial, sans-serif;
            font-size: 9px;
            line-height: 1.4;
            color: #000000;
            background: #ffffff;
        }
        
        .container {
            width: 100%;
            margin: 0 auto;
        }
        
        /* Header Styling */
        .header {
            background: #ffffff;
            padding: 20px 0;
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #000000;
        }
        
        .header h1 {
            font-size: 18px;
            color: #000000;
            margin: 0 0 8px 0;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .header p {
            margin: 3px 0;
            color: #666;
            font-size: 9px;
        }
        
        /* Section Styling */
        .section {
            margin-bottom: 15px;
            page-break-inside: avoid;
        }
        
        /* Table Styling */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
            border: 1px solid #000000;
        }
        
        table thead {
            background: #f5f5f5;
            border-bottom: 1px solid #000000;
        }
        
        table th {
            padding: 10px 12px;
            text-align: left;
            font-size: 9px;
            font-weight: bold;
            color: #000000;
            border-right: 1px solid #cccccc;
            text-transform: uppercase;
        }
        
        table th:last-child {
            border-right: none;
        }
        
        table td {
            padding: 10px 12px;
            font-size: 8px;
            border-bottom: 1px solid #e0e0e0;
            border-right: 1px solid #e0e0e0;
            vertical-align: top;
        }
        
        table td:last-child {
            border-right: none;
        }
        
        table tbody tr:last-child td {
            border-bottom: none;
        }
        
        table tfoot {
            background: #f5f5f5;
            border-top: 1px solid #000000;
        }
        
        table tfoot td {
            padding: 8px;
            font-weight: bold;
            font-size: 10px;
            border-bottom: none;
        }
        
        /* Footer */
        .footer {
            margin-top: 20px;
            padding-top: 10px;
            text-align: center;
            font-size: 7px;
            color: #666666;
            border-top: 1px solid #cccccc;
        }
        
        /* Utility Classes */
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .bold { font-weight: bold; }
        
        /* Motor info styling */
        .motor-name {
            font-weight: bold;
            font-size: 9px;
            color: #000000;
            margin-bottom: 2px;
        }
        
        .motor-details {
            font-size: 7px;
            color: #666666;
            line-height: 1.3;
        }
        
        .penyewa-name {
            font-weight: bold;
            font-size: 8px;
            color: #000000;
            margin-bottom: 1px;
        }
        
        .penyewa-email {
            font-size: 7px;
            color: #666666;
        }
        
        .durasi-main {
            font-size: 8px;
            color: #000000;
            margin-bottom: 1px;
        }
        
        .durasi-type {
            font-size: 7px;
            color: #666666;
        }
        
        .tanggal-main {
            font-size: 8px;
            color: #000000;
            margin-bottom: 1px;
        }
        
        .tanggal-range {
            font-size: 7px;
            color: #666666;
        }
        
        .harga {
            font-weight: bold;
            font-size: 9px;
            color: #000000;
        }
    </style>
</head>
<body>
    <div class="container">
    <div class="header">
        <h1>Daftar Transaksi</h1>
        <p>Periode: {{ \Carbon\Carbon::parse($month . '-01')->format('F Y') }}</p>
        <p>Dicetak: {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</p>
    </div>
    
    <!-- Transactions Table -->
    <div class="section">
        <table>
            <thead>
                <tr>
                    <th style="width: 24%;">Motor</th>
                    <th style="width: 20%;">Penyewa</th>
                    <th style="width: 13%;">Durasi</th>
                    <th style="width: 15%;">Tanggal</th>
                    <th style="width: 14%; text-align: right;">Total Harga</th>
                    <th style="width: 14%; text-align: right;">Komisi Admin</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($rentals) && $rentals->count() > 0)
                    @foreach($rentals as $rental)
                    <tr>
                        <td>
                            <div class="motor-name">{{ $rental->motor->merk }}</div>
                            <div class="motor-details">
                                {{ $rental->motor->tipe_cc }}cc • {{ $rental->motor->no_plat }}<br>
                                ID: #{{ $rental->id }}
                            </div>
                        </td>
                        <td>
                            <div class="penyewa-name">{{ $rental->penyewa->name }}</div>
                            <div class="penyewa-email">{{ $rental->penyewa->email }}</div>
                        </td>
                        <td>
                            <div class="durasi-main">{{ \Carbon\Carbon::parse($rental->tanggal_mulai)->diffInDays($rental->tanggal_selesai) + 1 }} hari</div>
                            <div class="durasi-type">{{ ucfirst($rental->tipe_durasi ?? 'N/A') }}</div>
                        </td>
                        <td>
                            <div class="tanggal-main">{{ \Carbon\Carbon::parse($rental->tanggal_mulai)->format('d/m/Y') }}</div>
                            <div class="tanggal-range">s/d {{ \Carbon\Carbon::parse($rental->tanggal_selesai)->format('d/m/Y') }}</div>
                        </td>
                        <td style="text-align: right;">
                            <div class="harga">Rp {{ number_format($rental->harga ?? 0, 0, ',', '.') }}</div>
                        </td>
                        <td style="text-align: right;">
                            <div class="harga">Rp {{ number_format(($rental->harga ?? 0) * 0.30, 0, ',', '.') }}</div>
                        </td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 20px;">
                            Tidak ada transaksi untuk periode ini
                        </td>
                    </tr>
                @endif
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" style="text-align: right;">TOTAL:</td>
                    <td style="text-align: right;">
                        <span class="harga">Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</span>
                    </td>
                    <td style="text-align: right;">
                        <span class="harga">Rp {{ number_format($adminRevenue ?? 0, 0, ',', '.') }}</span>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="text-align: right;">LABA BERSIH (70%):</td>
                    <td colspan="2" style="text-align: right;">
                        <span class="harga">Rp {{ number_format(($totalRevenue ?? 0) * 0.70, 0, ',', '.') }}</span>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
    
    </div>
</body>
</html>
    
    <div class="footer">
        <strong>Dicetak pada:</strong> {{ \Carbon\Carbon::now()->format('d M Y H:i') }} WIB<br>
        <strong>RideOn</strong> - Sistem Rental Motor Profesional | Laporan ini bersifat rahasia dan hanya untuk internal
    </div>
    
    </div>
</body>
</html>
