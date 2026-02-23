<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Penyewaan #{{ $rental->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #000;
        }
        .header h1 {
            margin: 0;
            font-size: 20px;
            color: #1a202c;
        }
        .header p {
            margin: 3px 0;
            color: #666;
            font-size: 11px;
        }
        .section {
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e5e7eb;
        }
        .section:last-child {
            border-bottom: none;
        }
        .section-title {
            font-weight: bold;
            font-size: 13px;
            margin-bottom: 10px;
            color: #1f2937;
        }
        .info-grid {
            display: table;
            width: 100%;
        }
        .info-row {
            display: table-row;
        }
        .info-cell {
            display: table-cell;
            padding: 6px 10px 6px 0;
            vertical-align: top;
            width: 50%;
        }
        .info-label {
            color: #6b7280;
            font-size: 11px;
            margin-bottom: 2px;
        }
        .info-value {
            font-weight: 500;
            color: #1f2937;
            font-size: 12px;
        }
        .info-value.highlight {
            font-weight: bold;
            color: #059669;
            font-size: 14px;
        }
        .footer {
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            color: #9ca3af;
            font-size: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>DETAIL PENYEWAAN</h1>
            <p>ID Transaksi: <strong>#{{ $rental->id }}</strong></p>
            <p>Dicetak: {{ date('d/m/Y H:i') }}</p>
        </div>

        <!-- Motor Info -->
        <div class="section">
            <div class="section-title">Informasi Motor</div>
            <div class="info-grid">
                <div class="info-row">
                    <div class="info-cell">
                        <div class="info-label">Merk</div>
                        <div class="info-value">{{ $rental->motor->merk }}</div>
                    </div>
                    <div class="info-cell">
                        <div class="info-label">Tipe CC</div>
                        <div class="info-value">{{ $rental->motor->tipe_cc }}cc</div>
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-cell">
                        <div class="info-label">No. Plat</div>
                        <div class="info-value">{{ $rental->motor->no_plat }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Renter Info -->
        <div class="section">
            <div class="section-title">Informasi Penyewa</div>
            <div class="info-grid">
                <div class="info-row">
                    <div class="info-cell">
                        <div class="info-label">Nama</div>
                        <div class="info-value">{{ $rental->penyewa->name }}</div>
                    </div>
                    <div class="info-cell">
                        <div class="info-label">Email</div>
                        <div class="info-value">{{ $rental->penyewa->email }}</div>
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-cell">
                        <div class="info-label">No. Telepon</div>
                        <div class="info-value">{{ $rental->penyewa->no_tlpn ?? '-' }}</div>
                    </div>
                    <div class="info-cell">
                        <div class="info-label">Alamat</div>
                        <div class="info-value">{{ $rental->penyewa->alamat ?? '-' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rental Info -->
        <div class="section">
            <div class="section-title">Detail Penyewaan</div>
            <div class="info-grid">
                <div class="info-row">
                    <div class="info-cell">
                        <div class="info-label">Status</div>
                        <div class="info-value">{{ ucwords(str_replace('_', ' ', $rental->status)) }}</div>
                    </div>
                    <div class="info-cell">
                        <div class="info-label">Tipe Durasi</div>
                        <div class="info-value">{{ ucfirst($rental->tipe_durasi) }}</div>
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-cell">
                        <div class="info-label">Tanggal Mulai</div>
                        <div class="info-value">{{ $tanggal_mulai }}</div>
                    </div>
                    <div class="info-cell">
                        <div class="info-label">Tanggal Selesai</div>
                        <div class="info-value">{{ $tanggal_selesai }}</div>
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-cell">
                        <div class="info-label">Durasi</div>
                        <div class="info-value">{{ $duration }} hari</div>
                    </div>
                    <div class="info-cell">
                        <div class="info-label">Total Harga</div>
                        <div class="info-value highlight">Rp {{ number_format($rental->harga ?? 0, 0, ',', '.') }}</div>
                    </div>
                </div>
            </div>
        </div>

        @if($rental->transaksi)
        <!-- Transaction Info -->
        <div class="section">
            <div class="section-title">Informasi Transaksi</div>
            <div class="info-grid">
                <div class="info-row">
                    <div class="info-cell">
                        <div class="info-label">ID Transaksi</div>
                        <div class="info-value">#{{ $rental->transaksi->id }}</div>
                    </div>
                    <div class="info-cell">
                        <div class="info-label">Metode Pembayaran</div>
                        <div class="info-value">{{ ucfirst($rental->transaksi->metode_pembayaran) }}</div>
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-cell">
                        <div class="info-label">Status Pembayaran</div>
                        <div class="info-value">{{ ucfirst($rental->transaksi->status) }}</div>
                    </div>
                    <div class="info-cell">
                        <div class="info-label">Jumlah</div>
                        <div class="info-value highlight">Rp {{ number_format($rental->transaksi->jumlah ?? 0, 0, ',', '.') }}</div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <div class="footer">
            <p>Dokumen ini dicetak secara otomatis dari sistem RideOn Motor Rental</p>
        </div>
    </div>
</body>
</html>
