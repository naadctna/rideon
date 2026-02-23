<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice Penyewaan Motor</title>
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
            border-bottom: 3px solid #2563eb;
        }
        
        .header h1 {
            font-size: 24px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 2px;
            margin: 0 0 5px 0;
            color: #1e40af;
        }
        
        .header .subtitle {
            font-size: 12px;
            color: #666666;
            margin: 0;
        }
        
        .invoice-info {
            margin-bottom: 20px;
            background: #f0f9ff;
            border: 2px solid #2563eb;
            padding: 15px;
            border-radius: 8px;
        }
        
        .invoice-info .invoice-number {
            font-size: 16px;
            font-weight: bold;
            color: #1e40af;
            margin-bottom: 5px;
        }
        
        .invoice-info .invoice-date {
            font-size: 10px;
            color: #666666;
        }
        
        .info-section {
            margin-bottom: 20px;
        }
        
        .info-section h3 {
            font-size: 12px;
            font-weight: bold;
            color: #1e40af;
            margin: 0 0 10px 0;
            padding-bottom: 5px;
            border-bottom: 1px solid #cbd5e1;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }
        
        .info-item {
            margin-bottom: 8px;
        }
        
        .info-label {
            font-size: 9px;
            font-weight: bold;
            color: #64748b;
            display: block;
            margin-bottom: 3px;
            text-transform: uppercase;
        }
        
        .info-value {
            font-size: 11px;
            color: #000000;
            font-weight: 500;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        th, td {
            border: 1px solid #cbd5e1;
            padding: 10px;
            text-align: left;
        }
        
        thead {
            background: #1e40af;
            color: white;
        }
        
        th {
            font-weight: bold;
            font-size: 10px;
            text-transform: uppercase;
        }
        
        td {
            font-size: 10px;
        }
        
        tbody tr:nth-child(even) {
            background: #f8fafc;
        }
        
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .text-bold { font-weight: bold; }
        
        .total-section {
            background: #dcfce7;
            border: 2px solid #16a34a;
            padding: 15px;
            margin-top: 20px;
            border-radius: 8px;
        }
        
        .total-label {
            font-size: 12px;
            font-weight: bold;
            color: #15803d;
            margin-bottom: 5px;
        }
        
        .total-value {
            font-size: 20px;
            font-weight: bold;
            color: #15803d;
        }
        
        .status-badge {
            display: inline-block;
            padding: 5px 12px;
            font-size: 9px;
            font-weight: bold;
            border-radius: 12px;
            text-transform: uppercase;
        }
        
        .status-berhasil {
            background: #dcfce7;
            color: #15803d;
            border: 1px solid #16a34a;
        }
        
        .status-pending {
            background: #fef3c7;
            color: #a16207;
            border: 1px solid #eab308;
        }
        
        .notes {
            margin-top: 25px;
            padding: 15px;
            background: #fef3c7;
            border: 1px solid #fbbf24;
            border-radius: 8px;
            font-size: 9px;
            line-height: 1.6;
        }
        
        .notes h4 {
            font-size: 11px;
            font-weight: bold;
            color: #92400e;
            margin: 0 0 8px 0;
        }
        
        .footer {
            margin-top: 30px;
            padding-top: 15px;
            text-align: center;
            font-size: 8px;
            color: #94a3b8;
            border-top: 1px solid #cbd5e1;
        }
        
        .motor-image {
            max-width: 150px;
            height: auto;
            border-radius: 8px;
            border: 2px solid #cbd5e1;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>🏍️ RIDEON</h1>
        <p class="subtitle">Sistem Penyewaan Motor</p>
    </div>

    <div class="invoice-info">
        <div class="invoice-number">INVOICE #{{ str_pad($rental->id, 6, '0', STR_PAD_LEFT) }}</div>
        <div class="invoice-date">Tanggal Cetak: {{ $date }}</div>
    </div>

    <div class="info-grid">
        <!-- Informasi Penyewa -->
        <div class="info-section">
            <h3>Informasi Penyewa</h3>
            <div class="info-item">
                <span class="info-label">Nama Penyewa</span>
                <span class="info-value">{{ $rental->penyewa->name }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Email</span>
                <span class="info-value">{{ $rental->penyewa->email }}</span>
            </div>
            @if($rental->penyewa->no_tlpn)
            <div class="info-item">
                <span class="info-label">No. Telepon</span>
                <span class="info-value">{{ $rental->penyewa->no_tlpn }}</span>
            </div>
            @endif
        </div>

        <!-- Informasi Pemilik Motor -->
        <div class="info-section">
            <h3>Informasi Pemilik Motor</h3>
            <div class="info-item">
                <span class="info-label">Nama Pemilik</span>
                <span class="info-value">{{ $rental->motor->pemilik->name }}</span>
            </div>
            <div class="info-item">
                <span class="info-label">Email</span>
                <span class="info-value">{{ $rental->motor->pemilik->email }}</span>
            </div>
            @if($rental->motor->pemilik->no_tlpn)
            <div class="info-item">
                <span class="info-label">No. Telepon</span>
                <span class="info-value">{{ $rental->motor->pemilik->no_tlpn }}</span>
            </div>
            @endif
        </div>
    </div>

    <!-- Detail Motor -->
    <div class="info-section">
        <h3>Detail Motor</h3>
        <table>
            <thead>
                <tr>
                    <th>Merk Motor</th>
                    <th>Nomor Plat</th>
                    <th>Tipe CC</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-bold">{{ $rental->motor->merk }}</td>
                    <td class="text-bold">{{ $rental->motor->no_plat }}</td>
                    <td class="text-center">{{ $rental->motor->tipe_cc }}cc</td>
                    <td class="text-center">
                        @php
                            $motorStatusLabels = [
                                'tersedia' => 'Tersedia',
                                'disewa' => 'Disewa',
                                'perawatan' => 'Perawatan',
                                'pending' => 'Pending'
                            ];
                        @endphp
                        {{ $motorStatusLabels[$rental->motor->status] ?? ucfirst($rental->motor->status) }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Detail Penyewaan -->
    <div class="info-section">
        <h3>Detail Penyewaan</h3>
        <table>
            <thead>
                <tr>
                    <th>Tanggal Mulai</th>
                    <th>Tanggal Selesai</th>
                    <th>Durasi</th>
                    <th>Tipe Durasi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center">{{ \Carbon\Carbon::parse($rental->tanggal_mulai)->format('d/m/Y') }}</td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($rental->tanggal_selesai)->format('d/m/Y') }}</td>
                    <td class="text-center text-bold">{{ $duration }} hari</td>
                    <td class="text-center">{{ ucfirst($rental->tipe_durasi) }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Detail Pembayaran -->
    <div class="info-section">
        <h3>Detail Pembayaran</h3>
        <table>
            <thead>
                <tr>
                    <th>Metode Pembayaran</th>
                    <th>Status Pembayaran</th>
                    <th>Tanggal Pembayaran</th>
                    <th class="text-right">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        @if($rental->transaksi)
                            @switch($rental->transaksi->metode_pembayaran)
                                @case('dana')
                                    💳 DANA
                                    @break
                                @case('ovo')
                                    💳 OVO
                                    @break
                                @case('gopay')
                                    💳 GoPay
                                    @break
                                @case('shopeepay')
                                    💳 ShopeePay
                                    @break
                                @case('linkaja')
                                    💳 LinkAja
                                    @break
                                @case('qris')
                                    💳 QRIS
                                    @break
                                @default
                                    {{ ucfirst($rental->transaksi->metode_pembayaran) }}
                            @endswitch
                        @else
                            -
                        @endif
                    </td>
                    <td class="text-center">
                        @if($rental->transaksi)
                            <span class="status-badge status-{{ $rental->transaksi->status }}">
                                {{ ucfirst($rental->transaksi->status) }}
                            </span>
                        @else
                            -
                        @endif
                    </td>
                    <td class="text-center">
                        @if($rental->transaksi && $rental->transaksi->tanggal)
                            {{ \Carbon\Carbon::parse($rental->transaksi->tanggal)->format('d/m/Y H:i') }}
                        @else
                            -
                        @endif
                    </td>
                    <td class="text-right text-bold">Rp {{ number_format($rental->harga, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Total -->
    <div class="total-section">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <div class="total-label">TOTAL PEMBAYARAN</div>
            <div class="total-value">Rp {{ number_format($rental->harga, 0, ',', '.') }}</div>
        </div>
    </div>

    <!-- Notes -->
    <div class="notes">
        <h4>Catatan Penting:</h4>
        <ul style="margin: 0; padding-left: 15px;">
            <li>Mohon simpan invoice ini sebagai bukti pembayaran yang sah.</li>
            <li>Silakan hubungi pemilik motor untuk koordinasi lokasi dan waktu pickup/return motor.</li>
            <li>Pastikan kondisi motor diperiksa dengan teliti saat serah terima.</li>
            <li>Pengembalian motor yang terlambat akan dikenakan denda sesuai ketentuan yang berlaku.</li>
            <li>Untuk pertanyaan lebih lanjut, hubungi customer service RideOn.</li>
        </ul>
    </div>

    <div class="footer">
        <p>Dokumen ini dicetak secara otomatis dari sistem RideOn</p>
        <p>© {{ date('Y') }} RideOn Motor Rental System. All rights reserved.</p>
    </div>
</body>
</html>
