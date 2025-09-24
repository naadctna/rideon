@extends('layouts.app')

@section('title', 'Dashboard Penyewa - RideOn')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-blue-500">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Dashboard Penyewa</h1>
                <p class="text-gray-600 mt-1">Selamat datang kembali, {{ Auth::user()->name }}!</p>
            </div>
            <div class="hidden md:block">
                <svg class="w-16 h-16 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-full">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-700">Total Penyewaan</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalRentals ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-full">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-700">Sedang Aktif</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $activeRentals ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-purple-500">
            <div class="flex items-center">
                <div class="p-3 bg-purple-100 rounded-full">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-700">Selesai</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $completedRentals ?? 0 }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-yellow-500">
            <div class="flex items-center">
                <div class="p-3 bg-yellow-100 rounded-full">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-700">Total Pengeluaran</p>
                    <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($totalSpent ?? 0, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Aksi Cepat</h2>
        <div class="max-w-md">
            <a href="{{ route('renter.my-rentals') }}" class="flex items-center p-4 bg-white border-2 border-green-500 text-gray-900 rounded-lg hover:bg-green-50 transition duration-200 shadow-md">
                <svg class="w-8 h-8 mr-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                </svg>
                <div>
                    <h3 class="font-semibold text-gray-900">Histori Sewa</h3>
                    <p class="text-sm text-gray-600">Lihat riwayat penyewaan</p>
                </div>
            </a>
        </div>
    </div>

    <!-- Active Rentals -->
    @if(isset($activeRentalsList) && $activeRentalsList->count() > 0)
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-semibold text-gray-900">Penyewaan Aktif</h2>
            <a href="{{ route('renter.my-rentals') }}" class="text-blue-600 hover:text-blue-500 text-sm font-medium">Lihat Semua</a>
        </div>
        
        <div class="space-y-4">
            @foreach($activeRentalsList as $rental)
            <div class="border border-gray-200 rounded-lg p-4 bg-green-50">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        @if($rental->motor->photo)
                            <img src="{{ asset('storage/' . $rental->motor->photo) }}" alt="{{ $rental->motor->merk }}" class="w-16 h-16 object-cover rounded-lg">
                        @else
                            <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                        @endif
                        <div>
                            <h3 class="font-semibold text-gray-900">{{ $rental->motor->merk }}</h3>
                            <p class="text-sm text-gray-600">{{ $rental->motor->no_plat }} • {{ $rental->motor->tipe_cc }}cc</p>
                            <p class="text-sm text-green-600 font-medium">
                                {{ \Carbon\Carbon::parse($rental->tanggal_mulai)->format('d M Y') }} - 
                                {{ \Carbon\Carbon::parse($rental->tanggal_selesai)->format('d M Y') }}
                            </p>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">
                            Aktif
                        </span>
                        <p class="text-sm text-gray-600 mt-1">
                            Sisa {{ max(0, \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($rental->tanggal_selesai), false)) }} hari
                        </p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Available Motors -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-semibold text-gray-900">Motor Tersedia</h2>
            <a href="{{ route('renter.search') }}" class="text-blue-600 hover:text-blue-500 text-sm font-medium">Lihat Semua</a>
        </div>
        
        <!-- Filter Controls -->
        <div class="mb-8 flex flex-wrap gap-4 items-end">
            <div class="flex-1 min-w-0">
                <label class="block text-sm font-medium text-gray-700 mb-1">Cari Merk Motor</label>
                <input type="text" id="merkFilter" placeholder="Ketik merk motor (Honda, Yamaha, dll)" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 text-gray-900 bg-white">
            </div>
            <div class="flex-1 min-w-0">
                <label class="block text-sm font-medium text-gray-700 mb-1">Filter Tipe CC</label>
                <select id="tipeFilter" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 text-gray-900 bg-white">
                    <option value="">Semua Tipe CC</option>
                    @foreach($tipeOptions as $tipe)
                        <option value="{{ $tipe }}">{{ $tipe }}cc</option>
                    @endforeach
                </select>
            </div>
            <div>
                <button id="clearFilters" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-md font-medium transition duration-200">
                    Reset Filter
                </button>
            </div>
        </div>

        <!-- Motors Grid -->
        <div id="motorsGrid">
            @include('renter.partials.motor-grid', ['motors' => $availableMotors])
        </div>
    </div>

    <!-- Recent Rentals History -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-semibold text-gray-900">Riwayat Penyewaan Terbaru</h2>
            <a href="{{ route('renter.my-rentals') }}" class="text-blue-600 hover:text-blue-500 text-sm font-medium">Lihat Semua</a>
        </div>
        
        @if(isset($recentRentals) && $recentRentals->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Motor</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Periode Sewa</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Durasi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Biaya</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($recentRentals as $rental)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    @if($rental->motor->photo)
                                        <img class="h-10 w-10 rounded-lg object-cover" src="{{ asset('storage/' . $rental->motor->photo) }}" alt="{{ $rental->motor->merk }}">
                                    @else
                                        <div class="h-10 w-10 rounded-lg bg-gray-200 flex items-center justify-center">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $rental->motor->merk }}</div>
                                        <div class="text-sm text-gray-500">{{ $rental->motor->no_plat }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ \Carbon\Carbon::parse($rental->tanggal_mulai)->format('d M Y') }} - 
                                {{ \Carbon\Carbon::parse($rental->tanggal_selesai)->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                    {{ ucfirst($rental->tipe_durasi) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                Rp {{ number_format($rental->harga, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
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
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $statusColors[$rental->status] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ $statusLabels[$rental->status] ?? ucfirst($rental->status) }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-12 bg-gray-50 rounded-lg">
                <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                <h3 class="mt-4 text-xl font-medium text-gray-900">Belum ada riwayat penyewaan</h3>
                <p class="mt-2 text-gray-600">Mulai sewa motor pertama Anda sekarang!</p>
                <div class="mt-8">
                    <a href="{{ route('renter.search') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md transition duration-200 shadow-md">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Cari Motor Sekarang
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const merkFilter = document.getElementById('merkFilter');
    const tipeFilter = document.getElementById('tipeFilter');
    const clearFiltersBtn = document.getElementById('clearFilters');
    const motorsGrid = document.getElementById('motorsGrid');

    // Debounce function untuk input text
    function debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }

    function filterMotors() {
        const merk = merkFilter.value;
        const tipe_cc = tipeFilter.value;

        // Show loading state
        motorsGrid.innerHTML = '<div class="text-center py-8"><div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div></div>';

        // Make AJAX request
        fetch('{{ route("renter.filter-motors") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                merk: merk,
                tipe_cc: tipe_cc
            })
        })
        .then(response => response.text())
        .then(html => {
            motorsGrid.innerHTML = html;
        })
        .catch(error => {
            console.error('Error:', error);
            motorsGrid.innerHTML = '<div class="text-center py-8 text-red-600">Terjadi kesalahan saat memuat data</div>';
        });
    }

    // Add event listeners
    const debouncedFilter = debounce(filterMotors, 300);
    merkFilter.addEventListener('input', debouncedFilter); // Changed from 'change' to 'input'
    tipeFilter.addEventListener('change', filterMotors);

    clearFiltersBtn.addEventListener('click', function() {
        merkFilter.value = '';
        tipeFilter.value = '';
        filterMotors();
    });
});
</script>
@endsection