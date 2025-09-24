@extends('layouts.app')

@section('title', 'Dashboard Admin - RideOn')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-gradient-to-r from-purple-600 to-purple-700 rounded-lg shadow-sm p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold">Dashboard Admin</h1>
                <p class="text-purple-100 mt-1">Selamat datang di panel kontrol admin, {{ Auth::user()->name }}!</p>
            </div>
            <div class="hidden md:block">
                <svg class="w-16 h-16 text-purple-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-blue-500">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-full">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Motor</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalMotors }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-yellow-500">
            <div class="flex items-center">
                <div class="p-3 bg-yellow-100 rounded-full">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Pending Verifikasi</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $pendingVerification }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-green-500">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-full">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Sewa Aktif</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $activeRentals }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 border-l-4 border-purple-500">
            <div class="flex items-center">
                <div class="p-3 bg-purple-100 rounded-full">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Revenue</p>
                    <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Aksi Cepat</h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <a href="{{ route('admin.motor-verification') }}" class="flex items-center p-4 bg-white border-2 border-yellow-500 text-gray-900 rounded-lg hover:bg-yellow-50 transition duration-200 shadow-md">
                <svg class="w-8 h-8 mr-3 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <h3 class="font-semibold text-gray-900">Verifikasi Motor</h3>
                    <p class="text-sm text-gray-600">{{ $pendingVerification }} pending</p>
                </div>
            </a>

            <a href="{{ route('admin.rental-management') }}" class="flex items-center p-4 bg-white border-2 border-blue-500 text-gray-900 rounded-lg hover:bg-blue-50 transition duration-200 shadow-md">
                <svg class="w-8 h-8 mr-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                <div>
                    <h3 class="font-semibold text-gray-900">Kelola Penyewaan</h3>
                    <p class="text-sm text-gray-600">{{ $activeRentals }} aktif</p>
                </div>
            </a>

            <a href="{{ route('admin.reports') }}" class="flex items-center p-4 bg-white border-2 border-green-500 text-gray-900 rounded-lg hover:bg-green-50 transition duration-200 shadow-md">
                <svg class="w-8 h-8 mr-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 00-2-2z"></path>
                </svg>
                <div>
                    <h3 class="font-semibold text-gray-900">Laporan</h3>
                    <p class="text-sm text-gray-600">View reports</p>
                </div>
            </a>

            <div class="flex items-center p-4 bg-white border-2 border-purple-500 text-gray-900 rounded-lg cursor-pointer hover:bg-purple-50 transition duration-200 shadow-md">
                <svg class="w-8 h-8 mr-3 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
                <div>
                    <h3 class="font-semibold text-gray-900">Pengaturan</h3>
                    <p class="text-sm text-gray-600">System settings</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activities & Pending Motors -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Rentals -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-semibold text-gray-900">Penyewaan Terbaru</h2>
                <a href="{{ route('admin.rental-management') }}" class="text-blue-600 hover:text-blue-500 text-sm font-medium">Lihat Semua</a>
            </div>
            
            @if($recentRentals->count() > 0)
                <div class="space-y-4">
                    @foreach($recentRentals as $rental)
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="font-semibold text-gray-900">{{ $rental->motor->merk }}</h3>
                                <p class="text-sm text-gray-600">{{ $rental->penyewa->name }}</p>
                                <p class="text-xs text-gray-500">{{ $rental->created_at->diffForHumans() }}</p>
                            </div>
                            <div class="text-right">
                                @php
                                    $statusColors = [
                                        'menunggu_pembayaran' => 'bg-yellow-100 text-yellow-800',
                                        'aktif' => 'bg-green-100 text-green-800',
                                        'selesai' => 'bg-blue-100 text-blue-800',
                                        'dibatalkan' => 'bg-red-100 text-red-800'
                                    ];
                                @endphp
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $statusColors[$rental->status] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ ucfirst(str_replace('_', ' ', $rental->status)) }}
                                </span>
                                <p class="text-sm font-medium text-gray-900 mt-1">
                                    Rp {{ number_format($rental->harga, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <p class="text-gray-500">Belum ada penyewaan terbaru</p>
                </div>
            @endif
        </div>

        <!-- Pending Motors -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-semibold text-gray-900">Motor Pending Verifikasi</h2>
                <a href="{{ route('admin.motor-verification') }}" class="text-yellow-600 hover:text-yellow-500 text-sm font-medium">Lihat Semua</a>
            </div>
            
            @if($pendingMotors->count() > 0)
                <div class="space-y-4">
                    @foreach($pendingMotors as $motor)
                    <div class="border border-gray-200 rounded-lg p-4 bg-yellow-50">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="font-semibold text-gray-900">{{ $motor->merk }}</h3>
                                <p class="text-sm text-gray-600">{{ $motor->no_plat }} • {{ $motor->tipe_cc }}cc</p>
                                <p class="text-sm text-gray-600">Pemilik: {{ $motor->pemilik->name }}</p>
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
            @else
                <div class="text-center py-8">
                    <p class="text-gray-500">Tidak ada motor pending</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Monthly Revenue Chart -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">Revenue Bulanan {{ date('Y') }}</h2>
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