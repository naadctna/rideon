@extends('layouts.app')

@section('title', 'Dashboard Pemilik - RideOn')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-2">
        <h1 class="text-2xl font-bold text-gray-900">Dashboard Pemilik</h1>
        <p class="text-gray-600 mt-1">Kelola motor dan lihat statistik penyewaan Anda</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-lg shadow-md p-4 flex flex-col items-center">
            <div class="p-2 bg-blue-100 rounded-full">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
            </div>
            <p class="text-xs font-medium text-gray-600 mt-2">Total Motor</p>
            <p class="text-lg font-semibold text-gray-900">{{ $totalMotors }}</p>
        </div>

        <div class="bg-white rounded-lg shadow-md p-4 flex flex-col items-center">
            <div class="p-2 bg-green-100 rounded-full">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <p class="text-xs font-medium text-gray-600 mt-2">Motor Tersedia</p>
            <p class="text-lg font-semibold text-gray-900">{{ $activeMotors }}</p>
        </div>

        <div class="bg-white rounded-lg shadow-md p-4 flex flex-col items-center">
            <div class="p-2 bg-yellow-100 rounded-full">
                <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <p class="text-xs font-medium text-gray-600 mt-2">Motor Disewa</p>
            <p class="text-lg font-semibold text-gray-900">{{ $rentedMotors }}</p>
        </div>

        <div class="bg-white rounded-lg shadow-md p-4 flex flex-col items-center">
            <div class="p-2 bg-orange-100 rounded-full">
                <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
                <p class="text-xs font-medium text-gray-600 mt-2">Perawatan</p>
                <p class="text-lg font-semibold text-gray-900">{{ $maintenanceMotors }}</p>
            </div>
        </div>
    </div>

    <!-- Active Bookings Section -->
    @if($activeBookings->count() > 0)
    <div class="mb-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-bold text-gray-900">Booking Aktif</h3>
            <span class="px-3 py-1 bg-blue-600 text-white text-sm font-semibold rounded-full">
                {{ $activeBookings->count() }}
            </span>
        </div>
        
        <div class="space-y-4">
            @foreach($activeBookings as $booking)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow">
                <div class="p-4">
                    <div class="flex gap-4">
                        <!-- Left: Motor Image & Info -->
                        <div class="flex items-start gap-3 flex-1">
                            <div class="flex-shrink-0">
                                @if($booking->motor->photo)
                                    <img class="h-20 w-20 rounded-lg object-cover" src="{{ asset('storage/' . $booking->motor->photo) }}" alt="{{ $booking->motor->merk }}">
                                @else
                                    <div class="h-20 w-20 rounded-lg bg-gray-100 flex items-center justify-center">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="flex-1 min-w-0">
                                <h4 class="text-base font-bold text-gray-900 mb-1.5">{{ $booking->motor->merk }}</h4>
                                
                                <div class="flex items-center gap-2 mb-2.5">
                                    <span class="px-2 py-0.5 bg-gray-800 text-white text-xs font-semibold rounded">
                                        {{ $booking->motor->no_plat }}
                                    </span>
                                    <span class="px-2 py-0.5 {{ $booking->status == 'active' ? 'bg-green-500' : 'bg-amber-500' }} text-white text-xs font-semibold rounded">
                                        {{ $booking->status == 'active' ? 'Sedang Disewa' : 'Menunggu Pickup' }}
                                    </span>
                                </div>
                                
                                <div class="flex items-center gap-2 text-xs text-gray-600 mb-3">
                                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span>{{ \Carbon\Carbon::parse($booking->tanggal_mulai)->format('d M Y') }} - {{ \Carbon\Carbon::parse($booking->tanggal_selesai)->format('d M Y') }}</span>
                                    <span class="text-gray-300">•</span>
                                    <span class="font-semibold text-blue-600">{{ \Carbon\Carbon::parse($booking->tanggal_mulai)->diffInDays($booking->tanggal_selesai) + 1 }} hari</span>
                                </div>
                                
                                <div class="flex items-center justify-between pt-2.5 border-t border-gray-100">
                                    <div>
                                        <div class="text-xs font-semibold text-gray-500 uppercase mb-0.5">Penyewa</div>
                                        <div class="font-semibold text-gray-900 text-sm">{{ $booking->penyewa->name }}</div>
                                        <div class="text-xs text-gray-600">{{ $booking->penyewa->no_tlpn ?? '-' }}</div>
                                    </div>
                                    
                                    @if($booking->penyewa->no_tlpn)
                                    <div class="flex items-center gap-2">
                                        <a href="https://wa.me/62{{ ltrim($booking->penyewa->no_tlpn, '0') }}" 
                                           target="_blank" 
                                           class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-green-600 rounded-md hover:bg-green-700 transition-colors">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                            </svg>
                                            WhatsApp
                                        </a>
                                        <a href="tel:{{ $booking->penyewa->no_tlpn }}" 
                                           class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                            </svg>
                                            Telepon
                                        </a>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <!-- Right: Total Price -->
                        <div class="flex-shrink-0 flex flex-col justify-center items-end pl-4 border-l border-gray-200">
                            <div class="text-xs font-semibold text-gray-500 uppercase mb-0.5">Total</div>
                            <div class="text-xl font-bold text-green-600">
                                Rp {{ number_format($booking->harga ?? 0, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Completed Bookings Section -->
    @if($completedBookings->count() > 0)
    <div class="mb-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-bold text-gray-900">Penyewaan Selesai</h3>
            <span class="px-3 py-1 bg-gray-600 text-white text-sm font-semibold rounded-full">
                {{ $completedBookings->count() }}
            </span>
        </div>
        
        <div class="space-y-4">
            @foreach($completedBookings as $booking)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow">
                <div class="p-4">
                    <div class="flex gap-4">
                        <!-- Left: Motor Image & Info -->
                        <div class="flex items-start gap-3 flex-1">
                            <div class="flex-shrink-0">
                                @if($booking->motor->photo)
                                    <img class="h-20 w-20 rounded-lg object-cover" src="{{ asset('storage/' . $booking->motor->photo) }}" alt="{{ $booking->motor->merk }}">
                                @else
                                    <div class="h-20 w-20 rounded-lg bg-gray-100 flex items-center justify-center">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="flex-1 min-w-0">
                                <h4 class="text-base font-bold text-gray-900 mb-1.5">{{ $booking->motor->merk }}</h4>
                                
                                <div class="flex items-center gap-2 mb-2.5">
                                    <span class="px-2 py-0.5 bg-gray-800 text-white text-xs font-semibold rounded">
                                        {{ $booking->motor->no_plat }}
                                    </span>
                                    <span class="px-2 py-0.5 bg-green-500 text-white text-xs font-semibold rounded">
                                        Selesai
                                    </span>
                                </div>
                                
                                <div class="flex items-center gap-2 text-xs text-gray-600 mb-3">
                                    <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span>{{ \Carbon\Carbon::parse($booking->tanggal_mulai)->format('d M Y') }} - {{ \Carbon\Carbon::parse($booking->tanggal_selesai)->format('d M Y') }}</span>
                                    <span class="text-gray-300">•</span>
                                    <span class="font-semibold text-blue-600">{{ \Carbon\Carbon::parse($booking->tanggal_mulai)->diffInDays($booking->tanggal_selesai) + 1 }} hari</span>
                                </div>
                                
                                <div class="flex items-center justify-between pt-2.5 border-t border-gray-100">
                                    <div>
                                        <div class="text-xs font-semibold text-gray-500 uppercase mb-0.5">Penyewa</div>
                                        <div class="font-semibold text-gray-900 text-sm">{{ $booking->penyewa->name }}</div>
                                        <div class="text-xs text-gray-600">{{ $booking->penyewa->no_tlpn ?? '-' }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Right: Total Price -->
                        <div class="flex-shrink-0 flex flex-col justify-center items-end pl-4 border-l border-gray-200">
                            <div class="text-xs font-semibold text-gray-500 uppercase mb-0.5">Total</div>
                            <div class="text-xl font-bold text-green-600">
                                Rp {{ number_format($booking->harga ?? 0, 0, ',', '.') }}
                            </div>
                            <div class="text-xs text-gray-500 mt-1">
                                Bagian Anda: Rp {{ number_format(($booking->harga ?? 0) * 0.7, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Action Buttons Section -->
    <div class="bg-gradient-to-br from-slate-50 to-gray-100 rounded-lg shadow-sm p-6 mb-2 mt-6 border border-gray-200">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi Cepat</h3>
        <div class="flex flex-col sm:flex-row gap-4">
            <a href="{{ route('owner.create-motor') }}" class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border-2 border-blue-700">
                <svg class="w-5 h-5 mr-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Daftarkan Motor Baru
            </a>
            <a href="{{ route('owner.revenue') }}" class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 border-2 border-blue-700">
                <svg class="w-5 h-5 mr-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                Lihat Laporan Pendapatan
            </a>
        </div>
    </div>

    <!-- Motors List -->
    <div id="motors-list" class="bg-white rounded-lg shadow-sm mt-8">
        <div class="px-6 py-5 border-b border-gray-200">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <h2 class="text-lg font-semibold text-gray-900 mb-3 sm:mb-0">Daftar Motor Anda</h2>
                
                <!-- Filter Buttons -->
                <div class="flex flex-wrap gap-2">
                    <button data-action="filter-motors" data-status="all" class="filter-btn active px-3 py-1.5 text-xs font-medium rounded-full transition-colors bg-blue-100 text-blue-800 border border-blue-200">
                        Semua
                    </button>
                    <button data-action="filter-motors" data-status="tersedia" class="filter-btn px-3 py-1.5 text-xs font-medium rounded-full transition-colors bg-gray-100 text-gray-600 border border-gray-200 hover:bg-green-50 hover:text-green-700 hover:border-green-200">
                        Tersedia
                    </button>
                    <button data-action="filter-motors" data-status="disewa" class="filter-btn px-3 py-1.5 text-xs font-medium rounded-full transition-colors bg-gray-100 text-gray-600 border border-gray-200 hover:bg-red-50 hover:text-red-700 hover:border-red-200">
                        Disewa
                    </button>
                    <button data-action="filter-motors" data-status="perawatan" class="filter-btn px-3 py-1.5 text-xs font-medium rounded-full transition-colors bg-gray-100 text-gray-600 border border-gray-200 hover:bg-yellow-50 hover:text-yellow-700 hover:border-yellow-200">
                        Perawatan
                    </button>
                    <button data-action="filter-motors" data-status="pending" class="filter-btn px-3 py-1.5 text-xs font-medium rounded-full transition-colors bg-gray-100 text-gray-600 border border-gray-200 hover:bg-orange-50 hover:text-orange-700 hover:border-orange-200">
                        Pending
                    </button>
                </div>
            </div>
        </div>
        
        @if($motors->count() > 0)
            <div class="table-container">
                <table class="min-w-full divide-y divide-gray-200 relative">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Motor</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipe</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Plat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tarif Harian</th>
                            <th class="px-8 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($motors as $motor)
                        <tr class="hover:bg-gray-50 motor-row" data-status="{{ $motor->status }}">
                            <td class="px-6 py-5 whitespace-nowrap">
                                <div class="flex items-center">
                                    @if($motor->photo)
                                        <img class="h-10 w-10 rounded-lg object-cover" src="{{ asset('storage/' . $motor->photo) }}" alt="{{ $motor->merk }}">
                                    @else
                                        <div class="h-10 w-10 rounded-lg bg-gray-200 flex items-center justify-center">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <circle cx="12" cy="12" r="9" stroke-width="2"></circle>
                                                <circle cx="12" cy="12" r="3" stroke-width="2"></circle>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v6m0 6v6m9-9h-6m-6 0H3"></path>
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $motor->merk }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                    {{ $motor->tipe_cc }}cc
                                </span>
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap text-sm text-gray-900">{{ $motor->no_plat }}</td>
                            <td class="px-6 py-5 whitespace-nowrap">
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'tersedia' => 'bg-green-100 text-green-800',
                                        'disewa' => 'bg-red-100 text-red-800',
                                        'perawatan' => 'bg-gray-100 text-gray-800'
                                    ];
                                    $statusLabels = [
                                        'pending' => 'Menunggu Verifikasi',
                                        'tersedia' => 'Tersedia',
                                        'disewa' => 'Sedang Disewa',
                                        'perawatan' => 'Perawatan'
                                    ];
                                @endphp
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $statusColors[$motor->status] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ $statusLabels[$motor->status] ?? ucfirst($motor->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-5 whitespace-nowrap text-sm text-gray-900">
                                @if($motor->tarifRental)
                                    Rp {{ number_format($motor->tarifRental->tarif_harian, 0, ',', '.') }}
                                @else
                                    <span class="text-gray-400">Belum ditetapkan</span>
                                @endif
                            </td>
                            <td class="px-8 py-5 whitespace-nowrap text-center text-sm font-medium">
                                <div class="relative inline-block text-left">
                                    <button data-action="toggle-dropdown" data-motor-id="{{ $motor->id }}" class="inline-flex items-center justify-center w-8 h-8 rounded-full hover:bg-gray-100 focus:outline-none focus:bg-gray-100" id="menu-button-{{ $motor->id }}" aria-expanded="false" aria-haspopup="true">
                                        <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path>
                                        </svg>
                                    </button>

                                    <div id="dropdown-{{ $motor->id }}" class="hidden absolute right-0 z-50 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none origin-top-right" role="menu" style="position: absolute !important;">
                                        <div class="py-1" role="none">
                                            <!-- View -->
                                            <a href="{{ route('owner.show-motor', $motor->id) }}" class="group flex items-center px-4 py-2 text-sm text-gray-900 hover:bg-gray-100" role="menuitem">
                                                <svg class="w-4 h-4 mr-3 text-gray-600 group-hover:text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                                Lihat Detail
                                            </a>

                                            <!-- Edit -->
                                            <a href="{{ route('owner.edit-motor', $motor->id) }}" class="group flex items-center px-4 py-2 text-sm text-gray-900 hover:bg-gray-100" role="menuitem">
                                                <svg class="w-4 h-4 mr-3 text-gray-600 group-hover:text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                                Edit Motor
                                            </a>

<!-- View Details Button -->
                            <button data-action="view-motor-details" data-motor-id="{{ $motor->id }}" class="group flex items-center w-full px-4 py-2 text-sm text-blue-700 hover:bg-blue-50 font-medium" role="menuitem">
                                <svg class="w-4 h-4 mr-3 text-blue-500 group-hover:text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Lihat Detail Lengkap
                            </button>

                            @if($motor->status !== 'disewa')
                                                <!-- Maintenance Toggle -->
                                                <button data-action="confirm-maintenance" data-motor-id="{{ $motor->id }}" data-motor-merk="{{ $motor->merk }}" data-current-status="{{ $motor->status }}" class="group flex items-center w-full px-4 py-2 text-sm text-gray-900 hover:bg-gray-100" role="menuitem">
                                                    <svg class="w-4 h-4 mr-3 text-gray-600 group-hover:text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    </svg>
                                                    {{ $motor->status === 'perawatan' ? 'Set Tersedia' : 'Set Perawatan' }}
                                                </button>

                                                <!-- Delete -->
                                                <button data-action="confirm-delete" data-motor-id="{{ $motor->id }}" data-motor-merk="{{ $motor->merk }}" class="group flex items-center w-full px-4 py-2 text-sm text-red-700 hover:bg-red-50 font-medium" role="menuitem">
                                                    <svg class="w-4 h-4 mr-3 text-red-500 group-hover:text-red-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                    Hapus Motor
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="px-6 py-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada motor terdaftar</h3>
                <p class="mt-1 text-sm text-gray-500">Mulai dengan mendaftarkan motor pertama Anda.</p>
                <div class="mt-6">
                    <a href="{{ route('owner.create-motor') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md transition duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Daftarkan Motor
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Motor Details Modal -->
<div id="motorDetailsModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full max-h-screen overflow-y-auto">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Detail Motor</h3>
                    <button onclick="closeMotorDetailsModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div id="motorDetailsContent">
                    <!-- Content will be loaded here -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 z-[9999] hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 py-6">
        <div class="fixed inset-0 bg-black bg-opacity-50 modal-backdrop" aria-hidden="true" onclick="closeDeleteModal()"></div>
        
        <div class="relative bg-white rounded-xl shadow-2xl modal-content max-w-md w-full mx-auto z-10 overflow-hidden">
            <div class="p-6">
                <div class="flex items-start">
                    <div class="flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                        <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>
                    <div class="ml-4 flex-1">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2" id="modal-title">
                            Konfirmasi Hapus Motor
                        </h3>
                        <p class="text-sm text-gray-600" id="deleteMessage">
                            Apakah Anda yakin ingin menghapus motor ini? Tindakan ini tidak dapat dibatalkan.
                        </p>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-6 py-4 flex flex-col-reverse sm:flex-row sm:justify-end sm:space-x-3 space-y-3 space-y-reverse sm:space-y-0">
                <button data-action="close-delete-modal" type="button" class="w-full sm:w-auto px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                    Batal
                </button>
                <form id="deleteForm" method="POST" class="w-full sm:w-auto">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                        Hapus Motor
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Maintenance Confirmation Modal -->
<div id="maintenanceModal" class="fixed inset-0 z-[9999] hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 py-6">
        <div class="fixed inset-0 bg-black bg-opacity-50 modal-backdrop" aria-hidden="true" onclick="closeMaintenanceModal()"></div>
        
        <div class="relative bg-white rounded-xl shadow-2xl modal-content max-w-md w-full mx-auto z-10 overflow-hidden">
            <div class="p-6">
                <div class="flex items-start">
                    <div class="flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-yellow-100">
                        <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>
                    <div class="ml-4 flex-1">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2" id="maintenance-modal-title">
                            Konfirmasi Ubah Status Motor
                        </h3>
                        <p class="text-sm text-gray-600" id="maintenanceMessage">
                            Apakah Anda yakin ingin mengubah status motor ini?
                        </p>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-6 py-4 flex flex-col-reverse sm:flex-row sm:justify-end sm:space-x-3 space-y-3 space-y-reverse sm:space-y-0">
                <button data-action="close-maintenance-modal" type="button" class="w-full sm:w-auto px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                    Batal
                </button>
                <form id="maintenanceForm" method="POST" class="w-full sm:w-auto">
                    @csrf
                    @method('PATCH')
                    <button type="submit" id="maintenanceSubmitBtn" class="w-full px-4 py-2 text-sm font-medium text-white bg-yellow-600 border border-transparent rounded-lg hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-colors">
                        Ubah Status
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Event delegation for action buttons
document.addEventListener('click', function(e) {
    // Find the closest element with data-action (handles clicks on child elements like SVG)
    const actionElement = e.target.closest('[data-action]');
    
    if (actionElement && actionElement.dataset.action) {
        const action = actionElement.dataset.action;
        
        switch(action) {
            case 'toggle-dropdown':
                const motorId = actionElement.dataset.motorId;
                toggleDropdown(motorId);
                break;
            case 'view-motor-details':
                const detailMotorId = actionElement.dataset.motorId;
                viewMotorDetails(detailMotorId);
                break;
            case 'confirm-delete':
                const deleteMotorId = actionElement.dataset.motorId;
                const motorMerk = actionElement.dataset.motorMerk;
                confirmDelete(deleteMotorId, motorMerk);
                break;
            case 'close-delete-modal':
                closeDeleteModal();
                break;
            case 'confirm-maintenance':
                const maintenanceMotorId = actionElement.dataset.motorId;
                const maintenanceMotorMerk = actionElement.dataset.motorMerk;
                const currentStatus = actionElement.dataset.currentStatus;
                confirmMaintenance(maintenanceMotorId, maintenanceMotorMerk, currentStatus);
                break;
            case 'close-maintenance-modal':
                closeMaintenanceModal();
                break;
            case 'filter-motors':
                const filterStatus = actionElement.dataset.status;
                filterMotors(filterStatus, actionElement);
                break;
        }
    }
});

function viewMotorDetails(motorId) {
    console.log('viewMotorDetails called with motorId:', motorId);
    document.getElementById('motorDetailsModal').classList.remove('hidden');
    document.getElementById('motorDetailsContent').innerHTML = '<div class="text-center py-4"><div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600 mx-auto"></div><p class="mt-2 text-gray-600">Loading...</p></div>';
    
    // Close dropdown
    const dropdown = document.getElementById('dropdown-' + motorId);
    if (dropdown) {
        dropdown.classList.add('hidden');
    }
    
    console.log('Fetching motor details from:', `/owner/motor/${motorId}/details`);
    // Load motor details via AJAX
    fetch(`/owner/motor/${motorId}/details`)
        .then(response => response.json())
        .then(data => {
            const motor = data.motor;
            let tarifHtml = '';
            
            if (motor.tarifs) {
                tarifHtml = `
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <h4 class="font-medium text-blue-900 mb-2">Tarif Rental:</h4>
                        <div class="grid grid-cols-1 gap-2 text-sm">
                            <div class="flex justify-between">
                                <span>Harian:</span>
                                <span class="font-medium">Rp ${motor.tarifs.tarif_harian ? motor.tarifs.tarif_harian.toLocaleString('id-ID') : '0'}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Mingguan:</span>
                                <span class="font-medium">Rp ${motor.tarifs.tarif_mingguan ? motor.tarifs.tarif_mingguan.toLocaleString('id-ID') : '0'}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>Bulanan:</span>
                                <span class="font-medium">Rp ${motor.tarifs.tarif_bulanan ? motor.tarifs.tarif_bulanan.toLocaleString('id-ID') : '0'}</span>
                            </div>
                        </div>
                    </div>
                `;
            } else {
                tarifHtml = '<div class="bg-yellow-50 p-4 rounded-lg text-center text-yellow-800 text-sm">Tarif belum ditetapkan - Menunggu verifikasi admin</div>';
            }

            const statusBadge = motor.status === 'pending' 
                ? '<span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs font-medium">Pending - Menunggu Verifikasi</span>'
                : motor.status === 'tersedia' 
                ? '<span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs font-medium">Tersedia</span>'
                : motor.status === 'disewa'
                ? '<span class="bg-red-100 text-red-800 px-2 py-1 rounded-full text-xs font-medium">Sedang Disewa</span>'
                : '<span class="bg-gray-100 text-gray-800 px-2 py-1 rounded-full text-xs font-medium">Perawatan</span>';

            let actionButtons = '';
            if (motor.status === 'pending') {
                actionButtons = `
                    <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-yellow-600 mt-0.5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div class="text-sm text-yellow-800">
                                <strong>Status:</strong> Motor Anda sedang dalam proses verifikasi oleh admin. Anda akan mendapat notifikasi setelah motor diverifikasi dan tarif rental ditetapkan.
                            </div>
                        </div>
                    </div>
                `;
            }

            document.getElementById('motorDetailsContent').innerHTML = `
                <div class="space-y-6">
                    <!-- Motor Info -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <span class="font-medium text-gray-700">Merk:</span>
                                <p class="text-gray-900 font-semibold">${motor.merk}</p>
                            </div>
                            <div>
                                <span class="font-medium text-gray-700">Tipe CC:</span>
                                <p class="text-gray-900">${motor.tipe_cc}cc</p>
                            </div>
                            <div>
                                <span class="font-medium text-gray-700">No. Plat:</span>
                                <p class="text-gray-900 font-mono font-semibold">${motor.no_plat}</p>
                            </div>
                            <div>
                                <span class="font-medium text-gray-700">Status:</span>
                                <p class="text-gray-900 mt-1">${statusBadge}</p>
                            </div>
                            <div class="col-span-2">
                                <span class="font-medium text-gray-700">Tanggal Daftar:</span>
                                <p class="text-gray-900">${motor.created_at}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Tarif Info -->
                    ${tarifHtml}

                    <!-- Documents & Photos -->
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h4 class="font-medium text-gray-700 mb-3">Foto & Dokumen:</h4>
                        
                        <!-- Motor Photo -->
                        <div class="mb-4">
                            <span class="text-sm text-gray-600 mb-2 block">Foto Motor:</span>
                            ${motor.photo ? `
                                <div class="w-full h-48 rounded-lg overflow-hidden bg-gray-100">
                                    <img src="/storage/${motor.photo}" alt="Foto ${motor.merk}" class="w-full h-full object-cover">
                                </div>
                            ` : `
                                <div class="w-full h-48 rounded-lg bg-gray-200 flex items-center justify-center">
                                    <div class="text-center text-gray-500">
                                        <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <p class="text-sm">Foto tidak tersedia</p>
                                    </div>
                                </div>
                            `}
                        </div>
                        
                        <!-- Documents Info -->
                        <div class="grid grid-cols-1 gap-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Dokumen STNK:</span>
                                <span class="text-gray-900">${motor.dokumen_kepemilikan || 'Belum upload'}</span>
                            </div>
                        </div>
                    </div>

                    ${actionButtons}

                    <!-- Action Buttons -->
                    <div class="flex gap-3 pt-4 border-t border-gray-200">
                        <a href="/owner/motor/${motor.id}/edit" class="flex-1 inline-flex items-center justify-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit Motor
                        </a>
                        <button onclick="closeMotorDetailsModal()" class="flex-1 px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 font-medium rounded-lg transition">
                            Tutup
                        </button>
                    </div>
                </div>
            `;
        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('motorDetailsContent').innerHTML = `
                <div class="text-center py-8 text-red-600">
                    <svg class="w-12 h-12 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                    <p class="text-lg font-medium">Gagal memuat detail motor</p>
                    <p class="text-sm">Silakan coba lagi nanti</p>
                </div>
            `;
        });
}

function closeMotorDetailsModal() {
    document.getElementById('motorDetailsModal').classList.add('hidden');
}

function toggleDropdown(motorId) {
    // Close all other dropdowns
    document.querySelectorAll('[id^="dropdown-"]').forEach(function(dropdown) {
        if (dropdown.id !== 'dropdown-' + motorId) {
            dropdown.classList.add('hidden');
        }
    });
    
    // Toggle current dropdown
    const dropdown = document.getElementById('dropdown-' + motorId);
    dropdown.classList.toggle('hidden');
}

function confirmDelete(motorId, motorMerk) {
    const modal = document.getElementById('deleteModal');
    const form = document.getElementById('deleteForm');
    const message = document.getElementById('deleteMessage');
    
    // Update form action
    form.action = '/owner/motor/' + motorId;
    
    // Update message
    message.textContent = 'Apakah Anda yakin ingin menghapus motor ' + motorMerk + '? Tindakan ini tidak dapat dibatalkan.';
    
    // Show modal
    modal.classList.remove('hidden');
    
    // Close dropdown
    const dropdown = document.getElementById('dropdown-' + motorId);
    if (dropdown) {
        dropdown.classList.add('hidden');
    }
}

function closeDeleteModal() {
    const modal = document.getElementById('deleteModal');
    modal.classList.add('hidden');
}

function confirmMaintenance(motorId, motorMerk, currentStatus) {
    const modal = document.getElementById('maintenanceModal');
    const form = document.getElementById('maintenanceForm');
    const message = document.getElementById('maintenanceMessage');
    const submitBtn = document.getElementById('maintenanceSubmitBtn');
    
    // Update form action
    form.action = '/owner/motor/' + motorId + '/maintenance';
    
    // Update message and button based on current status
    if (currentStatus === 'perawatan') {
        message.textContent = 'Apakah Anda yakin ingin mengubah status motor ' + motorMerk + ' menjadi "Tersedia"? Motor akan dapat disewa kembali.';
        submitBtn.textContent = 'Set Tersedia';
        submitBtn.className = 'w-full px-4 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors';
    } else {
        message.textContent = 'Apakah Anda yakin ingin mengubah status motor ' + motorMerk + ' menjadi "Perawatan"? Motor tidak akan tersedia untuk disewa.';
        submitBtn.textContent = 'Set Perawatan';
        submitBtn.className = 'w-full px-4 py-2 text-sm font-medium text-white bg-yellow-600 border border-transparent rounded-lg hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transition-colors';
    }
    
    // Show modal
    modal.classList.remove('hidden');
    
    // Close dropdown
    const dropdown = document.getElementById('dropdown-' + motorId);
    if (dropdown) {
        dropdown.classList.add('hidden');
    }
}

function closeMaintenanceModal() {
    const modal = document.getElementById('maintenanceModal');
    modal.classList.add('hidden');
}

function filterMotors(status, clickedButton) {
    // Remove active class from all filter buttons
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.classList.remove('active', 'bg-blue-100', 'text-blue-800', 'border-blue-200');
        btn.classList.add('bg-gray-100', 'text-gray-600', 'border-gray-200');
    });
    
    // Add active class to clicked button
    clickedButton.classList.remove('bg-gray-100', 'text-gray-600', 'border-gray-200');
    clickedButton.classList.add('active', 'bg-blue-100', 'text-blue-800', 'border-blue-200');
    
    // Filter table rows
    const rows = document.querySelectorAll('.motor-row');
    let visibleCount = 0;
    
    rows.forEach(row => {
        const motorStatus = row.dataset.status;
        if (status === 'all' || motorStatus === status) {
            row.style.display = '';
            visibleCount++;
        } else {
            row.style.display = 'none';
        }
    });
    
    // Show/hide empty state message if needed
    const tableContainer = document.querySelector('.table-container');
    const emptyState = document.querySelector('.empty-state');
    
    if (visibleCount === 0 && status !== 'all') {
        // Create temporary empty message for filtered results
        if (!document.querySelector('.filter-empty-message')) {
            const filterEmptyMessage = document.createElement('div');
            filterEmptyMessage.className = 'filter-empty-message px-6 py-12 text-center';
            filterEmptyMessage.innerHTML = `
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada motor dengan status "${status}"</h3>
                <p class="mt-1 text-sm text-gray-500">Coba filter dengan status lain.</p>
            `;
            tableContainer.parentNode.appendChild(filterEmptyMessage);
        }
        tableContainer.style.display = 'none';
    } else {
        // Remove filter empty message and show table
        const filterEmptyMessage = document.querySelector('.filter-empty-message');
        if (filterEmptyMessage) {
            filterEmptyMessage.remove();
        }
        tableContainer.style.display = '';
    }
}

// Close dropdown when clicking outside
document.addEventListener('click', function(event) {
    if (!event.target.closest('[id^="menu-button-"]') && !event.target.closest('[id^="dropdown-"]')) {
        document.querySelectorAll('[id^="dropdown-"]').forEach(function(dropdown) {
            dropdown.classList.add('hidden');
        });
    }
});

// Close modal when clicking backdrop or pressing Escape
document.getElementById('deleteModal').addEventListener('click', function(event) {
    if (event.target === this || event.target.classList.contains('modal-backdrop')) {
        closeDeleteModal();
    }
});

document.getElementById('maintenanceModal').addEventListener('click', function(event) {
    if (event.target === this || event.target.classList.contains('modal-backdrop')) {
        closeMaintenanceModal();
    }
});

document.getElementById('motorDetailsModal').addEventListener('click', function(event) {
    if (event.target === this) {
        closeMotorDetailsModal();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        const deleteModal = document.getElementById('deleteModal');
        const maintenanceModal = document.getElementById('maintenanceModal');
        const motorDetailsModal = document.getElementById('motorDetailsModal');
        
        if (!deleteModal.classList.contains('hidden')) {
            closeDeleteModal();
        } else if (!maintenanceModal.classList.contains('hidden')) {
            closeMaintenanceModal();
        } else if (!motorDetailsModal.classList.contains('hidden')) {
            closeMotorDetailsModal();
        }
    }
});
</script>
@endsection
