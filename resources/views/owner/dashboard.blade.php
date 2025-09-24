@extends('layouts.app')

@section('title', 'Dashboard Pemilik - RideOn')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h1 class="text-2xl font-bold text-gray-900">Dashboard Pemilik</h1>
        <p class="text-gray-600 mt-1">Kelola motor dan lihat statistik penyewaan Anda</p>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-lg shadow-md p-4 flex flex-col items-center">
            <div class="p-2 bg-blue-100 rounded-full">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
            </div>
            <p class="text-xs font-medium text-gray-600 mt-2">Total Motor</p>
            <p class="text-lg font-semibold text-gray-900">{{ $totalMotors }}</p>
        </div>

        <div class="bg-white rounded-lg shadow-md p-4 flex flex-col items-center">
            <div class="p-2 bg-green-100 rounded-full">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <p class="text-xs font-medium text-gray-600 mt-2">Motor Tersedia</p>
            <p class="text-lg font-semibold text-gray-900">{{ $activeMotors }}</p>
        </div>

        <div class="bg-white rounded-lg shadow-md p-4 flex flex-col items-center">
            <div class="p-2 bg-yellow-100 rounded-full">
                <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <p class="text-xs font-medium text-gray-600 mt-2">Motor Disewa</p>
            <p class="text-lg font-semibold text-gray-900">{{ $rentedMotors }}</p>
        </div>

        <div class="bg-white rounded-lg shadow-md p-4 flex flex-col items-center">
            <div class="p-2 bg-orange-100 rounded-full">
                <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
                <p class="text-xs font-medium text-gray-600 mt-2">Perawatan</p>
                <p class="text-lg font-semibold text-gray-900">{{ $maintenanceMotors }}</p>
            </div>
        </div>
    </div>

    <!-- Action Buttons Section -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Aksi Cepat</h3>
        <div class="flex flex-col sm:flex-row gap-4">
            <a href="{{ route('owner.create-motor') }}" class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-0.5">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Daftarkan Motor Baru
            </a>
            <a href="{{ route('owner.revenue') }}" class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition-all duration-300 transform hover:-translate-y-0.5">
                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                Lihat Laporan Pendapatan
            </a>
        </div>
    </div>

    <!-- Motors List -->
    <div class="bg-white rounded-lg shadow-sm">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Daftar Motor Anda</h2>
        </div>
        
        @if($motors->count() > 0)
            <div class="table-container">
                <table class="min-w-full divide-y divide-gray-200 relative">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Motor</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipe</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Plat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tarif Harian</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($motors as $motor)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    @if($motor->photo)
                                        <img class="h-10 w-10 rounded-lg object-cover" src="{{ asset('storage/' . $motor->photo) }}" alt="{{ $motor->merk }}">
                                    @else
                                        <div class="h-10 w-10 rounded-lg bg-gray-200 flex items-center justify-center">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $motor->merk }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                    {{ $motor->tipe_cc }}cc
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $motor->no_plat }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'tersedia' => 'bg-green-100 text-green-800',
                                        'disewa' => 'bg-red-100 text-red-800',
                                        'perawatan' => 'bg-gray-100 text-gray-800'
                                    ];
                                    $statusLabels = [
                                        'pending' => 'Menunggu Verifikasi',
                                        'tersedia' => 'Tersedia',
                                        'disewa' => 'Sedang Disewa',
                                        'perawatan' => 'Perawatan'
                                    ];
                                @endphp
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $statusColors[$motor->status] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ $statusLabels[$motor->status] ?? ucfirst($motor->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                @if($motor->tarifRental)
                                    Rp {{ number_format($motor->tarifRental->tarif_harian, 0, ',', '.') }}
                                @else
                                    <span class="text-gray-400">Belum ditetapkan</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                <div class="relative inline-block text-left">
                                    <button data-action="toggle-dropdown" data-motor-id="{{ $motor->id }}" class="inline-flex items-center justify-center w-8 h-8 rounded-full hover:bg-gray-100 focus:outline-none focus:bg-gray-100" id="menu-button-{{ $motor->id }}" aria-expanded="false" aria-haspopup="true">
                                        <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 6a2 2 0 110-4 2 2 0 010 4zM10 12a2 2 0 110-4 2 2 0 010 4zM10 18a2 2 0 110-4 2 2 0 010 4z"></path>
                                        </svg>
                                    </button>

                                    <div id="dropdown-{{ $motor->id }}" class="hidden absolute right-0 z-50 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none origin-top-right" role="menu" style="position: absolute !important;">
                                        <div class="py-1" role="none">
                                            <!-- View -->
                                            <a href="{{ route('owner.show-motor', $motor->id) }}" class="group flex items-center px-4 py-2 text-sm text-gray-900 hover:bg-gray-100" role="menuitem">
                                                <svg class="w-4 h-4 mr-3 text-gray-600 group-hover:text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                                Lihat Detail
                                            </a>

                                            <!-- Edit -->
                                            <a href="{{ route('owner.edit-motor', $motor->id) }}" class="group flex items-center px-4 py-2 text-sm text-gray-900 hover:bg-gray-100" role="menuitem">
                                                <svg class="w-4 h-4 mr-3 text-gray-600 group-hover:text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                                Edit Motor
                                            </a>

                                            @if($motor->status !== 'disewa')
                                                <!-- Maintenance Toggle -->
                                                <form action="{{ route('owner.set-maintenance', $motor->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="group flex items-center w-full px-4 py-2 text-sm text-gray-900 hover:bg-gray-100" role="menuitem">
                                                        <svg class="w-4 h-4 mr-3 text-gray-600 group-hover:text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        </svg>
                                                        {{ $motor->status === 'perawatan' ? 'Set Tersedia' : 'Set Perawatan' }}
                                                    </button>
                                                </form>

                                                <!-- Delete -->
                                                <button data-action="confirm-delete" data-motor-id="{{ $motor->id }}" data-motor-merk="{{ $motor->merk }}" class="group flex items-center w-full px-4 py-2 text-sm text-red-700 hover:bg-red-50 font-medium" role="menuitem">
                                                    <svg class="w-4 h-4 mr-3 text-red-500 group-hover:text-red-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                    Hapus Motor
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="px-6 py-8 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada motor terdaftar</h3>
                <p class="mt-1 text-sm text-gray-500">Mulai dengan mendaftarkan motor pertama Anda.</p>
                <div class="mt-6">
                    <a href="{{ route('owner.create-motor') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md transition duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Daftarkan Motor
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 z-[9999] hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen px-4 py-6">
        <div class="fixed inset-0 bg-black bg-opacity-50 modal-backdrop" aria-hidden="true" onclick="closeDeleteModal()"></div>
        
        <div class="relative bg-white rounded-xl shadow-2xl modal-content max-w-md w-full mx-auto z-10">
            <div class="p-6">
                <div class="flex items-start">
                    <div class="flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                        <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                    </div>
                    <div class="ml-4 flex-1">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2" id="modal-title">
                            Konfirmasi Hapus Motor
                        </h3>
                        <p class="text-sm text-gray-600" id="deleteMessage">
                            Apakah Anda yakin ingin menghapus motor ini? Tindakan ini tidak dapat dibatalkan.
                        </p>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-6 py-4 flex flex-col-reverse sm:flex-row sm:justify-end sm:space-x-3 space-y-3 space-y-reverse sm:space-y-0">
                <button data-action="close-delete-modal" type="button" class="w-full sm:w-auto px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                    Batal
                </button>
                <form id="deleteForm" method="POST" class="w-full sm:w-auto">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                        Hapus Motor
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Event delegation for action buttons
document.addEventListener('click', function(e) {
    // Find the closest element with data-action (handles clicks on child elements like SVG)
    const actionElement = e.target.closest('[data-action]');
    
    if (actionElement && actionElement.dataset.action) {
        const action = actionElement.dataset.action;
        
        switch(action) {
            case 'toggle-dropdown':
                const motorId = actionElement.dataset.motorId;
                toggleDropdown(motorId);
                break;
            case 'confirm-delete':
                const deleteMotorId = actionElement.dataset.motorId;
                const motorMerk = actionElement.dataset.motorMerk;
                confirmDelete(deleteMotorId, motorMerk);
                break;
            case 'close-delete-modal':
                closeDeleteModal();
                break;
        }
    }
});

function toggleDropdown(motorId) {
    // Close all other dropdowns
    document.querySelectorAll('[id^="dropdown-"]').forEach(function(dropdown) {
        if (dropdown.id !== 'dropdown-' + motorId) {
            dropdown.classList.add('hidden');
        }
    });
    
    // Toggle current dropdown
    const dropdown = document.getElementById('dropdown-' + motorId);
    dropdown.classList.toggle('hidden');
}

function confirmDelete(motorId, motorMerk) {
    const modal = document.getElementById('deleteModal');
    const form = document.getElementById('deleteForm');
    const message = document.getElementById('deleteMessage');
    
    // Update form action
    form.action = '/owner/motor/' + motorId;
    
    // Update message
    message.textContent = 'Apakah Anda yakin ingin menghapus motor ' + motorMerk + '? Tindakan ini tidak dapat dibatalkan.';
    
    // Show modal
    modal.classList.remove('hidden');
    
    // Close dropdown
    const dropdown = document.getElementById('dropdown-' + motorId);
    if (dropdown) {
        dropdown.classList.add('hidden');
    }
}

function closeDeleteModal() {
    const modal = document.getElementById('deleteModal');
    modal.classList.add('hidden');
}

// Close dropdown when clicking outside
document.addEventListener('click', function(event) {
    if (!event.target.closest('[id^="menu-button-"]') && !event.target.closest('[id^="dropdown-"]')) {
        document.querySelectorAll('[id^="dropdown-"]').forEach(function(dropdown) {
            dropdown.classList.add('hidden');
        });
    }
});

// Close modal when clicking backdrop or pressing Escape
document.getElementById('deleteModal').addEventListener('click', function(event) {
    if (event.target === this || event.target.classList.contains('modal-backdrop')) {
        closeDeleteModal();
    }
});

// Close modal with Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        const modal = document.getElementById('deleteModal');
        if (!modal.classList.contains('hidden')) {
            closeDeleteModal();
        }
    }
});
</script>
@endsection
