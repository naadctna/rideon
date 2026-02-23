@extends('layouts.app')

@section('title', 'Laporan Transaksi - Admin')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Laporan Transaksi Penyewaan</h1>
                <p class="text-gray-600 mt-1">Laporan transaksi penyewaan per bulan yang dapat dicetak dan di-download PDF</p>
            </div>
            <div class="flex gap-2 no-print">
                <a href="{{ route('admin.dashboard') }}" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition duration-200 font-medium inline-flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali
                </a>
                <a href="{{ route('admin.reports.export') }}?month={{ $month }}&status={{ $status }}&format=pdf" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition duration-200 font-medium inline-flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Download PDF
                </a>
            </div>
        </div>

        <!-- Filter Form -->
        <form method="GET" action="{{ route('admin.reports') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4 no-print">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Bulan</label>
                <select name="month" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" onchange="this.form.submit()">
                    @foreach($availableMonths as $monthOption)
                    <option value="{{ $monthOption['value'] }}" {{ $month == $monthOption['value'] ? 'selected' : '' }}>
                        {{ $monthOption['label'] }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" onchange="this.form.submit()">
                    <option value="all" {{ $status == 'all' ? 'selected' : '' }}>Semua Status</option>
                    <option value="menunggu_pembayaran" {{ $status == 'menunggu_pembayaran' ? 'selected' : '' }}>Menunggu Pembayaran</option>
                    <option value="aktif" {{ $status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="active" {{ $status == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="selesai" {{ $status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="dibatalkan" {{ $status == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
            </div>

            <div class="flex items-end">
                <button type="submit" class="w-full bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition duration-200 font-medium">
                    Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Transaksi</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalRentals }}</p>
                </div>
                <div class="p-3 bg-blue-100 rounded-full">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Aktif</p>
                    <p class="text-3xl font-bold text-green-600 mt-2">{{ $activeRentals }}</p>
                </div>
                <div class="p-3 bg-green-100 rounded-full">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Pendapatan</p>
                    <p class="text-2xl font-bold text-green-600 mt-2">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                </div>
                <div class="p-3 bg-green-100 rounded-full">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Komisi Admin (30%)</p>
                    <p class="text-2xl font-bold text-purple-600 mt-2">Rp {{ number_format($adminRevenue, 0, ',', '.') }}</p>
                </div>
                <div class="p-3 bg-purple-100 rounded-full">
                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Print Title (Only visible when printing) -->
    <div class="print-only bg-white rounded-lg shadow-sm p-6 mb-4" style="display: none;">
        <h1 class="text-2xl font-bold text-gray-900 text-center">Laporan Transaksi Penyewaan</h1>
        <p class="text-gray-600 text-center mt-2">Periode: {{ \Carbon\Carbon::parse($month . '-01')->format('F Y') }}</p>
        <p class="text-gray-600 text-center">Dicetak pada {{ \Carbon\Carbon::now()->format('d F Y H:i') }}</p>
        <div class="mt-4 grid grid-cols-4 gap-4 text-sm border-t border-b border-gray-200 py-3">
            <div class="text-center">
                <p class="text-gray-600">Total Transaksi</p>
                <p class="font-bold text-lg">{{ $totalRentals }}</p>
            </div>
            <div class="text-center">
                <p class="text-gray-600">Aktif</p>
                <p class="font-bold text-lg">{{ $activeRentals }}</p>
            </div>
            <div class="text-center">
                <p class="text-gray-600">Total Pendapatan</p>
                <p class="font-bold text-lg">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
            </div>
            <div class="text-center">
                <p class="text-gray-600">Komisi Admin</p>
                <p class="font-bold text-lg">Rp {{ number_format($adminRevenue, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>

    <!-- Transactions Table -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">
                Daftar Transaksi - {{ \Carbon\Carbon::parse($month . '-01')->format('F Y') }}
            </h2>
        </div>

        <div class="overflow-x-auto">
            @if($rentals->count() > 0)
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Motor</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Penyewa</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Durasi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Harga</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Komisi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($rentals as $rental)
                        <tr class="hover:bg-gray-50">
                            <!-- Motor Column -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-16 w-16 no-print">
                                        @if($rental->motor->photo)
                                        <img class="h-16 w-16 rounded-lg object-cover border border-gray-200" src="{{ asset('storage/' . $rental->motor->photo) }}" alt="{{ $rental->motor->merk }}">
                                        @else
                                        <div class="h-16 w-16 rounded-lg bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center border border-gray-300">
                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <circle cx="12" cy="12" r="9" stroke-width="2"></circle>
                                                <circle cx="12" cy="12" r="3" stroke-width="2"></circle>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v6m0 6v6m9-9h-6m-6 0H3"></path>
                                            </svg>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-semibold text-gray-900">{{ $rental->motor->merk }}</div>
                                        <div class="text-sm text-gray-500">{{ $rental->motor->tipe_cc }}cc • {{ $rental->motor->no_plat }}</div>
                                        <div class="text-xs text-gray-400">ID: #{{ $rental->id }}</div>
                                    </div>
                                </div>
                            </td>

                            <!-- Penyewa Column -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $rental->penyewa->name }}</div>
                                <div class="text-sm text-gray-500">{{ $rental->penyewa->email }}</div>
                            </td>

                            <!-- Durasi Column -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($rental->tanggal_mulai)->diffInDays($rental->tanggal_selesai) + 1 }} hari</div>
                                <div class="text-xs text-gray-500">{{ ucfirst($rental->tipe_durasi ?? 'N/A') }}</div>
                            </td>

                            <!-- Tanggal Column -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ \Carbon\Carbon::parse($rental->tanggal_mulai)->format('d/m/Y') }}</div>
                                <div class="text-xs text-gray-500">s/d {{ \Carbon\Carbon::parse($rental->tanggal_selesai)->format('d/m/Y') }}</div>
                            </td>

                            <!-- Total Harga Column -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-semibold text-green-600">Rp {{ number_format($rental->harga ?? 0, 0, ',', '.') }}</div>
                            </td>

                            <!-- Komisi Column -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-semibold text-purple-600">Rp {{ number_format(($rental->harga ?? 0) * 0.30, 0, ',', '.') }}</div>
                            </td>

                            <!-- Status Column -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $statusColors = [
                                        'menunggu_pembayaran' => 'bg-yellow-100 text-yellow-800',
                                        'aktif' => 'bg-green-100 text-green-700',
                                        'active' => 'bg-green-100 text-green-700',
                                        'selesai' => 'bg-blue-100 text-blue-800',
                                        'dibatalkan' => 'bg-red-100 text-red-800'
                                    ];
                                    
                                    $statusLabels = [
                                        'menunggu_pembayaran' => 'Menunggu Pembayaran',
                                        'aktif' => 'Aktif',
                                        'active' => 'Active',
                                        'selesai' => 'Selesai',
                                        'dibatalkan' => 'Dibatalkan'
                                    ];
                                @endphp
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColors[$rental->status] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ $statusLabels[$rental->status] ?? ucfirst(str_replace('_', ' ', $rental->status)) }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50">
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-right font-bold text-gray-900">TOTAL:</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-green-600">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-purple-600">Rp {{ number_format($adminRevenue, 0, ',', '.') }}</div>
                            </td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            @else
                <div class="px-6 py-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak Ada Transaksi</h3>
                    <p class="mt-1 text-sm text-gray-500">Belum ada transaksi untuk bulan yang dipilih.</p>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    @media print {
        .no-print {
            display: none !important;
        }
        
        .print-only {
            display: block !important;
        }
        
        body {
            background: white;
        }
        
        .bg-white {
            background-color: white !important;
        }
        
        .shadow-sm, .shadow-md {
            box-shadow: none !important;
        }
        
        /* Hide summary cards when printing */
        .grid.grid-cols-1.md\:grid-cols-4 {
            display: none !important;
        }
        
        /* Add print header */
        .bg-white.rounded-lg.shadow-sm.overflow-hidden::before {
            content: "Daftar Transaksi - " attr(data-month);
            display: block;
            background: #1e40af;
            color: white;
            padding: 20px;
            font-size: 20px;
            font-weight: bold;
            margin: -6px -6px 20px -6px;
        }
        
        table {
            page-break-inside: auto;
        }
        
        tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }
        
        thead {
            display: table-header-group;
        }
        
        tfoot {
            display: table-footer-group;
        }
        
        /* Hide motor images when printing */
        .flex-shrink-0.h-16.w-16 {
            display: none !important;
        }
        
        /* Adjust motor column spacing */
        td .ml-4 {
            margin-left: 0 !important;
        }
    }
</style>
@endsection