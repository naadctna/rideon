@extends('layouts.app')

@section('title', 'Riwayat Penyewaan - RideOn')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Riwayat Penyewaan</h1>
                <p class="text-gray-600 mt-1">Kelola dan lihat semua penyewaan motor Anda</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('renter.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali
                </a>
                <a href="{{ route('renter.search') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Sewa Motor Baru
                </a>
            </div>
        </div>
    </div>

    @if($rentals->count() > 0)
        <!-- Rentals List -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Daftar Penyewaan ({{ $rentals->total() }})</h2>
            </div>

            <div class="divide-y divide-gray-200">
                @foreach($rentals as $rental)
                <div class="p-6 hover:bg-gray-50">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            @if($rental->motor->photo)
                                <img src="{{ asset('storage/' . $rental->motor->photo) }}" alt="{{ $rental->motor->merk }}" class="w-20 h-20 object-cover rounded-lg">
                            @else
                                <div class="w-20 h-20 bg-gray-200 rounded-lg flex items-center justify-center">
                                    <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <circle cx="12" cy="12" r="9" stroke-width="2"></circle>
                                        <circle cx="12" cy="12" r="3" stroke-width="2"></circle>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v6m0 6v6m9-9h-6m-6 0H3"></path>
                                    </svg>
                                </div>
                            @endif

                            <div class="flex-1">
                                <div class="flex items-center space-x-2">
                                    <h3 class="text-lg font-semibold text-gray-900">{{ $rental->motor->merk }}</h3>
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                        {{ $rental->motor->tipe_cc }}cc
                                    </span>
                                </div>
                                <p class="text-sm text-gray-600">{{ $rental->motor->no_plat }}</p>
                                
                                <div class="mt-2 space-y-1">
                                    <div class="flex items-center text-sm text-gray-600">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a1 1 0 011-1h6a1 1 0 011 1v4m-9 4h10a2 2 0 012 2v9a2 2 0 01-2 2H7a2 2 0 01-2-2v-9a2 2 0 012-2z"></path>
                                        </svg>
                                        ID Penyewaan: #{{ str_pad($rental->id, 6, '0', STR_PAD_LEFT) }}
                                    </div>
                                    <div class="flex items-center text-sm text-gray-600">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ \Carbon\Carbon::parse($rental->tanggal_mulai)->format('d M Y') }} - 
                                        {{ \Carbon\Carbon::parse($rental->tanggal_selesai)->format('d M Y') }}
                                    </div>
                                    <div class="flex items-center text-sm text-gray-600">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                        </svg>
                                        {{ ucfirst($rental->tipe_durasi) }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-right space-y-2">
                            @php
                                $statusColors = [
                                    'menunggu_pembayaran' => 'bg-yellow-100 text-yellow-800',
                                    'aktif' => 'bg-green-100 text-green-800',
                                    'selesai' => 'bg-blue-100 text-blue-800',
                                    'dibatalkan' => 'bg-red-100 text-red-800'
                                ];
                                $statusLabels = [
                                    'menunggu_pembayaran' => 'Menunggu Pembayaran',
                                    'aktif' => 'Aktif',
                                    'selesai' => 'Selesai',
                                    'dibatalkan' => 'Dibatalkan'
                                ];
                            @endphp
                            <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full {{ $statusColors[$rental->status] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ $statusLabels[$rental->status] ?? ucfirst($rental->status) }}
                            </span>
                            
                            <div class="text-lg font-bold text-gray-900">
                                Rp {{ number_format($rental->harga, 0, ',', '.') }}
                            </div>
                            
                            @if($rental->transaksi)
                                <div class="text-sm text-gray-600">
                                    {{ ucfirst($rental->transaksi->metode_pembayaran) }}
                                    <span class="inline-flex px-2 py-1 text-xs font-medium rounded-full ml-1
                                        @if($rental->transaksi->status == 'berhasil') bg-green-100 text-green-800 
                                        @elseif($rental->transaksi->status == 'pending') bg-yellow-100 text-yellow-800 
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ ucfirst($rental->transaksi->status) }}
                                    </span>
                                </div>
                            @endif

                            <!-- Action Buttons -->
                            <div class="flex flex-col space-y-2 mt-3">
                                <button onclick="showRentalDetails({{ $rental->id }})" class="inline-flex items-center justify-center px-3 py-2 text-sm bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    Lihat Detail
                                </button>
                                
                                @if($rental->transaksi && $rental->transaksi->status == 'berhasil')
                                <a href="{{ route('renter.rental.download-invoice', $rental->id) }}" class="inline-flex items-center justify-center px-3 py-2 text-sm bg-green-600 text-white rounded-md hover:bg-green-700 transition">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Download Nota
                                </a>
                                @endif
                                
                                @if($rental->status == 'menunggu_pembayaran' && $rental->transaksi)
                                    <a href="{{ route('renter.payment', $rental->transaksi->id) }}" class="inline-flex items-center justify-center px-3 py-2 text-sm bg-yellow-600 text-white rounded-md hover:bg-yellow-700 transition">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                        </svg>
                                        Bayar Sekarang
                                    </a>
                                @endif
                                
                                @if($rental->status == 'aktif' || $rental->status == 'active')
                                    <span class="inline-flex items-center justify-center px-3 py-2 text-sm bg-green-100 text-green-800 rounded-md font-medium">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Sedang Berlangsung
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Additional Info for Active Rentals -->
                    @if($rental->status == 'aktif')
                        <div class="mt-4 p-4 bg-green-50 rounded-lg">
                            <div class="flex items-center justify-between">
                                <div class="text-sm text-green-800">
                                    <strong>Sisa Waktu:</strong> 
                                    {{ max(0, \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($rental->tanggal_selesai), false)) }} hari
                                </div>
                                <div class="text-sm text-green-600">
                                    Pengembalian: {{ \Carbon\Carbon::parse($rental->tanggal_selesai)->format('d M Y') }}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>

        <!-- Pagination -->
        <div class="bg-white rounded-lg shadow-sm p-4">
            {{ $rentals->links() }}
        </div>

    @else
        <!-- Empty State -->
        <div class="bg-white rounded-lg shadow-sm p-8 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada riwayat penyewaan</h3>
            <p class="mt-1 text-sm text-gray-500">Mulai sewa motor pertama Anda sekarang!</p>
            <div class="mt-6">
                <a href="{{ route('renter.search') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md transition duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Cari Motor
                </a>
            </div>
        </div>
    @endif
</div>

<!-- Detail Modal -->
<div id="detailModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
    <div class="flex items-center justify-center min-h-screen px-4 py-6">
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity" onclick="closeDetailModal()"></div>
        
        <!-- Modal panel -->
        <div class="relative bg-white rounded-lg shadow-2xl transform transition-all w-full max-w-2xl">
            <!-- Header -->
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-4 py-3 rounded-t-lg">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-bold text-white flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        Detail Penyewaan
                    </h3>
                    <button type="button" onclick="closeDetailModal()" class="text-white hover:text-gray-200 transition">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
            
            <!-- Content -->
            <div id="detailContent" class="px-4 py-4 max-h-[60vh] overflow-y-auto bg-gray-50">
                <!-- Content will be loaded here -->
                <div class="text-center py-8">
                    <div class="inline-block animate-spin rounded-full h-10 w-10 border-4 border-blue-600 border-t-transparent"></div>
                    <p class="mt-3 text-sm text-gray-600 font-medium">Memuat detail...</p>
                </div>
            </div>
            
            <!-- Footer -->
            <div class="bg-gray-100 px-4 py-3 flex justify-end border-t border-gray-200 rounded-b-lg">
                <button type="button" onclick="closeDetailModal()" class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-md transition">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

<script>
function showRentalDetails(rentalId) {
    console.log('Opening modal for rental ID:', rentalId);
    
    const modal = document.getElementById('detailModal');
    const detailContent = document.getElementById('detailContent');
    
    if (!modal) {
        console.error('Modal not found!');
        alert('Error: Modal element not found!');
        return;
    }
    
    // Show modal with inline style
    modal.style.display = 'block';
    document.body.style.overflow = 'hidden';
    
    console.log('Modal displayed');
    
    // Show loading
    detailContent.innerHTML = `
        <div class="text-center py-12">
            <div class="inline-block animate-spin rounded-full h-12 w-12 border-4 border-blue-600 border-t-transparent"></div>
            <p class="mt-4 text-base text-gray-600 font-medium">Memuat detail penyewaan...</p>
        </div>
    `;
    
    // Fetch data
    const url = '/renter/rental/' + rentalId + '/details';
    console.log('Fetching from:', url);
    
    fetch(url, {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
        },
        credentials: 'same-origin'
    })
    .then(response => {
        console.log('Response status:', response.status);
        if (!response.ok) {
            return response.text().then(text => {
                throw new Error('HTTP ' + response.status + ': ' + text);
            });
        }
        return response.json();
    })
    .then(data => {
        console.log('Data received:', data);
        
        if (data.success && data.rental) {
            displayRentalDetails(data.rental, detailContent);
        } else {
            throw new Error('Data tidak valid atau tidak lengkap');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        detailContent.innerHTML = `
            <div class="text-center py-12">
                <svg class="mx-auto h-16 w-16 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="mt-4 text-lg font-semibold text-red-600">Gagal memuat data</p>
                <p class="mt-2 text-sm text-gray-600">${error.message}</p>
                <button onclick="showRentalDetails(${rentalId})" class="mt-6 px-6 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium transition shadow">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Coba Lagi
                </button>
            </div>
        `;
    });
}

function displayRentalDetails(rental, detailContent) {
    const startDate = new Date(rental.tanggal_mulai);
    const endDate = new Date(rental.tanggal_selesai);
    const duration = Math.ceil((endDate - startDate) / (1000 * 60 * 60 * 24)) + 1;
    
    const statusConfig = {
        'menunggu_pembayaran': { color: 'bg-yellow-100 text-yellow-800', label: 'Menunggu Pembayaran' },
        'pending': { color: 'bg-yellow-100 text-yellow-800', label: 'Menunggu Persetujuan' },
        'approved': { color: 'bg-blue-100 text-blue-800', label: 'Disetujui' },
        'aktif': { color: 'bg-green-100 text-green-800', label: 'Aktif' },
        'active': { color: 'bg-green-100 text-green-800', label: 'Aktif' },
        'selesai': { color: 'bg-blue-100 text-blue-800', label: 'Selesai' },
        'completed': { color: 'bg-blue-100 text-blue-800', label: 'Selesai' },
        'dibatalkan': { color: 'bg-red-100 text-red-800', label: 'Dibatalkan' },
        'cancelled': { color: 'bg-red-100 text-red-800', label: 'Dibatalkan' }
    };
    
    const paymentMethods = {
        'dana': 'DANA', 'ovo': 'OVO', 'gopay': 'GoPay',
        'shopeepay': 'ShopeePay', 'linkaja': 'LinkAja',
        'qris': 'QRIS', 'transfer': 'Transfer Bank'
    };
    
    const status = statusConfig[rental.status] || { color: 'bg-gray-100 text-gray-800', label: rental.status };
    const paymentStatus = rental.transaksi?.status === 'berhasil' || rental.transaksi?.status === 'success' ? 
        { color: 'bg-green-100 text-green-800', label: 'Berhasil' } : 
        rental.transaksi?.status === 'pending' ? 
        { color: 'bg-yellow-100 text-yellow-800', label: 'Pending' } : 
        { color: 'bg-red-100 text-red-800', label: rental.transaksi?.status || '-' };
    
    detailContent.innerHTML = `
        <!-- ID & Status -->
        <div class="bg-white rounded-lg shadow-sm p-3 mb-3">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs text-gray-500">ID Penyewaan</p>
                    <p class="text-base font-bold text-gray-900">#${String(rental.id).padStart(6, '0')}</p>
                </div>
                <span class="px-3 py-1 text-xs font-bold rounded-lg ${status.color}">
                    ${status.label}
                </span>
            </div>
        </div>
        
        <!-- Motor & Owner Info -->
        <div class="grid grid-cols-2 gap-3 mb-3">
            <div class="bg-white rounded-lg shadow-sm p-3">
                <p class="text-xs font-semibold text-gray-500 uppercase mb-2">Motor</p>
                <p class="text-sm font-bold text-gray-900">${rental.motor?.merk || '-'}</p>
                <p class="text-xs text-gray-600">${rental.motor?.no_plat || '-'} • ${rental.motor?.tipe_cc || '-'}cc</p>
            </div>
            
            <div class="bg-white rounded-lg shadow-sm p-3">
                <p class="text-xs font-semibold text-gray-500 uppercase mb-2">Pemilik</p>
                <p class="text-sm font-bold text-gray-900">${rental.motor?.pemilik?.name || '-'}</p>
                ${rental.motor?.pemilik?.no_tlpn ? `<p class="text-xs text-gray-600">${rental.motor.pemilik.no_tlpn}</p>` : ''}
            </div>
        </div>
        
        <!-- Rental Period -->
        <div class="bg-white rounded-lg shadow-sm p-3 mb-3">
            <p class="text-xs font-semibold text-gray-500 uppercase mb-2">Periode Sewa</p>
            <div class="grid grid-cols-3 gap-3">
                <div>
                    <p class="text-xs text-gray-500">Mulai</p>
                    <p class="text-sm font-semibold text-gray-900">${formatDate(rental.tanggal_mulai)}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Selesai</p>
                    <p class="text-sm font-semibold text-gray-900">${formatDate(rental.tanggal_selesai)}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Durasi</p>
                    <p class="text-sm font-semibold text-gray-900">${duration} hari</p>
                </div>
            </div>
        </div>
        
        <!-- Payment Info -->
        <div class="bg-white rounded-lg shadow-sm p-3 mb-3">
            <p class="text-xs font-semibold text-gray-500 uppercase mb-2">Pembayaran</p>
            <div class="grid grid-cols-2 gap-3 mb-3">
                <div>
                    <p class="text-xs text-gray-500">Metode</p>
                    <p class="text-sm font-semibold text-gray-900">
                        ${rental.transaksi?.metode_pembayaran ? (paymentMethods[rental.transaksi.metode_pembayaran] || rental.transaksi.metode_pembayaran.toUpperCase()) : '-'}
                    </p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Status</p>
                    <span class="inline-flex px-2 py-1 text-xs font-bold rounded ${paymentStatus.color}">
                        ${paymentStatus.label}
                    </span>
                </div>
            </div>
            
            <div class="bg-gradient-to-r from-green-50 to-emerald-50 border-2 border-green-300 rounded-lg p-3">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-xs font-medium text-green-900">Total Biaya</p>
                        <p class="text-xs text-green-700">${duration} hari × Rp ${formatNumber(Math.round((rental.harga || 0) / duration))}</p>
                    </div>
                    <span class="text-xl font-bold text-green-900">Rp ${formatNumber(rental.harga || 0)}</span>
                </div>
            </div>
        </div>
    `;
}

function closeDetailModal() {
    console.log('Closing modal');
    const modal = document.getElementById('detailModal');
    if (modal) {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
    }
}

function formatDate(dateString) {
    if (!dateString) return '-';
    const date = new Date(dateString);
    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
    const day = date.getDate();
    const month = months[date.getMonth()];
    const year = date.getFullYear();
    return `${day} ${month} ${year}`;
}

function formatNumber(num) {
    if (!num) return '0';
    return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

// Close modal with Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeDetailModal();
    }
});

console.log('✓ My Rentals modal script loaded');
</script>
@endsection