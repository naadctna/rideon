@extends('layouts.app')

@section('title', 'Kelola Penyewaan - Admin')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-2">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Kelola Penyewaan</h1>
                <p class="text-gray-600 mt-1">Monitor dan kelola semua transaksi penyewaan motor</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition duration-200 font-medium inline-flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-lg shadow-md p-4 flex flex-col items-center">
            <div class="p-2 bg-yellow-100 rounded-full">
                <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <p class="text-xs font-medium text-gray-600 mt-2">Menunggu Bayar</p>
            <p class="text-lg font-semibold text-gray-900">{{ $pendingPayment }}</p>
        </div>

        <div class="bg-white rounded-lg shadow-md p-4 flex flex-col items-center">
            <div class="p-2 bg-green-100 rounded-full">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <p class="text-xs font-medium text-gray-600 mt-2">Aktif</p>
            <p class="text-lg font-semibold text-gray-900">{{ $activeRentals }}</p>
        </div>

        <div class="bg-white rounded-lg shadow-md p-4 flex flex-col items-center">
            <div class="p-2 bg-blue-100 rounded-full">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <p class="text-xs font-medium text-gray-600 mt-2">Selesai</p>
            <p class="text-lg font-semibold text-gray-900">{{ $completedRentals }}</p>
        </div>

        <div class="bg-white rounded-lg shadow-md p-4 flex flex-col items-center">
            <div class="p-2 bg-red-100 rounded-full">
                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </div>
            <p class="text-xs font-medium text-gray-600 mt-2">Dibatalkan</p>
            <p class="text-lg font-semibold text-gray-900">{{ $cancelledRentals }}</p>
        </div>
    </div>

    <!-- Rentals List -->
    <div class="bg-white rounded-lg shadow-sm">
        <!-- Header with filters -->
        <div class="px-6 py-5 border-b border-gray-200">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-900">Daftar Penyewaan</h2>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                    {{ $rentals->total() }} Total
                </span>
            </div>
            
            <!-- Filters -->
            <form method="GET" action="{{ route('admin.rental-management') }}" id="filterForm">
                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3">
                    <div class="relative flex-1 w-full sm:w-auto sm:min-w-[280px]">
                        <input type="text" name="search" id="searchInput" placeholder="Cari penyewaan..." 
                               value="{{ request('search') }}"
                               class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               onchange="this.form.submit()">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                    </div>
                    
                    <select name="status" id="statusFilter" class="w-full sm:w-auto border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" onchange="this.form.submit()">
                        <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Semua Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu Pembayaran</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>

                    <select name="sortBy" id="sortBy" class="w-full sm:w-auto border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500" onchange="this.form.submit()">
                        <option value="newest" {{ request('sortBy') == 'newest' || !request('sortBy') ? 'selected' : '' }}>Terbaru</option>
                        <option value="oldest" {{ request('sortBy') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                        <option value="price_high" {{ request('sortBy') == 'price_high' ? 'selected' : '' }}>Harga Tertinggi</option>
                        <option value="price_low" {{ request('sortBy') == 'price_low' ? 'selected' : '' }}>Harga Terendah</option>
                    </select>
                </div>
            </form>
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
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($rentals as $rental)
                        <tr class="hover:bg-gray-50 rental-card"
                            data-search="{{ strtolower($rental->motor->merk . ' ' . $rental->motor->no_plat . ' ' . $rental->penyewa->name) }}"
                            data-status="{{ $rental->status }}"
                            data-date="{{ $rental->created_at->timestamp }}"
                            data-price="{{ $rental->harga ?? 0 }}">
                            
                            <!-- Motor Column -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-16 w-16">
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
                                @if($rental->bukti_pembayaran)
                                <div class="text-xs text-blue-600">
                                    <svg class="w-3 h-3 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    Bukti tersedia
                                </div>
                                @endif
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
                                        'active' => 'Aktif',
                                        'selesai' => 'Selesai',
                                        'dibatalkan' => 'Dibatalkan'
                                    ];
                                @endphp
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColors[$rental->status] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ $statusLabels[$rental->status] ?? ucfirst(str_replace('_', ' ', $rental->status)) }}
                                </span>
                            </td>

                            <!-- Aksi Column -->
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <div class="flex flex-col gap-1.5">
                                    @if($rental->status === 'menunggu_pembayaran' && $rental->bukti_pembayaran)
                                    <button data-action="confirm-payment" data-rental-id="{{ $rental->id }}"
                                            class="bg-green-600 text-white px-3 py-1.5 rounded-lg hover:bg-green-700 transition duration-200 text-xs font-medium">
                                        Konfirmasi Bayar
                                    </button>
                                    @endif

                                    @if($rental->status === 'aktif')
                                    <button data-action="confirm-return" data-rental-id="{{ $rental->id }}"
                                            class="bg-blue-600 text-white px-3 py-1.5 rounded-lg hover:bg-blue-700 transition duration-200 text-xs font-medium">
                                        Konfirmasi Kembali
                                    </button>
                                    @endif

                                    <div class="flex gap-1.5">
                                        <button data-action="view-details" data-rental-id="{{ $rental->id }}"
                                                class="flex-1 bg-gray-600 text-white px-3 py-1.5 rounded-full hover:bg-gray-700 transition duration-200 text-xs font-medium">
                                            Detail
                                        </button>

                                        <a href="{{ route('admin.rental.export-pdf', $rental->id) }}" target="_blank"
                                           class="flex-1 bg-red-600 text-white px-3 py-1.5 rounded-full hover:bg-red-700 transition duration-200 text-xs font-medium text-center">
                                            PDF
                                        </a>
                                    </div>
                                    
                                    @if($rental->bukti_pembayaran)
                                    <button data-action="view-payment-proof" data-rental-id="{{ $rental->id }}"
                                            class="bg-purple-600 text-white px-3 py-1.5 rounded-lg hover:bg-purple-700 transition duration-200 text-xs font-medium">
                                        Lihat Bukti
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="px-6 py-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Belum Ada Penyewaan</h3>
                    <p class="mt-1 text-sm text-gray-500">Belum ada transaksi penyewaan yang perlu dikelola.</p>
                </div>
            @endif
        </div>

        <!-- Pagination -->
        @if($rentals->count() > 0)
        <div class="px-6 py-4 bg-white border-t border-gray-200">
            {{ $rentals->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Payment Proof Modal -->
<div id="paymentProofModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Bukti Pembayaran</h3>
                    <button onclick="closePaymentProofModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div id="paymentProofContent">
                    <!-- Content will be loaded here -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Rental Details Modal -->
<div id="rentalDetailsModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50 overflow-y-auto">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full my-8">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Detail Penyewaan</h3>
                    <button onclick="closeRentalDetailsModal()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div id="rentalDetailsContent">
                    <!-- Content will be loaded here -->
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Event delegation for action buttons
    document.addEventListener('click', function(e) {
        if (e.target.dataset.action) {
            const action = e.target.dataset.action;
            const rentalId = e.target.dataset.rentalId;
            
            switch(action) {
                case 'confirm-payment':
                    confirmPayment(rentalId);
                    break;
                case 'confirm-return':
                    confirmReturn(rentalId);
                    break;
                case 'view-details':
                    viewRentalDetails(rentalId);
                    break;
                case 'view-payment-proof':
                    viewPaymentProof(rentalId);
                    break;
            }
        }
    });

    // Search and filter functionality
    document.getElementById('searchInput').addEventListener('input', function() {
        filterRentals();
    });

    document.getElementById('statusFilter').addEventListener('change', function() {
        filterRentals();
    });

    document.getElementById('sortBy').addEventListener('change', function() {
        sortRentals();
    });

    function filterRentals() {
        const searchTerm = document.getElementById('searchInput').value.toLowerCase();
        const statusFilter = document.getElementById('statusFilter').value;
        const cards = document.querySelectorAll('.rental-card');

        cards.forEach(card => {
            const searchData = card.getAttribute('data-search');
            const cardStatus = card.getAttribute('data-status');
            
            const matchesSearch = searchData.includes(searchTerm);
            const matchesStatus = !statusFilter || cardStatus === statusFilter;
            
            if (matchesSearch && matchesStatus) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    }

    function sortRentals() {
        const sortBy = document.getElementById('sortBy').value;
        const container = document.getElementById('rentalsContainer');
        const cards = Array.from(container.querySelectorAll('.rental-card'));

        cards.sort((a, b) => {
            switch(sortBy) {
                case 'newest':
                    return parseInt(b.getAttribute('data-date')) - parseInt(a.getAttribute('data-date'));
                case 'oldest':
                    return parseInt(a.getAttribute('data-date')) - parseInt(b.getAttribute('data-date'));
                case 'price_high':
                    return parseInt(b.getAttribute('data-price')) - parseInt(a.getAttribute('data-price'));
                case 'price_low':
                    return parseInt(a.getAttribute('data-price')) - parseInt(b.getAttribute('data-price'));
                default:
                    return 0;
            }
        });

        const parent = cards[0].parentNode;
        cards.forEach(card => parent.appendChild(card));
    }

    // Action functions
    function confirmPayment(rentalId) {
        if (confirm('Konfirmasi pembayaran untuk penyewaan ini?')) {
            fetch(`/admin/confirm-payment/${rentalId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Terjadi kesalahan: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat konfirmasi pembayaran');
            });
        }
    }

    function confirmReturn(rentalId) {
        if (confirm('Konfirmasi pengembalian motor untuk penyewaan ini?')) {
            fetch(`/admin/confirm-return/${rentalId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Terjadi kesalahan: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat konfirmasi pengembalian');
            });
        }
    }

    function viewPaymentProof(rentalId) {
        document.getElementById('paymentProofModal').classList.remove('hidden');
        document.getElementById('paymentProofContent').innerHTML = '<div class="text-center py-4">Loading...</div>';
        
        // Load payment proof content via AJAX
        fetch(`/admin/rental/${rentalId}/payment-proof`)
            .then(response => response.json())
            .then(data => {
                const html = `
                    <div class="text-center">
                        <img src="${data.bukti_pembayaran}" 
                             alt="Bukti Pembayaran" 
                             class="max-w-full h-auto rounded-lg shadow-lg mx-auto">
                        <p class="mt-4 text-sm text-gray-600">ID Penyewaan: #${data.rental_id}</p>
                        <a href="${data.bukti_pembayaran}" 
                           target="_blank" 
                           class="mt-4 inline-block bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                            Buka di Tab Baru
                        </a>
                    </div>
                `;
                document.getElementById('paymentProofContent').innerHTML = html;
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('paymentProofContent').innerHTML = '<div class="text-red-500 text-center">Gagal memuat bukti pembayaran</div>';
            });
    }

    function viewRentalDetails(rentalId) {
        document.getElementById('rentalDetailsModal').classList.remove('hidden');
        document.getElementById('rentalDetailsContent').innerHTML = '<div class="text-center py-4">Loading...</div>';
        
        // Load rental details via AJAX
        fetch(`/admin/rental/${rentalId}/details`)
            .then(response => response.json())
            .then(data => {
                const rental = data.rental;
                const html = `
                    <div class="space-y-4">
                        <!-- Motor Info -->
                        <div class="border-b pb-4">
                            <h4 class="font-semibold text-gray-900 mb-3">Informasi Motor</h4>
                            <div class="grid grid-cols-2 gap-3 text-sm">
                                <div>
                                    <p class="text-gray-500">Merk</p>
                                    <p class="font-medium">${rental.motor.merk}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500">Tipe CC</p>
                                    <p class="font-medium">${rental.motor.tipe_cc}cc</p>
                                </div>
                                <div>
                                    <p class="text-gray-500">No. Plat</p>
                                    <p class="font-medium">${rental.motor.no_plat}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Renter Info -->
                        <div class="border-b pb-4">
                            <h4 class="font-semibold text-gray-900 mb-3">Informasi Penyewa</h4>
                            <div class="grid grid-cols-2 gap-3 text-sm">
                                <div>
                                    <p class="text-gray-500">Nama</p>
                                    <p class="font-medium">${rental.penyewa.name}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500">Email</p>
                                    <p class="font-medium">${rental.penyewa.email}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500">No. Telepon</p>
                                    <p class="font-medium">${rental.penyewa.no_tlpn}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500">Alamat</p>
                                    <p class="font-medium">${rental.penyewa.alamat}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Rental Info -->
                        <div class="border-b pb-4">
                            <h4 class="font-semibold text-gray-900 mb-3">Detail Penyewaan</h4>
                            <div class="grid grid-cols-2 gap-3 text-sm">
                                <div>
                                    <p class="text-gray-500">Status</p>
                                    <p class="font-medium capitalize">${rental.status.replace(/_/g, ' ')}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500">Tipe Durasi</p>
                                    <p class="font-medium capitalize">${rental.tipe_durasi}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500">Tanggal Mulai</p>
                                    <p class="font-medium">${rental.tanggal_mulai}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500">Tanggal Selesai</p>
                                    <p class="font-medium">${rental.tanggal_selesai}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500">Durasi</p>
                                    <p class="font-medium">${rental.durasi}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500">Total Harga</p>
                                    <p class="font-bold text-green-600">${rental.harga}</p>
                                </div>
                            </div>
                        </div>

                        ${rental.transaksi ? `
                        <!-- Transaction Info -->
                        <div>
                            <h4 class="font-semibold text-gray-900 mb-3">Informasi Transaksi</h4>
                            <div class="grid grid-cols-2 gap-3 text-sm">
                                <div>
                                    <p class="text-gray-500">ID Transaksi</p>
                                    <p class="font-medium">#${rental.transaksi.id}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500">Metode Pembayaran</p>
                                    <p class="font-medium capitalize">${rental.transaksi.metode_pembayaran}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500">Status Pembayaran</p>
                                    <p class="font-medium capitalize">${rental.transaksi.status}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500">Jumlah</p>
                                    <p class="font-bold text-green-600">${rental.transaksi.jumlah}</p>
                                </div>
                            </div>
                        </div>
                        ` : ''}
                    </div>
                `;
                document.getElementById('rentalDetailsContent').innerHTML = html;
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('rentalDetailsContent').innerHTML = '<div class="text-red-500 text-center">Gagal memuat detail penyewaan</div>';
            });
    }

    function closePaymentProofModal() {
        document.getElementById('paymentProofModal').classList.add('hidden');
    }

    function closeRentalDetailsModal() {
        document.getElementById('rentalDetailsModal').classList.add('hidden');
    }

    // Close modals when clicking outside
    document.getElementById('paymentProofModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closePaymentProofModal();
        }
    });

    document.getElementById('rentalDetailsModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeRentalDetailsModal();
        }
    });

    // Print rental function
    function printRental(rentalId) {
        console.log('Print rental ID:', rentalId);
        fetch(`/admin/rental/${rentalId}/details`)
            .then(response => {
                console.log('Response status:', response.status);
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log('Data received:', data);
                const rental = data.rental;
                const printWindow = window.open('', '_blank', 'width=800,height=600');
                
                if (!printWindow) {
                    alert('Pop-up diblokir oleh browser. Silakan izinkan pop-up untuk fitur print.');
                    return;
                }
                
                printWindow.document.write(`
                    <!DOCTYPE html>
                    <html>
                    <head>
                        <title>Struk Penyewaan #${rental.id}</title>
                        <meta charset="UTF-8">
                        <style>
                            body { font-family: Arial, sans-serif; padding: 20px; }
                            .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #000; padding-bottom: 10px; }
                            .header h1 { margin: 0; font-size: 24px; }
                            .header p { margin: 5px 0; color: #666; }
                            .section { margin: 20px 0; }
                            .section-title { font-weight: bold; font-size: 16px; margin-bottom: 10px; border-bottom: 1px solid #ccc; padding-bottom: 5px; }
                            .row { display: flex; justify-content: space-between; padding: 5px 0; }
                            .label { font-weight: bold; }
                            .value { text-align: right; }
                            .total { font-size: 18px; font-weight: bold; color: #059669; margin-top: 10px; padding-top: 10px; border-top: 2px solid #000; }
                            @media print {
                                body { padding: 0; }
                                button { display: none; }
                            }
                        </style>
                    </head>
                    <body>
                        <div class="header">
                            <h1>STRUK PENYEWAAN MOTOR</h1>
                            <p>RideOn Motor Rental</p>
                            <p>ID Transaksi: #${rental.id}</p>
                            <p>Tanggal: ${rental.created_at}</p>
                        </div>
                        
                        <div class="section">
                            <div class="section-title">Informasi Motor</div>
                            <div class="row"><span class="label">Merek:</span><span class="value">${rental.motor.merk}</span></div>
                            <div class="row"><span class="label">Tipe:</span><span class="value">${rental.motor.tipe_cc}cc</span></div>
                            <div class="row"><span class="label">Nomor Plat:</span><span class="value">${rental.motor.no_plat}</span></div>
                        </div>
                        
                        <div class="section">
                            <div class="section-title">Informasi Penyewa</div>
                            <div class="row"><span class="label">Nama:</span><span class="value">${rental.penyewa.name}</span></div>
                            <div class="row"><span class="label">Email:</span><span class="value">${rental.penyewa.email}</span></div>
                            <div class="row"><span class="label">No. Telepon:</span><span class="value">${rental.penyewa.no_tlpn || '-'}</span></div>
                        </div>
                        
                        <div class="section">
                            <div class="section-title">Detail Penyewaan</div>
                            <div class="row"><span class="label">Tanggal Mulai:</span><span class="value">${rental.tanggal_mulai}</span></div>
                            <div class="row"><span class="label">Tanggal Selesai:</span><span class="value">${rental.tanggal_selesai}</span></div>
                            <div class="row"><span class="label">Durasi:</span><span class="value">${rental.durasi}</span></div>
                            <div class="row"><span class="label">Tipe Durasi:</span><span class="value">${rental.tipe_durasi}</span></div>
                            <div class="row"><span class="label">Status:</span><span class="value">${rental.status.replace('_', ' ').toUpperCase()}</span></div>
                        </div>
                        
                        <div class="section">
                            <div class="row total">
                                <span class="label">TOTAL HARGA:</span>
                                <span class="value">${rental.harga}</span>
                            </div>
                        </div>
                        
                        <div style="margin-top: 30px; text-align: center;">
                            <button onclick="window.print()" style="background: #4F46E5; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-size: 14px;">Print</button>
                            <button onclick="window.close()" style="background: #6B7280; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-size: 14px; margin-left: 10px;">Tutup</button>
                        </div>
                    </body>
                    </html>
                `);
                printWindow.document.close();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Gagal memuat data untuk print. Error: ' + error.message);
            });
    }
</script>
@endpush