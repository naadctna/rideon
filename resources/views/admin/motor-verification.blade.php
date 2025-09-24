@extends('layouts.app')

@section('title', 'Verifikasi Motor - Admin')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm p-6 border-l-4 border-yellow-500">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Verifikasi Motor</h1>
                <p class="text-gray-600 mt-1">Kelola dan verifikasi motor yang didaftarkan pemilik</p>
            </div>
            <div class="flex items-center space-x-2">
                <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-medium">
                    {{ $motors->count() }} Motor Pending
                </span>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between space-y-4 sm:space-y-0">
            <div class="flex items-center space-x-4">
                <div class="relative">
                    <input type="text" id="searchInput" placeholder="Cari motor..." 
                           class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>
                
                <select id="statusFilter" class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-yellow-500">
                    <option value="">Semua Status</option>
                    <option value="pending" selected>Pending</option>
                    <option value="verified">Diverifikasi</option>
                    <option value="rejected">Ditolak</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Motors Grid -->
    <div id="motorsContainer">
        @if($motors->count() > 0)
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                @foreach($motors as $motor)
                <div class="bg-white rounded-lg shadow-md overflow-hidden border-l-4 border-yellow-500 motor-card" 
                     data-search="{{ strtolower($motor->merk . ' ' . $motor->no_plat . ' ' . $motor->pemilik->name) }}"
                     data-status="{{ $motor->status_verifikasi }}">
                    
                    <!-- Motor Image -->
                    <div class="h-48 bg-gray-100 relative">
                        @if($motor->foto_motor)
                            <img src="{{ asset('storage/' . $motor->foto_motor) }}" 
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
                            <span class="inline-flex px-3 py-1 text-sm font-semibold rounded-full {{ $statusColors[$motor->status_verifikasi] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ ucfirst($motor->status_verifikasi) }}
                            </span>
                        </div>
                    </div>

                    <!-- Motor Details -->
                    <div class="p-6">
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">{{ $motor->merk }}</h3>
                                <p class="text-gray-600">{{ $motor->tipe }} • {{ $motor->no_plat }}</p>
                                <p class="text-sm text-gray-500 mt-1">{{ $motor->tipe_cc }}cc • {{ $motor->tahun }}</p>
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
                        @if($motor->status_verifikasi === 'pending')
                        <div class="flex space-x-3 pt-4 border-t border-gray-200">
                            <button class="verify-motor-btn flex-1 bg-green-600 text-white py-2 px-4 rounded-lg hover:bg-green-700 transition duration-200 font-medium flex items-center justify-center" 
                                    data-motor-id="{{ $motor->id }}" data-action="verified">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Verifikasi
                            </button>
                            
                            <button class="reject-motor-btn flex-1 bg-red-600 text-white py-2 px-4 rounded-lg hover:bg-red-700 transition duration-200 font-medium flex items-center justify-center" 
                                    data-motor-id="{{ $motor->id }}">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Tolak
                            </button>
                        </div>
                        @endif

                        <!-- View Details Button -->
                        <div class="mt-3">
                            <button class="view-motor-details-btn w-full bg-gray-100 text-gray-700 py-2 px-4 rounded-lg hover:bg-gray-200 transition duration-200 font-medium" 
                                    data-motor-id="{{ $motor->id }}">
                                Lihat Detail Lengkap
                            </button>
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
            <div class="bg-white rounded-lg shadow-sm p-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak Ada Motor Pending</h3>
                <p class="text-gray-500">Semua motor telah diverifikasi atau belum ada yang didaftarkan.</p>
            </div>
        @endif
    </div>
</div>

<!-- Rejection Modal -->
<div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
            <div class="p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Tolak Verifikasi Motor</h3>
                <form id="rejectForm" onsubmit="submitReject(event)">
                    <input type="hidden" id="rejectMotorId">
                    <div class="mb-4">
                        <label for="rejectReason" class="block text-sm font-medium text-gray-700 mb-2">
                            Alasan Penolakan:
                        </label>
                        <textarea id="rejectReason" rows="4" required
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
    // Search and filter functionality
    document.getElementById('searchInput').addEventListener('input', function() {
        filterMotors();
    });

    document.getElementById('statusFilter').addEventListener('change', function() {
        filterMotors();
    });

    // Event listeners for motor action buttons
    document.addEventListener('DOMContentLoaded', function() {
        // Verify motor buttons
        document.querySelectorAll('.verify-motor-btn').forEach(button => {
            button.addEventListener('click', function() {
                const motorId = this.getAttribute('data-motor-id');
                const status = this.getAttribute('data-action');
                verifyMotor(motorId, status);
            });
        });

        // Reject motor buttons
        document.querySelectorAll('.reject-motor-btn').forEach(button => {
            button.addEventListener('click', function() {
                const motorId = this.getAttribute('data-motor-id');
                openRejectModal(motorId);
            });
        });

        // View motor details buttons
        document.querySelectorAll('.view-motor-details-btn').forEach(button => {
            button.addEventListener('click', function() {
                const motorId = this.getAttribute('data-motor-id');
                viewMotorDetails(motorId);
            });
        });
    });

    function filterMotors() {
        const searchTerm = document.getElementById('searchInput').value.toLowerCase();
        const statusFilter = document.getElementById('statusFilter').value;
        const cards = document.querySelectorAll('.motor-card');

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

    // Verification functions
    function verifyMotor(motorId, status) {
        if (confirm('Apakah Anda yakin ingin memverifikasi motor ini?')) {
            fetch(`/admin/verify-motor/${motorId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    status: status
                })
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
                alert('Terjadi kesalahan saat memverifikasi motor');
            });
        }
    }

    function openRejectModal(motorId) {
        document.getElementById('rejectMotorId').value = motorId;
        document.getElementById('rejectModal').classList.remove('hidden');
    }

    function closeRejectModal() {
        document.getElementById('rejectModal').classList.add('hidden');
        document.getElementById('rejectForm').reset();
    }

    function submitReject(event) {
        event.preventDefault();
        const motorId = document.getElementById('rejectMotorId').value;
        const reason = document.getElementById('rejectReason').value;

        fetch(`/admin/verify-motor/${motorId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                status: 'rejected',
                reason: reason
            })
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
            alert('Terjadi kesalahan saat menolak motor');
        });
    }

    function viewMotorDetails(motorId) {
        // This would load detailed motor information
        document.getElementById('motorDetailsModal').classList.remove('hidden');
        document.getElementById('motorDetailsContent').innerHTML = '<div class="text-center py-4">Loading...</div>';
        
        // You could implement an AJAX call here to load full details
    }

    function closeMotorDetailsModal() {
        document.getElementById('motorDetailsModal').classList.add('hidden');
    }

    // Close modals when clicking outside
    document.getElementById('rejectModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeRejectModal();
        }
    });

    document.getElementById('motorDetailsModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeMotorDetailsModal();
        }
    });
</script>
@endpush