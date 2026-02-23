@extends('layouts.app')

@section('title', 'Konfirmasi Booking - RideOn')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <!-- Success Header -->
    <div class="bg-green-50 border border-green-200 rounded-lg p-6 text-center">
        <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-green-100 mb-4">
            <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>
        <h1 class="text-2xl font-bold text-green-900">Pembayaran Berhasil!</h1>
        <p class="text-green-700 mt-2">Booking motor Anda telah dikonfirmasi dan pembayaran berhasil diproses.</p>
    </div>

    <!-- Booking Details -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Detail Booking</h2>
        
        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <dt class="text-sm font-medium text-gray-500">Motor</dt>
                <dd class="mt-1 text-sm text-gray-900 font-semibold">{{ $motor->merk }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Tipe CC</dt>
                <dd class="mt-1">
                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                        {{ $motor->tipe_cc }}cc
                    </span>
                </dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Nomor Plat</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $motor->no_plat }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Status Motor</dt>
                <dd class="mt-1">
                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                        Sedang Disewa
                    </span>
                </dd>
            </div>
        </dl>
    </div>

    <!-- Rental Details -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Detail Penyewaan</h2>
        
        <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <dt class="text-sm font-medium text-gray-500">Tanggal Mulai</dt>
                <dd class="mt-1 text-sm text-gray-900 font-semibold">
                    <svg class="w-4 h-4 inline mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    {{ \Carbon\Carbon::parse($rental->tanggal_mulai)->format('d/m/Y') }}
                </dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Tanggal Selesai</dt>
                <dd class="mt-1 text-sm text-gray-900 font-semibold">
                    <svg class="w-4 h-4 inline mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    {{ \Carbon\Carbon::parse($rental->tanggal_selesai)->format('d/m/Y') }}
                </dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Tipe Durasi</dt>
                <dd class="mt-1 text-sm text-gray-900">
                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                        {{ ucfirst($rental->tipe_durasi) }}
                    </span>
                </dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-gray-500">Metode Pembayaran</dt>
                <dd class="mt-1 text-sm text-gray-900">
                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-purple-100 text-purple-800">
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
                    </span>
                </dd>
            </div>
        </dl>
    </div>

    <!-- Payment Summary -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
        <h2 class="text-lg font-semibold text-blue-900 mb-4">Ringkasan Pembayaran</h2>
        
        <div class="flex justify-between items-center mb-2">
            <span class="text-sm text-blue-700">Durasi Rental:</span>
            <span class="text-sm font-medium text-blue-900">
                @php
                    $start = \Carbon\Carbon::parse($rental->tanggal_mulai);
                    $end = \Carbon\Carbon::parse($rental->tanggal_selesai);
                    $days = $end->diffInDays($start) + 1;
                    
                    // Calculate tarif per unit based on rental type
                    $tarifPerUnit = 0;
                    $unitCount = 0;
                    
                    if ($rental->tipe_durasi == 'harian') {
                        $unitCount = $days;
                        $tarifPerUnit = $rental->harga / $days;
                    } elseif ($rental->tipe_durasi == 'mingguan') {
                        $unitCount = ceil($days / 7);
                        $tarifPerUnit = $rental->harga / $unitCount;
                    } elseif ($rental->tipe_durasi == 'bulanan') {
                        $unitCount = ceil($days / 30);
                        $tarifPerUnit = $rental->harga / $unitCount;
                    }
                @endphp
                {{ $days }} hari
            </span>
        </div>
        
        <div class="flex justify-between items-center mb-4">
            <span class="text-sm text-blue-700">Tarif per {{ $rental->tipe_durasi }}:</span>
            <span class="text-sm font-medium text-blue-900">
                Rp {{ number_format($tarifPerUnit, 0, ',', '.') }}
            </span>
        </div>
        
        <hr class="border-blue-200 mb-4">
        
        <div class="flex justify-between items-center">
            <span class="text-lg font-bold text-blue-900">Total Pembayaran:</span>
            <span class="text-xl font-bold text-blue-900">
                Rp {{ number_format($rental->harga, 0, ',', '.') }}
            </span>
        </div>
        
        <div class="mt-4 p-3 bg-green-50 border border-green-200 rounded-md">
            <p class="text-sm text-green-800 text-center">
                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <strong>Status:</strong> Pembayaran berhasil! Motor telah dibooking untuk Anda.
            </p>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="flex flex-col sm:flex-row gap-4">
        <a href="{{ route('renter.my-rentals') }}" class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md transition-all duration-200">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
            </svg>
            Lihat Rental Saya
        </a>
        <a href="{{ route('renter.search') }}" class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-lg shadow-md transition-all duration-200">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            Cari Motor Lain
        </a>
    </div>

    <!-- Contact Info -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="text-md font-semibold text-gray-900 mb-3">Informasi Kontak Pemilik Motor</h3>
        <div class="flex items-center space-x-4">
            <div class="flex-shrink-0">
                <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
            </div>
            <div>
                <h4 class="text-sm font-medium text-gray-900">{{ $motor->pemilik->name }}</h4>
                <p class="text-sm text-gray-500">{{ $motor->pemilik->email }}</p>
                @if($motor->pemilik->phone)
                <p class="text-sm text-gray-500">{{ $motor->pemilik->phone }}</p>
                @endif
            </div>
        </div>
        <div class="mt-4 p-3 bg-yellow-50 border border-yellow-200 rounded-md">
            <p class="text-sm text-yellow-800">
                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                </svg>
                <strong>Penting:</strong> Silakan hubungi pemilik motor untuk mengatur waktu dan tempat pengambilan motor.
            </p>
        </div>
    </div>
</div>
@endsection