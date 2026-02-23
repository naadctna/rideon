@extends('layouts.app')

@section('title', 'Detail Verifikasi Motor - Admin')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-2">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.motor-verification') }}" class="inline-flex items-center justify-center w-10 h-10 rounded-lg bg-gray-100 hover:bg-gray-200 transition-colors">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Detail Verifikasi Motor</h1>
                    <p class="text-gray-600 mt-1">Review lengkap sebelum verifikasi</p>
                </div>
            </div>
            @php
                $statusColors = [
                    'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                    'tersedia' => 'bg-green-100 text-green-800 border-green-200',
                    'rejected' => 'bg-red-100 text-red-800 border-red-200',
                    'disewa' => 'bg-blue-100 text-blue-800 border-blue-200',
                    'maintenance' => 'bg-orange-100 text-orange-800 border-orange-200'
                ];
            @endphp
            <span class="inline-flex px-4 py-2 text-sm font-bold rounded-lg border-2 {{ $statusColors[$motor->status] ?? 'bg-gray-100 text-gray-800 border-gray-200' }}">
                {{ ucfirst($motor->status) }}
            </span>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-lg shadow-md p-4 flex flex-col items-center">
            <div class="p-2 bg-blue-100 rounded-full">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
            </div>
            <p class="text-xs font-medium text-gray-600 mt-2">Total Penyewaan</p>
            <p class="text-lg font-semibold text-gray-900">{{ $totalRentals }}</p>
        </div>

        <div class="bg-white rounded-lg shadow-md p-4 flex flex-col items-center">
            <div class="p-2 bg-green-100 rounded-full">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <p class="text-xs font-medium text-gray-600 mt-2">Sedang Disewa</p>
            <p class="text-lg font-semibold text-gray-900">{{ $activeRentals }}</p>
        </div>

        <div class="bg-white rounded-lg shadow-md p-4 flex flex-col items-center">
            <div class="p-2 bg-purple-100 rounded-full">
                <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <p class="text-xs font-medium text-gray-600 mt-2">Selesai</p>
            <p class="text-lg font-semibold text-gray-900">{{ $completedRentals }}</p>
        </div>

        <div class="bg-white rounded-lg shadow-md p-4 flex flex-col items-center">
            <div class="p-2 bg-yellow-100 rounded-full">
                <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                </svg>
            </div>
            <p class="text-xs font-medium text-gray-600 mt-2">Total Pendapatan</p>
            <p class="text-lg font-semibold text-gray-900">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column - Motor Details (2/3 width) -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Motor Information Card -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden border-2 border-gray-300">
                <div class="bg-gray-100 px-6 py-4 border-b-2 border-gray-300">
                    <h2 class="text-base font-bold text-gray-900 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Informasi Motor
                    </h2>
                </div>
                <div class="p-6">
                    <!-- Motor Image -->
                    <div class="mb-6">
                        @if($motor->photo)
                            @php
                                $photoUrl = asset('storage/' . $motor->photo);
                                $motorName = $motor->merk;
                            @endphp
                            <div class="cursor-pointer" 
                                 onclick="document.getElementById('modalImage').src='{{ $photoUrl }}'; document.getElementById('modalImageTitle').textContent='Foto Motor: {{ $motorName }}'; document.getElementById('imageModal').classList.remove('hidden'); console.log('Image modal opened');"
                                 title="Klik untuk memperbesar gambar">
                                <img src="{{ $photoUrl }}" 
                                     alt="{{ $motorName }}" 
                                     class="w-full h-80 object-cover rounded-lg shadow-md hover:shadow-lg transition-shadow duration-200">
                            </div>
                        @else
                            <div class="w-full h-80 bg-gray-200 rounded-lg flex items-center justify-center">
                                <div class="text-center">
                                    <svg class="mx-auto w-20 h-20 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <p class="mt-2 text-gray-500">Foto tidak tersedia</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Motor Details Grid -->
                    <div class="grid grid-cols-2 gap-5">
                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-300">
                            <p class="text-xs font-medium text-gray-600 mb-2">Merk Motor</p>
                            <p class="text-base font-bold text-gray-900">{{ $motor->merk }}</p>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-300">
                            <p class="text-xs font-medium text-gray-600 mb-2">Tipe CC</p>
                            <p class="text-base font-bold text-gray-900">{{ $motor->tipe_cc }}cc</p>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-300">
                            <p class="text-xs font-medium text-gray-600 mb-2">Nomor Plat</p>
                            <p class="text-base font-bold text-gray-900 font-mono">{{ $motor->no_plat }}</p>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-300">
                            <p class="text-xs font-medium text-gray-600 mb-2">Dokumen Kepemilikan</p>
                            @if($motor->dokumen_kepemilikan)
                                @php
                                    $docUrl = asset('storage/' . $motor->dokumen_kepemilikan);
                                    $motorName = $motor->merk;
                                @endphp
                                <div class="flex gap-2 mt-2">
                                    <button type="button"
                                            onclick="document.getElementById('modalDocument').src='{{ $docUrl }}'; document.getElementById('modalDocumentTitle').textContent='{{ $motorName }}'; document.getElementById('downloadDocumentBtn').href='{{ $docUrl }}'; document.getElementById('documentModal').classList.remove('hidden');"
                                            class="flex-1 bg-blue-600 text-white px-3 py-2 rounded-lg hover:bg-blue-700 transition duration-200 text-sm font-medium inline-flex items-center justify-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        Lihat
                                    </button>
                                    <a href="{{ $docUrl }}" 
                                       download="Dokumen_{{ str_replace(' ', '_', $motor->merk) }}_{{ $motor->no_plat }}.{{ pathinfo($motor->dokumen_kepemilikan, PATHINFO_EXTENSION) }}"
                                       class="flex-1 bg-green-600 text-white px-3 py-2 rounded-lg hover:bg-green-700 transition duration-200 text-sm font-medium inline-flex items-center justify-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                        </svg>
                                        Download
                                    </a>
                                </div>
                            @else
                                <p class="text-gray-500 text-sm">Tidak ada</p>
                            @endif
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg border border-gray-300 col-span-2">
                            <p class="text-xs font-medium text-gray-600 mb-2">Tanggal Pendaftaran</p>
                            <p class="text-base font-bold text-gray-900">{{ $motor->created_at->format('d F Y, H:i') }}</p>
                            <p class="text-sm text-gray-500 mt-1">{{ $motor->created_at->diffForHumans() }}</p>
                        </div>
                    </div>

                    @if($motor->deskripsi)
                    <div class="mt-6 p-4 bg-blue-50 rounded-lg">
                        <p class="text-sm text-gray-600 mb-2">Deskripsi</p>
                        <p class="text-gray-900">{{ $motor->deskripsi }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Rental Pricing -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden border-2 border-gray-300">
                <div class="bg-gray-100 px-6 py-4 border-b-2 border-gray-300">
                    <h2 class="text-base font-bold text-gray-900 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Tarif Rental
                    </h2>
                </div>
                <div class="p-6">
                    @if($motor->tarifRental)
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="bg-blue-50 border-2 border-blue-300 p-4 rounded-lg">
                                <div class="flex items-center justify-between mb-2">
                                    <p class="text-xs font-semibold text-blue-900 uppercase">Tarif Harian</p>
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <p class="text-base font-bold text-gray-900 mb-1">Rp {{ number_format($motor->tarifRental->tarif_harian, 0, ',', '.') }}</p>
                                <p class="text-xs text-gray-600">per hari</p>
                            </div>

                            <div class="bg-green-50 border-2 border-green-300 p-4 rounded-lg">
                                <div class="flex items-center justify-between mb-2">
                                    <p class="text-xs font-semibold text-green-900 uppercase">Tarif Mingguan</p>
                                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <p class="text-base font-bold text-gray-900 mb-1">Rp {{ number_format($motor->tarifRental->tarif_mingguan, 0, ',', '.') }}</p>
                                <p class="text-xs text-gray-600">per 7 hari</p>
                            </div>

                            <div class="bg-purple-50 border-2 border-purple-300 p-4 rounded-lg">
                                <div class="flex items-center justify-between mb-2">
                                    <p class="text-xs font-semibold text-purple-900 uppercase">Tarif Bulanan</p>
                                    <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                </div>
                                <p class="text-base font-bold text-gray-900 mb-1">Rp {{ number_format($motor->tarifRental->tarif_bulanan, 0, ',', '.') }}</p>
                                <p class="text-xs text-gray-600">per 30 hari</p>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-10 bg-gradient-to-br from-yellow-50 to-orange-50 rounded-xl border-2 border-yellow-200">
                            <svg class="mx-auto w-16 h-16 text-yellow-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                            <p class="font-bold text-yellow-900 text-lg">Tarif Belum Ditetapkan</p>
                            <p class="text-sm text-yellow-700 mt-2">Tetapkan tarif saat approve motor ini</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Rental History -->
            @if($rentalHistory->count() > 0)
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">Riwayat Penyewaan</h2>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Penyewa</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Durasi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($rentalHistory as $rental)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                                <span class="text-blue-600 font-bold">{{ strtoupper(substr($rental->penyewa->name, 0, 1)) }}</span>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $rental->penyewa->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $rental->penyewa->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $rental->tanggal_mulai->format('d/m/Y') }}</div>
                                    <div class="text-sm text-gray-500">s/d {{ $rental->tanggal_selesai->format('d/m/Y') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $rental->durasi_hari }} hari
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    Rp {{ number_format($rental->total_harga, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $rentalStatusColors = [
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'active' => 'bg-blue-100 text-blue-800',
                                            'selesai' => 'bg-green-100 text-green-800',
                                            'dibatalkan' => 'bg-red-100 text-red-800'
                                        ];
                                    @endphp
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $rentalStatusColors[$rental->status] ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ ucfirst($rental->status) }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>

        <!-- Right Column - Owner Info & Actions -->
        <div class="space-y-6">
            <!-- Owner Information -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden border-2 border-gray-300">
                <div class="bg-gray-100 px-6 py-4 border-b-2 border-gray-300">
                    <h2 class="text-base font-bold text-gray-900 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Informasi Pemilik
                    </h2>
                </div>
                <div class="p-6">
                    <div class="flex items-center space-x-4 mb-6">
                        <div class="flex-shrink-0">
                            <div class="w-16 h-16 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center">
                                <span class="text-2xl font-bold text-white">{{ strtoupper(substr($motor->pemilik->name, 0, 1)) }}</span>
                            </div>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">{{ $motor->pemilik->name }}</h3>
                            <p class="text-sm text-gray-500">Pemilik Motor</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-start space-x-3">
                            <svg class="w-5 h-5 text-gray-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <div>
                                <p class="text-sm text-gray-600">Email</p>
                                <p class="font-medium text-gray-900">{{ $motor->pemilik->email }}</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-3">
                            <svg class="w-5 h-5 text-gray-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            <div>
                                <p class="text-sm text-gray-600">Nomor Telepon</p>
                                <p class="font-medium text-gray-900">{{ $motor->pemilik->no_tlpn }}</p>
                            </div>
                        </div>

                        @if($motor->pemilik->alamat)
                        <div class="flex items-start space-x-3">
                            <svg class="w-5 h-5 text-gray-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <div>
                                <p class="text-sm text-gray-600">Alamat</p>
                                <p class="font-medium text-gray-900">{{ $motor->pemilik->alamat }}</p>
                            </div>
                        </div>
                        @endif

                        <div class="flex items-start space-x-3">
                            <svg class="w-5 h-5 text-gray-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <div>
                                <p class="text-sm text-gray-600">Bergabung</p>
                                <p class="font-medium text-gray-900">{{ $motor->pemilik->created_at->format('d F Y') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Owner Stats -->
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <p class="text-sm text-gray-600 mb-3">Statistik Pemilik</p>
                        <div class="space-y-3">
                            @php
                                $ownerMotors = \App\Models\Motor::where('pemilik_id', $motor->pemilik_id)->count();
                                $ownerActiveMotors = \App\Models\Motor::where('pemilik_id', $motor->pemilik_id)
                                    ->where('status', 'tersedia')
                                    ->count();
                            @endphp
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Total Motor:</span>
                                <span class="font-bold text-gray-900">{{ $ownerMotors }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">Motor Aktif:</span>
                                <span class="font-bold text-green-600">{{ $ownerActiveMotors }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Verification Actions -->
            @if($motor->status === 'pending')
            <div class="bg-white rounded-lg shadow-sm p-4 border-2 border-gray-300">
                <h2 class="text-sm font-bold text-gray-900 mb-3">Aksi Verifikasi</h2>
                <div class="space-y-2">
                    <!-- Approve Button -->
                    <button type="button" 
                            onclick="openApproveModal({{ $motor->id }}, '{{ str_replace("'", "\\'", $motor->merk) }}')"
                            class="w-full bg-green-600 hover:bg-green-700 text-white py-2 px-3 rounded-md transition font-medium text-sm shadow-sm flex items-center justify-center">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Verifikasi Sukses
                    </button>

                    <!-- Reject Button -->
                    <button type="button" 
                            onclick="openRejectModal({{ $motor->id }}, '{{ str_replace("'", "\\'", $motor->merk) }}')"
                            class="w-full bg-red-600 hover:bg-red-700 text-white py-2 px-3 rounded-md transition font-medium text-sm shadow-sm flex items-center justify-center">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Verifikasi Gagal
                    </button>
                </div>
            </div>
            @elseif($motor->status === 'tersedia')
            <div class="bg-white rounded-xl shadow-md overflow-hidden border-2 border-green-200">
                <div class="p-8 text-center bg-gradient-to-br from-green-50 to-emerald-50">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-green-500 rounded-full mb-4 shadow-lg">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <p class="text-xl font-bold text-gray-900">Motor Terverifikasi</p>
                    <p class="text-sm text-gray-600 mt-2">Motor ini sudah tersedia untuk disewa</p>
                </div>
            </div>
            @elseif($motor->status === 'rejected')
            <div class="bg-white rounded-xl shadow-md overflow-hidden border-2 border-red-200">
                <div class="p-6 bg-gradient-to-br from-red-50 to-rose-50">
                    <div class="text-center mb-4">
                        <div class="inline-flex items-center justify-center w-20 h-20 bg-red-500 rounded-full mb-4 shadow-lg">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <p class="text-xl font-bold text-gray-900">Motor Ditolak</p>
                    </div>
                    @if($motor->rejection_reason)
                    <div class="bg-white border-l-4 border-red-500 p-4 rounded-lg">
                        <p class="text-sm font-bold text-red-900 mb-2">Alasan Penolakan:</p>
                        <p class="text-sm text-gray-700">{{ $motor->rejection_reason }}</p>
                    </div>
                    @endif
                </div>
            </div>
            @endif


        </div>
    </div>
</div>

<!-- Approve Modal -->
<div id="approveModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-2xl w-full" style="max-width: 500px;">
        <!-- Header -->
        <div class="bg-green-600 px-5 py-4 rounded-t-lg">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-bold text-white">Setujui Verifikasi Motor</h3>
                <button type="button" onclick="closeApproveModal()" class="text-white hover:bg-green-700 rounded-lg p-1.5 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
        
        <form action="" method="POST" id="approveForm">
            @csrf
            <input type="hidden" name="action" value="approve">
            <input type="hidden" id="approveMotorName" value="">
            
            <div class="p-6 space-y-6">
                @if(!$motor->tarifRental)
                <!-- Info Box -->
                <div class="bg-blue-50 border-2 border-blue-300 rounded-lg p-4">
                    <div class="flex items-start gap-3">
                        <svg class="w-6 h-6 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <p class="text-base font-bold text-blue-900 mb-1">Tentukan Tarif Rental</p>
                            <p class="text-sm text-blue-800">Tarif ini akan digunakan saat penyewaan motor</p>
                        </div>
                    </div>
                </div>
                
                <div class="space-y-5">
                    <div>
                        <label for="tarif_harian" class="block text-base font-bold text-gray-900 mb-3">Tarif Harian (per hari)</label>
                        <input type="text" name="tarif_harian" id="tarif_harian" required value="50000"
                               class="w-full border-2 border-gray-400 rounded-lg px-4 py-3 focus:ring-0 focus:border-gray-400 text-base text-gray-900"
                               placeholder="50000"
                               oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                        <p class="text-sm text-gray-700 mt-2 font-medium">Rekomendasi: Rp 50.000 - Rp 100.000</p>
                    </div>
                    
                    <div>
                        <label for="tarif_mingguan" class="block text-base font-bold text-gray-900 mb-3">Tarif Mingguan (7 hari)</label>
                        <input type="text" name="tarif_mingguan" id="tarif_mingguan" required value="300000"
                               class="w-full border-2 border-gray-400 rounded-lg px-4 py-3 focus:ring-0 focus:border-gray-400 text-base text-gray-900"
                               placeholder="300000"
                               oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                        <p class="text-sm text-gray-700 mt-2 font-medium">Rekomendasi: Rp 300.000 - Rp 600.000</p>
                    </div>
                    
                    <div>
                        <label for="tarif_bulanan" class="block text-base font-bold text-gray-900 mb-3">Tarif Bulanan (30 hari)</label>
                        <input type="text" name="tarif_bulanan" id="tarif_bulanan" required value="1000000"
                               class="w-full border-2 border-gray-400 rounded-lg px-4 py-3 focus:ring-0 focus:border-gray-400 text-base text-gray-900"
                               placeholder="1000000"
                               oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                        <p class="text-sm text-gray-700 mt-2 font-medium">Rekomendasi: Rp 1.000.000 - Rp 2.000.000</p>
                    </div>
                </div>
                @else
                <div class="bg-green-50 border-2 border-green-300 rounded-lg p-4">
                    <p class="text-base font-bold text-green-900 mb-3">Tarif Sudah Ditetapkan</p>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center bg-white p-3 rounded-lg border-2 border-gray-200">
                            <span class="text-sm text-gray-700 font-semibold">Harian</span>
                            <span class="font-bold text-base text-green-700">Rp {{ number_format($motor->tarifRental->tarif_harian, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center bg-white p-3 rounded-lg border-2 border-gray-200">
                            <span class="text-sm text-gray-700 font-semibold">Mingguan</span>
                            <span class="font-bold text-base text-green-700">Rp {{ number_format($motor->tarifRental->tarif_mingguan, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center bg-white p-3 rounded-lg border-2 border-gray-200">
                            <span class="text-sm text-gray-700 font-semibold">Bulanan</span>
                            <span class="font-bold text-base text-green-700">Rp {{ number_format($motor->tarifRental->tarif_bulanan, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="tarif_harian" value="{{ $motor->tarifRental->tarif_harian }}">
                <input type="hidden" name="tarif_mingguan" value="{{ $motor->tarifRental->tarif_mingguan }}">
                <input type="hidden" name="tarif_bulanan" value="{{ $motor->tarifRental->tarif_bulanan }}">
                @endif
                
                <div class="bg-yellow-50 border-2 border-yellow-400 rounded-lg p-4">
                    <div class="flex items-start gap-3">
                        <svg class="w-6 h-6 text-yellow-700 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        <div>
                            <p class="text-base font-bold text-yellow-900 mb-1">Perhatian!</p>
                            <p class="text-sm text-yellow-800">Motor akan langsung tersedia untuk disewa setelah disetujui</p>
                        </div>
                    </div>
                </div>
                
                <!-- Buttons -->
                <div class="flex gap-4 pt-2">
                    <button type="button" onclick="closeApproveModal()"
                            class="flex-1 bg-gray-200 text-gray-900 py-3 px-5 rounded-lg hover:bg-gray-300 transition font-bold text-base border-2 border-gray-400">
                        Batal
                    </button>
                    <button type="submit"
                            class="flex-1 bg-green-600 text-white py-3 px-5 rounded-lg hover:bg-green-700 transition font-bold text-base shadow-lg">
                        Setujui Motor
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Rejection Modal -->
<div id="rejectModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-2xl w-full" style="max-width: 500px;">
        <!-- Header -->
        <div class="bg-red-600 px-5 py-4 rounded-t-lg">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-bold text-white">Tolak Verifikasi Motor</h3>
                <button type="button" onclick="closeRejectModal()" class="text-white hover:bg-red-700 rounded-lg p-1.5 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
        
        <form action="" method="POST" id="rejectForm">
            @csrf
            <input type="hidden" name="action" value="reject">
            <input type="hidden" id="rejectMotorName" value="">
            
            <div class="p-6 space-y-6">
                <!-- Warning Box -->
                <div class="bg-red-50 border-2 border-red-300 rounded-lg p-4">
                    <div class="flex items-start gap-3">
                        <svg class="w-6 h-6 text-red-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        <div>
                            <p class="text-base font-bold text-red-900 mb-1">Penting!</p>
                            <p class="text-sm text-red-800">Berikan alasan yang jelas agar pemilik dapat memperbaiki dan mendaftar ulang</p>
                        </div>
                    </div>
                </div>
                
                <!-- Textarea -->
                <div>
                    <label class="block text-base font-bold text-gray-900 mb-3">Alasan Penolakan</label>
                    <textarea name="rejection_reason" id="rejection_reason" rows="4" required
                              class="w-full border-2 border-gray-400 rounded-lg px-4 py-3 focus:ring-0 focus:border-gray-400 text-base text-gray-900 resize-none"
                              placeholder="Contoh: Foto STNK tidak jelas, Dokumen kepemilikan tidak lengkap"></textarea>
                </div>
                
                <!-- Buttons -->
                <div class="flex gap-4 pt-2">
                    <button type="button" onclick="closeRejectModal()"
                            class="flex-1 bg-gray-200 text-gray-900 py-3 px-5 rounded-lg hover:bg-gray-300 transition font-bold text-base border-2 border-gray-400">
                        Batal
                    </button>
                    <button type="submit"
                            class="flex-1 bg-red-600 text-white py-3 px-5 rounded-lg hover:bg-red-700 transition font-bold text-base shadow-lg">
                        Tolak Motor
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Image Lightbox Modal -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-90 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="relative max-w-6xl w-full">
            <!-- Close button -->
            <button onclick="closeImageModal()" class="absolute top-4 right-4 text-white hover:text-gray-300 bg-black bg-opacity-50 rounded-full p-2 z-10">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            <!-- Image -->
            <div class="bg-white rounded-lg p-4">
                <img id="modalImage" src="" alt="" class="w-full h-auto max-h-[80vh] object-contain rounded">
                <div class="mt-3 text-center">
                    <p id="modalImageTitle" class="text-lg font-bold text-gray-900"></p>
                    <p class="text-sm text-gray-500">Klik di luar gambar atau tombol X untuk menutup</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Document Preview Modal -->
<div id="documentModal" class="fixed inset-0 bg-black bg-opacity-90 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="relative max-w-6xl w-full h-[90vh]">
            <!-- Close button -->
            <button onclick="closeDocumentModal()" class="absolute top-4 right-4 text-white hover:text-gray-300 bg-black bg-opacity-50 rounded-full p-2 z-10">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            <!-- Document/Image Preview -->
            <div class="bg-white rounded-lg p-4 h-full flex flex-col">
                <div class="mb-3 text-center">
                    <p id="modalDocumentTitle" class="text-lg font-bold text-gray-900"></p>
                    <p class="text-sm text-gray-500">Dokumen Kepemilikan Motor</p>
                </div>
                <div class="flex-1 overflow-auto bg-gray-100 rounded">
                    <img id="modalDocument" src="" alt="" class="w-full h-auto object-contain">
                </div>
                <div class="mt-3 text-center">
                    <a id="downloadDocumentBtn" href="" download class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                        Download Dokumen
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
console.log('🔧 Motor Verification Detail Script Loaded');

// Fungsi untuk close modal
function closeApproveModal() {
    console.log('Closing approve modal');
    document.getElementById('approveModal').classList.add('hidden');
}

function closeRejectModal() {
    console.log('Closing reject modal');
    document.getElementById('rejectModal').classList.add('hidden');
}

function closeImageModal() {
    document.getElementById('imageModal').classList.add('hidden');
}

function closeDocumentModal() {
    document.getElementById('documentModal').classList.add('hidden');
}

function openApproveModal(motorId, motorName) {
    console.log('✅ Opening Approve Modal for Motor ID:', motorId, 'Name:', motorName);
    const modal = document.getElementById('approveModal');
    const nameSpan = document.getElementById('approveMotorName');
    const form = document.getElementById('approveForm');
    
    console.log('Modal element:', modal);
    console.log('NameSpan element:', nameSpan);
    console.log('Form element:', form);
    
    if (!modal || !nameSpan || !form) {
        console.error('❌ Approve modal elements not found!');
        alert('Error: Modal elements tidak ditemukan!');
        return;
    }
    
    nameSpan.textContent = motorName;
    form.action = '/admin/verify-motor/' + motorId;
    modal.classList.remove('hidden');
    console.log('✅ Approve modal opened successfully. Form action:', form.action);
}

function openRejectModal(motorId, motorName) {
    console.log('❌ Opening Reject Modal for Motor ID:', motorId, 'Name:', motorName);
    const modal = document.getElementById('rejectModal');
    const nameSpan = document.getElementById('rejectMotorName');
    const form = document.getElementById('rejectForm');
    
    console.log('Modal element:', modal);
    console.log('NameSpan element:', nameSpan);
    console.log('Form element:', form);
    
    if (!modal || !nameSpan || !form) {
        console.error('❌ Reject modal elements not found!');
        alert('Error: Modal elements tidak ditemukan!');
        return;
    }
    
    nameSpan.textContent = motorName;
    form.action = '/admin/verify-motor/' + motorId;
    modal.classList.remove('hidden');
    console.log('✅ Reject modal opened successfully. Form action:', form.action);
}

// Close modal dengan click outside
document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 DOMContentLoaded event fired');
    
    ['approveModal', 'rejectModal', 'imageModal', 'documentModal'].forEach(function(modalId) {
        const modal = document.getElementById(modalId);
        if (modal) {
            console.log('✅ Found modal:', modalId);
            modal.addEventListener('click', function(e) {
                if (e.target === this) {
                    this.classList.add('hidden');
                }
            });
        } else {
            console.warn('⚠️ Modal not found:', modalId);
        }
    });
    
    // ESC to close
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeApproveModal();
            closeRejectModal();
            closeImageModal();
            closeDocumentModal();
        }
    });
    
    // Log buttons
    const approveBtn = document.querySelector('[onclick*="openApproveModal"]');
    const rejectBtn = document.querySelector('[onclick*="openRejectModal"]');
    console.log('Approve button found:', !!approveBtn);
    console.log('Reject button found:', !!rejectBtn);
});
</script>
@endpush
