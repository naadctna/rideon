@extends('layouts.app')

@section('title', 'Laporan - Admin')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-green-500">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Laporan Sistem</h1>
                <p class="text-gray-600 mt-1">Analisis dan statistik komprehensif sistem penyewaan</p>
            </div>
            <div class="flex items-center space-x-3">
                <button data-action="export-report" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition duration-200 font-medium">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Export PDF
                </button>
            </div>
        </div>
    </div>

    <!-- Time Period Filter -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
            <h2 class="text-lg font-semibold text-gray-900">Filter Periode</h2>
            <div class="flex items-center space-x-4">
                <select id="periodFilter" class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500">
                    <option value="this_month">Bulan Ini</option>
                    <option value="last_month">Bulan Lalu</option>
                    <option value="this_year">Tahun Ini</option>
                    <option value="last_year">Tahun Lalu</option>
                    <option value="custom">Periode Custom</option>
                </select>
                <div id="customDateRange" class="hidden flex items-center space-x-2">
                    <input type="date" id="startDate" class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500">
                    <span class="text-gray-500">-</span>
                    <input type="date" id="endDate" class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500">
                </div>
                <button data-action="apply-filter" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition duration-200">
                    Apply
                </button>
            </div>
        </div>
    </div>

    <!-- Overview Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-full">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Revenue</p>
                    <p class="text-2xl font-bold text-gray-900">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                    <p class="text-sm text-green-600">+{{ $revenueGrowth }}% dari periode sebelumnya</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-full">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Transaksi</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalTransactions }}</p>
                    <p class="text-sm text-blue-600">{{ $avgTransactionValue }}k rata-rata</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center">
                <div class="p-3 bg-purple-100 rounded-full">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Pengguna Aktif</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $activeUsers }}</p>
                    <p class="text-sm text-purple-600">{{ $newUsers }} pengguna baru</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center">
                <div class="p-3 bg-orange-100 rounded-full">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Motor Terdaftar</p>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalMotors }}</p>
                    <p class="text-sm text-orange-600">{{ $averageRating }}/5 rating rata-rata</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Revenue Chart -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-semibold text-gray-900">Revenue Trend</h2>
                <div class="flex items-center space-x-2">
                    <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                    <span class="text-sm text-gray-600">Revenue</span>
                    <div class="w-3 h-3 bg-green-500 rounded-full ml-4"></div>
                    <span class="text-sm text-gray-600">Komisi Admin</span>
                </div>
            </div>
            
            <div class="h-80">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>

        <!-- Transaction Volume Chart -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-semibold text-gray-900">Volume Transaksi</h2>
            </div>
            
            <div class="h-80">
                <canvas id="transactionChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Additional Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Motor Categories -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-6">Motor Populer (Top 10)</h2>
            <div class="space-y-4">
                @foreach($popularMotors as $motor)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">{{ $motor->merk }}</p>
                            <p class="text-sm text-gray-500">{{ $motor->no_plat }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-bold text-gray-900">{{ $motor->total_bookings }}</p>
                        <p class="text-xs text-gray-500">booking</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Revenue Sharing -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-6">Bagi Hasil Bulanan</h2>
            <div class="space-y-4">
                <div class="bg-green-50 p-4 rounded-lg border-l-4 border-green-400">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="font-medium text-green-800">Komisi Admin (30%)</p>
                            <p class="text-2xl font-bold text-green-900">Rp {{ number_format($adminCommission, 0, ',', '.') }}</p>
                        </div>
                        <div class="text-green-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-blue-50 p-4 rounded-lg border-l-4 border-blue-400">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="font-medium text-blue-800">Total untuk Pemilik (70%)</p>
                            <p class="text-2xl font-bold text-blue-900">Rp {{ number_format($ownerRevenue, 0, ',', '.') }}</p>
                        </div>
                        <div class="text-blue-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Top Earning Owners -->
                <div class="mt-6">
                    <h3 class="font-medium text-gray-900 mb-3">Top Pemilik Berpenghasilan</h3>
                    <div class="space-y-2">
                        @foreach($topEarningOwners->take(5) as $owner)
                        <div class="flex justify-between items-center p-2 bg-gray-50 rounded">
                            <span class="text-sm font-medium text-gray-900">{{ $owner->name }}</span>
                            <span class="text-sm font-bold text-green-600">Rp {{ number_format($owner->total_earnings, 0, ',', '.') }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed Tables -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-lg font-semibold text-gray-900">Transaksi Terkini</h2>
            <a href="{{ route('admin.rental-management') }}" class="text-blue-600 hover:text-blue-500 text-sm font-medium">Lihat Semua</a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Motor</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Penyewa</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Komisi</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($recentTransactions as $transaction)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">#{{ $transaction->id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div>
                                <div class="text-sm font-medium text-gray-900">{{ $transaction->motor->merk }}</div>
                                <div class="text-sm text-gray-500">{{ $transaction->motor->no_plat }}</div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $transaction->penyewa->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Rp {{ number_format($transaction->harga, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-green-600">Rp {{ number_format($transaction->harga * 0.3, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $statusColors = [
                                    'menunggu_pembayaran' => 'bg-yellow-100 text-yellow-800',
                                    'aktif' => 'bg-green-100 text-green-800',
                                    'selesai' => 'bg-blue-100 text-blue-800',
                                    'dibatalkan' => 'bg-red-100 text-red-800'
                                ];
                            @endphp
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $statusColors[$transaction->status] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ ucfirst(str_replace('_', ' ', $transaction->status)) }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Chart data from PHP -->
<script type="application/json" id="chartData">
{
    "monthlyRevenueKeys": {!! json_encode(array_keys($monthlyRevenue ?? [])) !!},
    "monthlyRevenueValues": {!! json_encode(array_values($monthlyRevenue ?? [])) !!},
    "monthlyTransactionKeys": {!! json_encode(array_keys($monthlyTransactions ?? [])) !!},
    "monthlyTransactionValues": {!! json_encode(array_values($monthlyTransactions ?? [])) !!}
}
</script>

<script>
    // Event delegation for action buttons
    document.addEventListener('click', function(e) {
        if (e.target.dataset.action) {
            const action = e.target.dataset.action;
            
            switch(action) {
                case 'export-report':
                    exportReport();
                    break;
                case 'apply-filter':
                    applyFilter();
                    break;
            }
        }
    });

    // Period filter functionality
    document.getElementById('periodFilter').addEventListener('change', function() {
        const customDateRange = document.getElementById('customDateRange');
        if (this.value === 'custom') {
            customDateRange.classList.remove('hidden');
        } else {
            customDateRange.classList.add('hidden');
        }
    });

    function applyFilter() {
        // This would trigger a page reload with new filter parameters
        const period = document.getElementById('periodFilter').value;
        let url = new URL(window.location);
        url.searchParams.set('period', period);
        
        if (period === 'custom') {
            const startDate = document.getElementById('startDate').value;
            const endDate = document.getElementById('endDate').value;
            if (startDate && endDate) {
                url.searchParams.set('start_date', startDate);
                url.searchParams.set('end_date', endDate);
            }
        }
        
        window.location = url;
    }

    function exportReport() {
        // This would generate and download a PDF report
        window.location.href = '/admin/reports/export';
    }

    // Initialize charts
    document.addEventListener('DOMContentLoaded', function() {
        // Get data from embedded JSON
        const chartDataElement = document.getElementById('chartData');
        if (!chartDataElement) return;
        
        const chartData = JSON.parse(chartDataElement.textContent);

        // Revenue Chart
        const revenueCtx = document.getElementById('revenueChart');
        if (revenueCtx) {
            new Chart(revenueCtx.getContext('2d'), {
                type: 'line',
                data: {
                    labels: chartData.monthlyRevenueKeys.map(month => {
                        const date = new Date();
                        date.setMonth(month - 1);
                        return date.toLocaleDateString('id-ID', { month: 'short' });
                    }),
                    datasets: [{
                        label: 'Total Revenue',
                        data: chartData.monthlyRevenueValues,
                        borderColor: 'rgb(59, 130, 246)',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        tension: 0.4
                    }, {
                        label: 'Komisi Admin',
                        data: chartData.monthlyRevenueValues.map(value => value * 0.3),
                        borderColor: 'rgb(34, 197, 94)',
                        backgroundColor: 'rgba(34, 197, 94, 0.1)',
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'Rp ' + (value / 1000000).toFixed(1) + 'M';
                                }
                            }
                        }
                    }
                }
            });
        }

        // Transaction Volume Chart
        const transactionCtx = document.getElementById('transactionChart');
        if (transactionCtx) {
            new Chart(transactionCtx.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: chartData.monthlyTransactionKeys.map(month => {
                        const date = new Date();
                        date.setMonth(month - 1);
                        return date.toLocaleDateString('id-ID', { month: 'short' });
                    }),
                    datasets: [{
                        label: 'Jumlah Transaksi',
                        data: chartData.monthlyTransactionValues,
                        backgroundColor: 'rgba(139, 69, 19, 0.8)',
                        borderColor: 'rgb(139, 69, 19)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }
    });
</script>
@endpush