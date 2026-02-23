@extends('layouts.app')

@section('title', 'Verifikasi Motor - Admin')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Verifikasi Motor</h1>
                <p class="text-gray-600 mt-1">Kelola dan verifikasi motor yang didaftarkan pemilik</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-700 transition duration-200 font-medium inline-flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
        </div>
    </div>

    <!-- Stats Summary -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total Motors -->
        <div class="bg-white rounded-lg shadow-md p-4 flex flex-col items-center">
            <div class="p-2 bg-blue-100 rounded-full">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
            </div>
            <p class="text-xs font-medium text-gray-600 mt-2">Total Motor</p>
            <p class="text-lg font-semibold text-gray-900">{{ $totalMotors }}</p>
        </div>

        <!-- Pending Verification -->
        <div class="bg-white rounded-lg shadow-md p-4 flex flex-col items-center">
            <div class="p-2 bg-yellow-100 rounded-full">
                <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <p class="text-xs font-medium text-gray-600 mt-2">Pending Verifikasi</p>
            <p class="text-lg font-semibold text-gray-900">{{ $pendingVerification }}</p>
        </div>

        <!-- Verified Motors -->
        <div class="bg-white rounded-lg shadow-md p-4 flex flex-col items-center">
            <div class="p-2 bg-green-100 rounded-full">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <p class="text-xs font-medium text-gray-600 mt-2">Terverifikasi</p>
            <p class="text-lg font-semibold text-gray-900">{{ $verifiedMotors }}</p>
        </div>

        <!-- Rejected Motors -->
        <div class="bg-white rounded-lg shadow-md p-4 flex flex-col items-center">
            <div class="p-2 bg-red-100 rounded-full">
                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <p class="text-xs font-medium text-gray-600 mt-2">Ditolak</p>
            <p class="text-lg font-semibold text-gray-900">{{ $rejectedMotors }}</p>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow-sm">
        <div class="px-6 py-5 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Filter Motor</h2>
        </div>
        <div class="p-6">
            <form method="GET" action="{{ route('admin.motor-verification') }}" class="flex items-center space-x-4">
                <div class="relative">
                    <input type="text" name="search" id="searchInput" placeholder="Cari motor..." 
                           value="{{ request('search') }}"
                           class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>
                
                <select name="status" id="statusFilter" class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-yellow-500" onchange="this.form.submit()">
                    <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>Semua Status</option>
                    <option value="pending" {{ (!request('status') || request('status') == 'pending') ? 'selected' : '' }}>Pending</option>
                    <option value="tersedia" {{ request('status') == 'tersedia' ? 'selected' : '' }}>Diverifikasi</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                </select>
                
                <div class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-medium">
                    {{ $motors->total() }} Motor 
                    @if(request('status') == 'pending' || !request('status'))
                        Pending
                    @elseif(request('status') == 'tersedia')
                        Terverifikasi
                    @elseif(request('status') == 'rejected')
                        Ditolak
                    @else
                        Total
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Motors Grid -->
    <div id="motorsContainer">
        @if($motors->count() > 0)
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                @foreach($motors as $motor)
                <div class="bg-white rounded-lg shadow-sm overflow-hidden motor-card" 
                     data-search="{{ strtolower($motor->merk . ' ' . $motor->no_plat . ' ' . $motor->pemilik->name) }}"
                     data-status="{{ $motor->status }}">
                    
                    <!-- Motor Image -->
                    <div class="h-48 bg-gray-100 relative">
                        @if($motor->photo)
                            <img src="{{ asset('storage/' . $motor->photo) }}" 
                                 alt="{{ $motor->merk }}" 
                                 class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gray-200">
                                <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        @endif
                        
                        <!-- Status Badge -->
                        <div class="absolute top-4 right-4">
                            @php
                                $statusColors = [
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'verified' => 'bg-green-100 text-green-800',
                                    'rejected' => 'bg-red-100 text-red-800'
                                ];
                            @endphp
                            <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full {{ $statusColors[$motor->status] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ ucfirst($motor->status) }}
                            </span>
                        </div>
                    </div>

                    <!-- Motor Details -->
                    <div class="p-6">
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">{{ $motor->merk }}</h3>
                                <p class="text-gray-600">{{ $motor->tipe_cc }}cc • {{ $motor->no_plat }}</p>
                                <p class="text-sm text-gray-500 mt-1">Pemilik: {{ $motor->pemilik->name }}</p>
                            </div>
                        </div>

                        <!-- Owner Info -->
                        <div class="mb-4 p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">{{ $motor->pemilik->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $motor->pemilik->email }}</p>
                                    <p class="text-xs text-gray-400">Terdaftar {{ $motor->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Motor Description -->
                        @if($motor->deskripsi)
                        <div class="mb-4">
                            <p class="text-sm text-gray-700">{{ Str::limit($motor->deskripsi, 100) }}</p>
                        </div>
                        @endif

                        <!-- Pricing Info -->
                        @if($motor->tarifs && $motor->tarifs->count() > 0)
                        <div class="mb-4">
                            <h4 class="font-medium text-gray-900 mb-2">Tarif Rental:</h4>
                            <div class="grid grid-cols-2 gap-2 text-sm">
                                @foreach($motor->tarifs->take(2) as $tarif)
                                <div class="bg-blue-50 p-2 rounded">
                                    <span class="font-medium">{{ $tarif->durasi_hari }} hari:</span>
                                    <span class="text-blue-600">Rp {{ number_format($tarif->harga_per_hari, 0, ',', '.') }}/hari</span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <!-- Action Buttons -->
                        @if($motor->status === 'pending')
                        <div class="flex space-x-3 pt-4 border-t border-gray-200">
                            <!-- Approve Button -->
                            <button type="button" 
                                    onclick="openApproveModal({{ $motor->id }}, '{{ addslashes($motor->merk) }}')"
                                    class="flex-1 bg-gradient-to-r from-green-600 to-green-700 text-white py-2 px-4 rounded-lg hover:from-green-700 hover:to-green-800 transition duration-200 font-medium flex items-center justify-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Approve
                            </button>
                            
                            <!-- Reject Button -->
                            <button type="button" 
                                    onclick="openRejectModal({{ $motor->id }}, '{{ addslashes($motor->merk) }}')"
                                    class="flex-1 bg-gradient-to-r from-red-600 to-red-700 text-white py-2 px-4 rounded-lg hover:from-red-700 hover:to-red-800 transition duration-200 font-medium flex items-center justify-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Reject
                            </button>
                        </div>
                        @elseif($motor->status === 'tersedia')
                        <div class="pt-4 border-t border-gray-200">
                            <span class="inline-block bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">
                                ✅ Sudah Diverifikasi
                            </span>
                        </div>
                        @elseif($motor->status === 'rejected')
                        <div class="pt-4 border-t border-gray-200">
                            <span class="inline-block bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-medium">
                                ❌ Ditolak
                            </span>
                        </div>
                        @endif

                        <!-- View Details Button -->
                        <div class="mt-3">
                            <a href="{{ route('admin.motor-verification.detail', $motor->id) }}"
                               class="block w-full bg-gray-100 text-gray-700 py-2 px-4 rounded-lg hover:bg-gray-200 transition duration-200 font-medium text-center">
                                Lihat Detail Lengkap
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $motors->links() }}
            </div>
        @else
            <div class="bg-white rounded-lg shadow-sm">
                <div class="px-6 py-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak Ada Motor Pending</h3>
                    <p class="mt-1 text-sm text-gray-500">Semua motor telah diverifikasi atau belum ada yang didaftarkan.</p>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Approve Modal -->
<div id="approveModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
            <div class="p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Approve Motor - <span id="approveMotorName"></span></h3>
                <form action="" method="POST" id="approveForm">
                    @csrf
                    <input type="hidden" name="action" value="approve">
                    <div class="mb-4">
                        <label for="tarif_harian" class="block text-sm font-medium text-gray-700 mb-2">
                            Tarif Harian (Rp):
                        </label>
                        <input type="number" name="tarif_harian" id="tarif_harian" required min="10000" step="1000"
                               value="50000"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:border-transparent"
                               placeholder="50000">
                    </div>
                    <div class="mb-4">
                        <label for="tarif_mingguan" class="block text-sm font-medium text-gray-700 mb-2">
                            Tarif Mingguan (Rp):
                        </label>
                        <input type="number" name="tarif_mingguan" id="tarif_mingguan" required min="50000" step="1000"
                               value="300000"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:border-transparent"
                               placeholder="300000">
                    </div>
                    <div class="mb-4">
                        <label for="tarif_bulanan" class="block text-sm font-medium text-gray-700 mb-2">
                            Tarif Bulanan (Rp):
                        </label>
                        <input type="number" name="tarif_bulanan" id="tarif_bulanan" required min="100000" step="1000"
                               value="1000000"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-500 focus:border-transparent"
                               placeholder="1000000">
                    </div>
                    <div class="flex space-x-3">
                        <button type="button" onclick="closeApproveModal()"
                                class="flex-1 bg-gray-300 text-gray-700 py-2 px-4 rounded-lg hover:bg-gray-400 transition duration-200">
                            Batal
                        </button>
                        <button type="submit"
                                class="flex-1 bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700 transition duration-200">
                            Approve Motor
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Rejection Modal -->
<div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
            <div class="p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Tolak Motor - <span id="rejectMotorName"></span></h3>
                <form action="" method="POST" id="rejectForm">
                    @csrf
                    <input type="hidden" name="action" value="reject">
                    <div class="mb-4">
                        <label for="rejection_reason" class="block text-sm font-medium text-gray-700 mb-2">
                            Alasan Penolakan:
                        </label>
                        <textarea name="rejection_reason" id="rejection_reason" rows="4" required
                                  class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-red-500 focus:border-transparent"
                                  placeholder="Jelaskan alasan penolakan verifikasi..."></textarea>
                    </div>
                    <div class="flex space-x-3">
                        <button type="button" onclick="closeRejectModal()"
                                class="flex-1 bg-gray-300 text-gray-700 py-2 px-4 rounded-lg hover:bg-gray-400 transition duration-200">
                            Batal
                        </button>
                        <button type="submit"
                                class="flex-1 bg-red-600 text-white py-2 px-4 rounded-lg hover:bg-red-700 transition duration-200">
                            Tolak Motor
                        </button>
                    </div>
                </form>
            </div>
        </div>
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

@endsection

@push('scripts')
<script>
console.log('🚀 Verifikasi Motor - JS Loaded');

// FUNGSI APPROVE MODAL
function openApproveModal(motorId, motorName) {
    console.log('✅ APPROVE CLICKED! ID:', motorId, 'Name:', motorName);
    const modal = document.getElementById('approveModal');
    const form = document.getElementById('approveForm');
    const nameSpan = document.getElementById('approveMotorName');
    
    if (!modal || !form || !nameSpan) {
        alert('Error: Modal elements tidak ditemukan!');
        console.error('Missing elements:', {modal, form, nameSpan});
        return;
    }
    
    nameSpan.textContent = motorName;
    form.action = `/admin/verify-motor/${motorId}`;
    modal.classList.remove('hidden');
    console.log('✅ Approve modal opened successfully');
}

function closeApproveModal() {
    const modal = document.getElementById('approveModal');
    const form = document.getElementById('approveForm');
    if (modal) modal.classList.add('hidden');
    if (form) form.reset();
}

// FUNGSI REJECT MODAL
function openRejectModal(motorId, motorName) {
    console.log('❌ REJECT CLICKED! ID:', motorId, 'Name:', motorName);
    const modal = document.getElementById('rejectModal');
    const form = document.getElementById('rejectForm');
    const nameSpan = document.getElementById('rejectMotorName');
    
    if (!modal || !form || !nameSpan) {
        alert('Error: Modal elements tidak ditemukan!');
        console.error('Missing elements:', {modal, form, nameSpan});
        return;
    }
    
    nameSpan.textContent = motorName;
    form.action = `/admin/verify-motor/${motorId}`;
    modal.classList.remove('hidden');
    console.log('✅ Reject modal opened successfully');
}

function closeRejectModal() {
    const modal = document.getElementById('rejectModal');
    const form = document.getElementById('rejectForm');
    if (modal) modal.classList.add('hidden');
    if (form) form.reset();
}

// FUNGSI VIEW DETAILS
function viewMotorDetails(motorId) {
    console.log('👁️ DETAIL CLICKED! ID:', motorId);
    const modal = document.getElementById('motorDetailsModal');
    const content = document.getElementById('motorDetailsContent');
    
    if (!modal || !content) {
        alert('Error: Detail modal tidak ditemukan!');
        console.error('Missing elements:', {modal, content});
        return;
    }
    
    modal.classList.remove('hidden');
    content.innerHTML = '<div class="text-center py-8"><div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto"></div><p class="mt-4 text-gray-600">Loading...</p></div>';
    
    console.log('📡 Fetching from:', `/admin/motor/${motorId}/details`);
    
    fetch(`/admin/motor/${motorId}/details`)
        .then(response => {
            console.log('📥 Response status:', response.status);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            console.log('✅ Data received:', data);
            renderMotorDetails(data.motor);
        })
        .catch(error => {
            console.error('❌ Error loading details:', error);
            content.innerHTML = `
                <div class="text-center py-8 text-red-600">
                    <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-lg font-bold">Gagal Memuat Detail</p>
                    <p class="text-sm mt-2">${error.message}</p>
                </div>
            `;
        });
}

function closeMotorDetailsModal() {
    const modal = document.getElementById('motorDetailsModal');
    if (modal) modal.classList.add('hidden');
}

// RENDER MOTOR DETAILS
function renderMotorDetails(motor) {
    const content = document.getElementById('motorDetailsContent');
    if (!content) return;
    
    let tarifHtml = '';
    if (motor.tarifs) {
        tarifHtml = `
            <div class="bg-blue-50 p-4 rounded-lg">
                <h4 class="font-bold text-blue-900 mb-3">💰 Tarif Rental</h4>
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span>Harian:</span>
                        <span class="font-bold text-blue-600">Rp ${(motor.tarifs.tarif_harian || 0).toLocaleString('id-ID')}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Mingguan:</span>
                        <span class="font-bold text-blue-600">Rp ${(motor.tarifs.tarif_mingguan || 0).toLocaleString('id-ID')}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Bulanan:</span>
                        <span class="font-bold text-blue-600">Rp ${(motor.tarifs.tarif_bulanan || 0).toLocaleString('id-ID')}</span>
                    </div>
                </div>
            </div>
        `;
    } else {
        tarifHtml = '<div class="bg-yellow-50 p-4 rounded-lg text-center text-yellow-800 font-medium">⚠️ Tarif belum ditetapkan</div>';
    }

    const statusBadge = motor.status === 'pending' 
        ? '<span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-bold">⏳ Pending</span>'
        : motor.status === 'tersedia' 
        ? '<span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-bold">✅ Tersedia</span>'
        : '<span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-bold">❌ Ditolak</span>';

    let verificationButtons = '';
    if (motor.status === 'pending') {
        verificationButtons = `
            <div class="pt-4 border-t-2 border-gray-200">
                <h4 class="font-bold text-gray-900 mb-3">⚡ Aksi Verifikasi</h4>
                <div class="flex gap-3">
                    <button onclick="closeMotorDetailsModal(); openApproveModal(${motor.id}, '${motor.merk.replace(/'/g, "\\'")}')" 
                            class="flex-1 bg-green-600 text-white py-3 px-4 rounded-lg hover:bg-green-700 font-bold">
                        ✅ APPROVE
                    </button>
                    <button onclick="closeMotorDetailsModal(); openRejectModal(${motor.id}, '${motor.merk.replace(/'/g, "\\'")}')" 
                            class="flex-1 bg-red-600 text-white py-3 px-4 rounded-lg hover:bg-red-700 font-bold">
                        ❌ REJECT
                    </button>
                </div>
            </div>
        `;
    }

    content.innerHTML = `
        <div class="space-y-4">
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 p-4 rounded-lg border-l-4 border-blue-600">
                <h3 class="text-xl font-bold text-gray-900 mb-3">🏍️ ${motor.merk}</h3>
                <div class="grid grid-cols-2 gap-3 text-sm">
                    <div><span class="text-gray-600">Tipe CC:</span><p class="font-bold">${motor.tipe_cc}cc</p></div>
                    <div><span class="text-gray-600">No. Plat:</span><p class="font-bold font-mono">${motor.no_plat}</p></div>
                    <div><span class="text-gray-600">Status:</span><p>${statusBadge}</p></div>
                    <div><span class="text-gray-600">Terdaftar:</span><p class="font-bold">${motor.created_at}</p></div>
                </div>
            </div>

            <div class="bg-green-50 p-4 rounded-lg border-l-4 border-green-600">
                <h4 class="font-bold text-green-900 mb-3">👤 Pemilik Motor</h4>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-green-700">Nama:</span>
                        <span class="font-bold">${motor.pemilik.name}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-green-700">Email:</span>
                        <span class="font-bold">${motor.pemilik.email}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-green-700">Telepon:</span>
                        <span class="font-bold">${motor.pemilik.no_tlpn}</span>
                    </div>
                </div>
            </div>

            ${tarifHtml}

            <div class="bg-gray-50 p-4 rounded-lg">
                <h4 class="font-bold text-gray-700 mb-3">📷 Foto Motor</h4>
                ${motor.photo ? `
                    <img src="/storage/${motor.photo}" alt="${motor.merk}" class="w-full h-64 object-cover rounded-lg shadow-md">
                ` : `
                    <div class="w-full h-64 bg-gray-200 rounded-lg flex items-center justify-center">
                        <p class="text-gray-500">📷 Foto tidak tersedia</p>
                    </div>
                `}
                <p class="text-xs text-gray-600 mt-2">Dokumen: ${motor.dokumen_kepemilikan || 'Belum upload'}</p>
            </div>

            ${verificationButtons}
        </div>
    `;
}

// FILTER MOTORS
function filterMotors() {
    const searchTerm = document.getElementById('searchInput').value.toLowerCase();
    const statusFilter = document.getElementById('statusFilter').value;
    const cards = document.querySelectorAll('.motor-card');

    cards.forEach(card => {
        const searchData = card.getAttribute('data-search');
        const cardStatus = card.getAttribute('data-status');
        
        const matchesSearch = searchData.includes(searchTerm);
        const matchesStatus = !statusFilter || cardStatus === statusFilter;
        
        card.style.display = (matchesSearch && matchesStatus) ? 'block' : 'none';
    });
}

// INIT
document.addEventListener('DOMContentLoaded', function() {
    console.log('✅ DOM Ready');
    
    // Init search filter
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    
    if (searchInput) {
        searchInput.addEventListener('input', filterMotors);
        console.log('✅ Search initialized');
    }
    if (statusFilter) {
        statusFilter.addEventListener('change', filterMotors);
        console.log('✅ Filter initialized');
    }
    
    // Close modals on outside click
    ['approveModal', 'rejectModal', 'motorDetailsModal'].forEach(modalId => {
        const modal = document.getElementById(modalId);
        if (modal) {
            modal.addEventListener('click', function(e) {
                if (e.target === this) {
                    this.classList.add('hidden');
                }
            });
        }
    });
    
    console.log('✅ All systems ready!');
});
</script>
@endpush