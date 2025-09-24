@extends('layouts.app')

@section('title', 'Kelola Penyewaan - Admin')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-blue-500">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Kelola Penyewaan</h1>
                <p class="text-gray-600 mt-1">Monitor dan kelola semua transaksi penyewaan motor</p>
            </div>
            <div class="flex items-center space-x-4">
                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">
                    {{ $rentals->count() }} Total Penyewaan
                </span>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-yellow-500">
            <div class="flex items-center">
                <div class="p-2 bg-yellow-100 rounded-full">
                    <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-600">Menunggu Bayar</p>
                    <p class="text-lg font-bold text-gray-900">{{ $pendingPayment }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-green-500">
            <div class="flex items-center">
                <div class="p-2 bg-green-100 rounded-full">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-600">Aktif</p>
                    <p class="text-lg font-bold text-gray-900">{{ $activeRentals }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-purple-500">
            <div class="flex items-center">
                <div class="p-2 bg-purple-100 rounded-full">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-600">Perlu Konfirmasi</p>
                    <p class="text-lg font-bold text-gray-900">{{ $needsConfirmation }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-sm p-4 border-l-4 border-blue-500">
            <div class="flex items-center">
                <div class="p-2 bg-blue-100 rounded-full">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-600">Selesai</p>
                    <p class="text-lg font-bold text-gray-900">{{ $completedRentals }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-4 lg:space-y-0">
            <div class="flex flex-col sm:flex-row items-start sm:items-center space-y-4 sm:space-y-0 sm:space-x-4">
                <div class="relative">
                    <input type="text" id="searchInput" placeholder="Cari penyewaan..." 
                           class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>
                
                <select id="statusFilter" class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Status</option>
                    <option value="menunggu_pembayaran">Menunggu Pembayaran</option>
                    <option value="aktif">Aktif</option>
                    <option value="selesai">Selesai</option>
                    <option value="dibatalkan">Dibatalkan</option>
                </select>

                <select id="sortBy" class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
                    <option value="newest">Terbaru</option>
                    <option value="oldest">Terlama</option>
                    <option value="price_high">Harga Tertinggi</option>
                    <option value="price_low">Harga Terendah</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Rentals List -->
    <div id="rentalsContainer">
        @if($rentals->count() > 0)
            <div class="space-y-4">
                @foreach($rentals as $rental)
                <div class="bg-white rounded-lg shadow-md overflow-hidden rental-card border-l-4 {{ $rental->status === 'menunggu_pembayaran' ? 'border-yellow-500' : ($rental->status === 'aktif' ? 'border-green-500' : ($rental->status === 'selesai' ? 'border-blue-500' : 'border-gray-300')) }}"
                     data-search="{{ strtolower($rental->motor->merk . ' ' . $rental->motor->no_plat . ' ' . $rental->penyewa->name) }}"
                     data-status="{{ $rental->status }}"
                     data-date="{{ $rental->created_at->timestamp }}"
                     data-price="{{ $rental->harga }}">
                    
                    <div class="p-6">
                        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between space-y-4 lg:space-y-0">
                            
                            <!-- Rental Info -->
                            <div class="flex-1">
                                <div class="flex items-start space-x-4">
                                    <!-- Motor Image -->
                                    <div class="w-20 h-20 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0">
                                        @if($rental->motor->foto_motor)
                                            <img src="{{ asset('storage/' . $rental->motor->foto_motor) }}" 
                                                 alt="{{ $rental->motor->merk }}" 
                                                 class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center bg-gray-200">
                                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Details -->
                                    <div class="flex-1">
                                        <div class="flex items-start justify-between">
                                            <div>
                                                <h3 class="text-lg font-bold text-gray-900">{{ $rental->motor->merk }}</h3>
                                                <p class="text-gray-600">{{ $rental->motor->tipe }} • {{ $rental->motor->no_plat }}</p>
                                                <p class="text-sm text-gray-500 mt-1">ID: #{{ $rental->id }}</p>
                                            </div>
                                            
                                            <!-- Status Badge -->
                                            @php
                                                $statusColors = [
                                                    'menunggu_pembayaran' => 'bg-yellow-100 text-yellow-800',
                                                    'aktif' => 'bg-green-100 text-green-800',
                                                    'selesai' => 'bg-blue-100 text-blue-800',
                                                    'dibatalkan' => 'bg-red-100 text-red-800'
                                                ];
                                            @endphp
                                            <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full {{ $statusColors[$rental->status] ?? 'bg-gray-100 text-gray-800' }}">
                                                {{ ucfirst(str_replace('_', ' ', $rental->status)) }}
                                            </span>
                                        </div>

                                        <!-- Rental Details -->
                                        <div class="mt-3 grid grid-cols-2 lg:grid-cols-4 gap-3 text-sm">
                                            <div>
                                                <p class="text-gray-500">Penyewa</p>
                                                <p class="font-medium text-gray-900">{{ $rental->penyewa->name }}</p>
                                            </div>
                                            <div>
                                                <p class="text-gray-500">Durasi</p>
                                                <p class="font-medium text-gray-900">{{ $rental->lama_sewa }} hari</p>
                                            </div>
                                            <div>
                                                <p class="text-gray-500">Tanggal Mulai</p>
                                                <p class="font-medium text-gray-900">{{ $rental->tanggal_mulai->format('d/m/Y') }}</p>
                                            </div>
                                            <div>
                                                <p class="text-gray-500">Total Harga</p>
                                                <p class="font-bold text-green-600">Rp {{ number_format($rental->harga, 0, ',', '.') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-3 lg:ml-4">
                                @if($rental->status === 'menunggu_pembayaran' && $rental->bukti_pembayaran)
                                    <button data-action="confirm-payment" data-rental-id="{{ $rental->id }}"
                                            class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition duration-200 text-sm font-medium">
                                        Konfirmasi Bayar
                                    </button>
                                @endif

                                @if($rental->status === 'aktif')
                                    <button data-action="confirm-return" data-rental-id="{{ $rental->id }}"
                                            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-200 text-sm font-medium">
                                        Konfirmasi Kembali
                                    </button>
                                @endif

                                <button data-action="view-details" data-rental-id="{{ $rental->id }}"
                                        class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition duration-200 text-sm font-medium">
                                    Detail
                                </button>

                                @if($rental->bukti_pembayaran)
                                    <button data-action="view-payment-proof" data-rental-id="{{ $rental->id }}"
                                            class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition duration-200 text-sm font-medium">
                                        Lihat Bukti
                                    </button>
                                @endif
                            </div>
                        </div>

                        <!-- Payment Info if exists -->
                        @if($rental->bukti_pembayaran)
                        <div class="mt-4 p-3 bg-blue-50 rounded-lg border-l-4 border-blue-400">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <span class="text-sm font-medium text-blue-800">
                                    Bukti pembayaran tersedia - {{ $rental->status === 'menunggu_pembayaran' ? 'Menunggu konfirmasi' : 'Sudah dikonfirmasi' }}
                                </span>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $rentals->links() }}
            </div>
        @else
            <div class="bg-white rounded-lg shadow-sm p-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum Ada Penyewaan</h3>
                <p class="text-gray-500">Belum ada transaksi penyewaan yang perlu dikelola.</p>
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
<div id="rentalDetailsModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full max-h-screen overflow-y-auto">
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
            .then(response => response.text())
            .then(html => {
                document.getElementById('paymentProofContent').innerHTML = html;
            })
            .catch(error => {
                document.getElementById('paymentProofContent').innerHTML = '<div class="text-red-500 text-center">Gagal memuat bukti pembayaran</div>';
            });
    }

    function viewRentalDetails(rentalId) {
        document.getElementById('rentalDetailsModal').classList.remove('hidden');
        document.getElementById('rentalDetailsContent').innerHTML = '<div class="text-center py-4">Loading...</div>';
        
        // Load rental details via AJAX
        fetch(`/admin/rental/${rentalId}/details`)
            .then(response => response.text())
            .then(html => {
                document.getElementById('rentalDetailsContent').innerHTML = html;
            })
            .catch(error => {
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
</script>
@endpush