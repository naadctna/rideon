@extends('layouts.app')

@section('title', 'Dashboard Admin - RideOn')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-2">
        <h1 class="text-2xl font-bold text-gray-900">Halo, {{ Auth::user()->name }}!</h1>
        <p class="text-gray-600 mt-1">Kelola dan monitor sistem RideOn dengan mudah</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-lg shadow-md p-4 flex flex-col items-center">
            <div class="p-2 bg-blue-100 rounded-full">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="9" stroke-width="2"></circle>
                    <circle cx="12" cy="12" r="3" stroke-width="2"></circle>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v6m0 6v6m9-9h-6m-6 0H3"></path>
                </svg>
            </div>
            <p class="text-xs font-medium text-gray-600 mt-2">Total Motor</p>
            <p class="text-lg font-semibold text-gray-900">{{ $totalMotors }}</p>
        </div>

        <div class="bg-white rounded-lg shadow-md p-4 flex flex-col items-center">
            <div class="p-2 bg-yellow-100 rounded-full">
                <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <p class="text-xs font-medium text-gray-600 mt-2">Pending Verifikasi</p>
            <p class="text-lg font-semibold text-gray-900">{{ $pendingVerification }}</p>
        </div>

        <div class="bg-white rounded-lg shadow-md p-4 flex flex-col items-center">
            <div class="p-2 bg-green-100 rounded-full">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
            </div>
            <p class="text-xs font-medium text-gray-600 mt-2">Sewa Aktif</p>
            <p class="text-lg font-semibold text-gray-900">{{ $activeRentals }}</p>
        </div>

        <div class="bg-white rounded-lg shadow-md p-4 flex flex-col items-center">
            <div class="p-2 bg-purple-100 rounded-full">
                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                </svg>
            </div>
            <p class="text-xs font-medium text-gray-600 mt-2">Total Revenue</p>
            <p class="text-lg font-semibold text-gray-900">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
        </div>
    </div>

    <!-- Recent Activities & Pending Motors -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Rentals -->
        <div class="bg-white rounded-lg shadow-sm">
            <div class="px-6 py-5 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-gray-900">Penyewaan Terbaru</h2>
                    <a href="{{ route('admin.rental-management') }}" class="text-blue-600 hover:text-blue-500 text-sm font-medium">Lihat Semua →</a>
                </div>
            </div>
            
            @if($recentRentals->count() > 0)
                <div class="p-6">
                    <div class="space-y-4">
                        @foreach($recentRentals as $rental)
                        <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="font-semibold text-gray-900">{{ $rental->motor->merk }}</h3>
                                    <p class="text-sm text-gray-600">{{ $rental->penyewa->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $rental->created_at->diffForHumans() }}</p>
                                </div>
                                <div class="text-right">
                                    @php
                                        $statusColors = [
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'approved' => 'bg-blue-100 text-blue-800',
                                            'active' => 'bg-green-100 text-green-800',
                                            'completed' => 'bg-gray-100 text-gray-800',
                                            'cancelled' => 'bg-red-100 text-red-800'
                                        ];
                                    @endphp
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $statusColors[$rental->status] ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ ucfirst(str_replace('_', ' ', $rental->status)) }}
                                    </span>
                                    <p class="text-sm font-medium text-gray-900 mt-1">
                                        Rp {{ number_format($rental->harga ?? 0, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="px-6 py-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada penyewaan terbaru</h3>
                    <p class="mt-1 text-sm text-gray-500">Data penyewaan akan muncul di sini</p>
                </div>
            @endif
        </div>

        <!-- Pending Motors -->
        <div class="bg-white rounded-lg shadow-sm">
            <div class="px-6 py-5 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-gray-900">Motor Pending Verifikasi</h2>
                    <a href="{{ route('admin.motor-verification') }}" class="text-blue-600 hover:text-blue-500 text-sm font-medium">Lihat Semua →</a>
                </div>
            </div>
            
            @if($pendingMotors->count() > 0)
                <div class="p-6">
                    <div class="space-y-4">
                        @foreach($pendingMotors as $motor)
                        <div class="border border-yellow-200 rounded-lg p-4 bg-yellow-50 hover:shadow-md transition-shadow">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
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
                                    <div>
                                        <h3 class="font-semibold text-gray-900">{{ $motor->merk }}</h3>
                                        <p class="text-sm text-gray-600">{{ $motor->no_plat }} • {{ $motor->tipe_cc }}cc</p>
                                        <p class="text-xs text-gray-600">Pemilik: {{ $motor->pemilik->name }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Pending
                                    </span>
                                    <p class="text-xs text-gray-500 mt-1">
                                        {{ $motor->created_at->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="px-6 py-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada motor pending</h3>
                    <p class="mt-1 text-sm text-gray-500">Semua motor sudah diverifikasi</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Revenue Distribution Cards -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between mb-3">
                <div>
                    <p class="text-xs font-medium text-gray-600 mb-1">Pendapatan Admin (30%)</p>
                    <p class="text-2xl font-bold text-green-600">
                        Rp {{ number_format(($totalRevenue * 0.3), 0, ',', '.') }}
                    </p>
                </div>
                <div class="p-3 bg-green-100 rounded-full">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                </div>
            </div>
            <p class="text-xs text-gray-500">Dari total penyewaan</p>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between mb-3">
                <div>
                    <p class="text-xs font-medium text-gray-600 mb-1">Pendapatan Pemilik (70%)</p>
                    <p class="text-2xl font-bold text-blue-600">
                        Rp {{ number_format(($totalRevenue * 0.7), 0, ',', '.') }}
                    </p>
                </div>
                <div class="p-3 bg-blue-100 rounded-full">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
            </div>
            <p class="text-xs text-gray-500">Bagian untuk pemilik motor</p>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between mb-3">
                <div>
                    <p class="text-xs font-medium text-gray-600 mb-1">Sistem Pembayaran</p>
                    <p class="text-xl font-bold text-purple-600">Otomatis</p>
                </div>
                <div class="p-3 bg-purple-100 rounded-full">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
            </div>
            <p class="text-xs text-gray-500">Pembagian instant setelah sewa</p>
        </div>
    </div>

    <!-- Monthly Revenue Chart -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Pendapatan Bulanan {{ date('Y') }}</h2>
        <div class="h-64 flex items-end justify-between space-x-2" id="revenueChart">
            @foreach($monthlyRevenue as $month => $revenue)
            <div class="flex flex-col items-center flex-1">
                <div class="w-full bg-blue-200 rounded-t relative revenue-bar" data-revenue="{{ $revenue }}" data-max="{{ max($monthlyRevenue) }}">
                    <div class="w-full bg-blue-500 rounded-t absolute bottom-0 revenue-bar-fill" data-revenue="{{ $revenue }}" data-max="{{ max($monthlyRevenue) }}"></div>
                </div>
                <div class="text-xs text-gray-600 mt-2 text-center">
                    {{ DateTime::createFromFormat('!m', $month)->format('M') }}
                </div>
                <div class="text-xs text-gray-500 text-center">
                    {{ number_format($revenue / 1000000, 1) }}M
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Revenue Distribution History -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-semibold text-gray-900">Riwayat Distribusi Pendapatan</h2>
            <a href="{{ route('admin.revenue-summary') }}" class="text-purple-600 hover:text-purple-500 text-sm font-medium">Lihat Detail</a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tanggal
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Transaksi
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Total
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Admin (30%)
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Pemilik (70%)
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @php
                        // Simulasi data untuk demonstrasi - dalam implementasi nyata akan mengambil dari database
                        $sampleDistributions = collect([
                            (object)[
                                'date' => '2025-10-20',
                                'total' => 150000,
                                'admin_share' => 45000,
                                'owner_share' => 105000,
                                'motor' => 'Honda Vario 150',
                                'status' => 'selesai'
                            ],
                            (object)[
                                'date' => '2025-10-19',
                                'total' => 200000,
                                'admin_share' => 60000,
                                'owner_share' => 140000,
                                'motor' => 'Yamaha Nmax',
                                'status' => 'selesai'
                            ],
                        ]);
                    @endphp
                    
                    @forelse($sampleDistributions as $dist)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ date('d/m/Y', strtotime($dist->date)) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $dist->motor }}</div>
                            <div class="text-sm text-gray-500">Pembayaran otomatis</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            Rp {{ number_format($dist->total, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-green-600 font-medium">
                            Rp {{ number_format($dist->admin_share, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-blue-600 font-medium">
                            Rp {{ number_format($dist->owner_share, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                Berhasil
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            Belum ada distribusi pendapatan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-4 p-4 bg-blue-50 rounded-lg">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div class="text-sm text-blue-800">
                    <strong>Sistem Otomatis:</strong> Setiap pembayaran sewa langsung dibagi otomatis. Admin mendapat 30%, pemilik motor mendapat 70% dari total pembayaran.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Set revenue chart bar heights
    const revenueBars = document.querySelectorAll('.revenue-bar');
    const revenueBarFills = document.querySelectorAll('.revenue-bar-fill');
    
    revenueBars.forEach(function(bar) {
        const revenue = parseFloat(bar.getAttribute('data-revenue'));
        const maxRevenue = parseFloat(bar.getAttribute('data-max'));
        const height = revenue > 0 ? Math.max(20, (revenue / maxRevenue) * 200) : 20;
        bar.style.height = height + 'px';
    });
    
    revenueBarFills.forEach(function(fill) {
        const revenue = parseFloat(fill.getAttribute('data-revenue'));
        const maxRevenue = parseFloat(fill.getAttribute('data-max'));
        const height = revenue > 0 ? Math.max(20, (revenue / maxRevenue) * 200) : 20;
        fill.style.height = height + 'px';
    });
});
</script>
@endpush