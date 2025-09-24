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
            <a href="{{ route('renter.search') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md transition duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Sewa Motor Baru
            </a>
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
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
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
                            <div class="flex space-x-2 mt-3">
                                @if($rental->status == 'menunggu_pembayaran' && $rental->transaksi)
                                    <a href="{{ route('renter.payment', $rental->transaksi->id) }}" class="inline-flex items-center px-3 py-1 text-sm bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                        </svg>
                                        Bayar
                                    </a>
                                @endif
                                
                                @if($rental->status == 'aktif')
                                    <span class="inline-flex items-center px-3 py-1 text-sm bg-green-100 text-green-800 rounded-md">
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
@endsection