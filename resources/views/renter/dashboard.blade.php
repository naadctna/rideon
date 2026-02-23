@extends('layouts.app')

@section('title', 'Dashboard Penyewa - RideOn')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-2">
        <h1 class="text-2xl font-bold text-gray-900">Dashboard Penyewa</h1>
        <p class="text-gray-600 mt-1">Kelola penyewaan dan lihat motor tersedia</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-lg shadow-md p-4 flex flex-col items-center">
            <div class="p-2 bg-blue-100 rounded-full">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
            </div>
            <p class="text-xs font-medium text-gray-600 mt-2">Total Penyewaan</p>
            <p class="text-lg font-semibold text-gray-900">{{ $totalRentals ?? 0 }}</p>
        </div>

        <div class="bg-white rounded-lg shadow-md p-4 flex flex-col items-center">
            <div class="p-2 bg-green-100 rounded-full">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <p class="text-xs font-medium text-gray-600 mt-2">Sedang Aktif</p>
            <p class="text-lg font-semibold text-gray-900">{{ $activeRentals ?? 0 }}</p>
        </div>

        <div class="bg-white rounded-lg shadow-md p-4 flex flex-col items-center">
            <div class="p-2 bg-purple-100 rounded-full">
                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <p class="text-xs font-medium text-gray-600 mt-2">Selesai</p>
            <p class="text-lg font-semibold text-gray-900">{{ $completedRentals ?? 0 }}</p>
        </div>

        <div class="bg-white rounded-lg shadow-md p-4 flex flex-col items-center">
            <div class="p-2 bg-yellow-100 rounded-full">
                <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                </svg>
            </div>
            <p class="text-xs font-medium text-gray-600 mt-2">Total Pengeluaran</p>
            <p class="text-lg font-semibold text-gray-900">Rp {{ number_format($totalSpent ?? 0, 0, ',', '.') }}</p>
        </div>
    </div>

    <!-- Active Rentals Section -->
    @if(isset($activeRentalsList) && $activeRentalsList->count() > 0)
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-900">🏍️ Rental Aktif</h3>
            <span class="px-3 py-1 text-sm font-medium bg-green-100 text-green-700 rounded-md">
                {{ $activeRentalsList->count() }} Rental
            </span>
        </div>
        
        <div class="space-y-4">
            @foreach($activeRentalsList as $rental)
            @php
                $startDate = \Carbon\Carbon::parse($rental->tanggal_mulai);
                $endDate = \Carbon\Carbon::parse($rental->tanggal_selesai);
                $durationDays = max(1, $startDate->diffInDays($endDate) + 1);
            @endphp
            <div class="border border-gray-200 rounded-lg p-4 hover:border-gray-300 transition">
                <div class="flex gap-4">
                    <!-- Motor Image -->
                    <div class="flex-shrink-0">
                        @if($rental->motor->photo)
                            <img class="h-24 w-24 rounded-lg object-cover" src="{{ asset('storage/' . $rental->motor->photo) }}" alt="{{ $rental->motor->merk }}">
                        @else
                            <div class="h-24 w-24 rounded-lg bg-gray-100 flex items-center justify-center">
                                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                        @endif
                    </div>
                    
                    <div class="flex-1 min-w-0">
                        <!-- Motor Info -->
                        <div class="flex items-center gap-2 mb-2">
                            <h4 class="text-base font-semibold text-gray-900">{{ $rental->motor->merk }}</h4>
                            <span class="px-2 py-1 text-xs font-medium bg-blue-100 text-blue-700 rounded">
                                {{ $rental->motor->no_plat }}
                            </span>
                            <span class="px-2 py-1 text-xs font-medium rounded {{ $rental->status == 'approved' ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700' }}">
                                {{ $rental->status == 'approved' ? 'Sedang Disetujui' : 'Sedang Disewa' }}
                            </span>
                        </div>
                        
                        <!-- Rental Period -->
                        <div class="flex items-center gap-4 text-sm text-gray-600 mb-3">
                            <div class="flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span>{{ $startDate->format('d M Y') }} - {{ $endDate->format('d M Y') }}</span>
                            </div>
                            <div class="flex items-center gap-1 font-medium text-gray-900">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>{{ $durationDays }} hari</span>
                            </div>
                        </div>
                        
                        <!-- Owner Contact Info -->
                        <div class="bg-gray-50 rounded-lg p-3">
                            <p class="text-xs font-medium text-gray-500 mb-2">Info Pemilik Motor</p>
                            <div class="space-y-1.5 text-sm">
                                <div class="font-medium text-gray-900">{{ $rental->motor->pemilik->name }}</div>
                                @if($rental->motor->pemilik->no_tlpn)
                                <div class="text-gray-600">{{ $rental->motor->pemilik->no_tlpn }}</div>
                                @endif
                                @if($rental->motor->pemilik->address)
                                <div class="text-gray-600">{{ $rental->motor->pemilik->address }}</div>
                                @endif
                            </div>
                            
                            <!-- Quick Actions -->
                            @if($rental->motor->pemilik->no_tlpn)
                            <div class="flex gap-2 mt-3">
                                <a href="https://wa.me/62{{ ltrim($rental->motor->pemilik->no_tlpn, '0') }}?text=Halo%20{{ urlencode($rental->motor->pemilik->name) }},%20saya%20{{ urlencode(Auth::user()->name) }}%20yang%20menyewa%20motor%20{{ urlencode($rental->motor->merk) }}%20plat%20{{ urlencode($rental->motor->no_plat) }}.%20Mari%20kita%20koordinasi%20untuk%20pickup%20motor." 
                                   target="_blank" 
                                   class="flex-1 text-center px-3 py-2 text-sm font-medium text-white bg-green-600 rounded-md hover:bg-green-700">
                                    WhatsApp
                                </a>
                                <a href="tel:{{ $rental->motor->pemilik->no_tlpn }}" 
                                   class="flex-1 text-center px-3 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700">
                                    Telepon
                                </a>
                            </div>
                            @endif
                        </div>
                        
                        <!-- Total Amount -->
                        <div class="mt-3 pt-3 border-t border-gray-200 flex justify-between items-center">
                            <span class="text-sm text-gray-600">Total Biaya</span>
                            <span class="text-lg font-semibold text-gray-900">Rp {{ number_format($rental->harga, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- Info Note -->
        <div class="mt-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
            <div class="flex gap-3">
                <svg class="w-5 h-5 text-blue-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="text-sm text-blue-900">
                    <strong>Catatan:</strong> Silakan hubungi pemilik motor untuk koordinasi lokasi dan waktu pickup/return motor. Pastikan kondisi motor diperiksa saat serah terima.
                </p>
            </div>
        </div>
    </div>
    @endif

    <!-- Available Motors -->
    <div class="bg-white rounded-lg shadow-sm mt-8">
        <div class="px-6 py-5 border-b border-gray-200">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <h2 class="text-lg font-semibold text-gray-900 mb-3 sm:mb-0">Motor Tersedia</h2>
                <a href="{{ route('renter.search') }}" class="text-blue-600 hover:text-blue-500 text-sm font-medium">Lihat Semua →</a>
            </div>
        </div>
        
        <!-- Filter Controls -->
        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
            <div class="flex flex-wrap gap-4 items-end">
                <div class="flex-1 min-w-0">
                    <label class="block text-xs font-medium text-gray-700 mb-1">Cari Merk Motor</label>
                    <input type="text" id="merkFilter" placeholder="Ketik merk motor..." class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 text-sm text-gray-900 bg-white">
                </div>
                <div class="flex-1 min-w-0">
                    <label class="block text-xs font-medium text-gray-700 mb-1">Filter Tipe CC</label>
                    <select id="tipeFilter" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 text-sm text-gray-900 bg-white">
                        <option value="">Semua Tipe CC</option>
                        @foreach($tipeOptions as $tipe)
                            <option value="{{ $tipe }}">{{ $tipe }}cc</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <button id="clearFilters" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-md text-sm font-medium transition duration-200">
                        Reset
                    </button>
                </div>
            </div>
        </div>

        <!-- Motors Grid -->
        <div id="motorsGrid" class="p-6">
            @include('renter.partials.motor-grid', ['motors' => $availableMotors])
        </div>
    </div>

    <!-- Recent Rentals History -->
    <div class="bg-white rounded-lg shadow-sm mt-8">
        <div class="px-6 py-5 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-900">Riwayat Penyewaan Terbaru</h2>
                <a href="{{ route('renter.my-rentals') }}" class="text-blue-600 hover:text-blue-500 text-sm font-medium">Lihat Semua →</a>
            </div>
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
                                                <circle cx="12" cy="12" r="9" stroke-width="2"></circle>
                                                <circle cx="12" cy="12" r="3" stroke-width="2"></circle>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v6m0 6v6m9-9h-6m-6 0H3"></path>
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
                                    {{ \Carbon\Carbon::parse($rental->tanggal_mulai)->diffInDays($rental->tanggal_selesai) + 1 }} hari
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                Rp {{ number_format($rental->harga, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'approved' => 'bg-blue-100 text-blue-800',
                                        'active' => 'bg-green-100 text-green-800',
                                        'completed' => 'bg-gray-100 text-gray-800',
                                        'cancelled' => 'bg-red-100 text-red-800'
                                    ];
                                    $statusLabels = [
                                        'pending' => 'Menunggu',
                                        'approved' => 'Disetujui',
                                        'active' => 'Aktif',
                                        'completed' => 'Selesai',
                                        'cancelled' => 'Dibatalkan'
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
            <div class="px-6 py-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada riwayat penyewaan</h3>
                <p class="mt-1 text-sm text-gray-500">Mulai sewa motor pertama Anda sekarang!</p>
                <div class="mt-6">
                    <a href="{{ route('renter.search') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md transition duration-200">
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