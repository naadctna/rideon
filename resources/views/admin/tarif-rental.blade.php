@extends('layouts.app')

@section('title', 'Kelola Tarif Rental - Admin RideOn')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Kelola Tarif Rental</h1>
                <p class="text-gray-600 mt-1">Atur harga sewa harian, mingguan, dan bulanan untuk setiap motor</p>
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
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Motor Tersedia</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalMotors }}</p>
                </div>
                <div class="p-3 bg-blue-100 rounded-full">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="9" stroke-width="2"></circle>
                        <circle cx="12" cy="12" r="3" stroke-width="2"></circle>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v6m0 6v6m9-9h-6m-6 0H3"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Motor dengan Tarif</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $motorsWithTarif }}</p>
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
                    <p class="text-sm font-medium text-gray-600">Belum Ada Tarif</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $totalMotors - $motorsWithTarif }}</p>
                </div>
                <div class="p-3 bg-orange-100 rounded-full">
                    <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Motors List -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Daftar Motor</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Motor</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pemilik</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tarif Harian</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tarif Mingguan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tarif Bulanan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($motors as $motor)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-16 w-16">
                                    @if($motor->photo)
                                    <img class="h-16 w-16 rounded-lg object-cover border border-gray-200" src="{{ asset('storage/' . $motor->photo) }}" alt="{{ $motor->merek }}">
                                    @else
                                    <div class="h-16 w-16 rounded-lg bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center border border-gray-300">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    @endif
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-semibold text-gray-900">{{ $motor->merk ?? 'N/A' }} {{ $motor->model ?? '' }}</div>
                                    <div class="text-sm text-gray-500">
                                        @if($motor->tipe_cc)
                                        {{ $motor->tipe_cc }} cc
                                        @else
                                        N/A
                                        @endif
                                        @if($motor->tahun)
                                        • Tahun {{ $motor->tahun }}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $motor->pemilik->name }}</div>
                            <div class="text-sm text-gray-500">{{ $motor->pemilik->email }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">
                                @if($motor->tarifRental)
                                Rp {{ number_format($motor->tarifRental->tarif_harian, 0, ',', '.') }}
                                @else
                                <span class="text-gray-400">-</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">
                                @if($motor->tarifRental)
                                Rp {{ number_format($motor->tarifRental->tarif_mingguan, 0, ',', '.') }}
                                @else
                                <span class="text-gray-400">-</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">
                                @if($motor->tarifRental)
                                Rp {{ number_format($motor->tarifRental->tarif_bulanan, 0, ',', '.') }}
                                @else
                                <span class="text-gray-400">-</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <button onclick="editTarif({{ $motor->id }}, '{{ $motor->merk }} {{ $motor->tipe }}', {{ $motor->tarifRental ? $motor->tarifRental->tarif_harian : 0 }}, {{ $motor->tarifRental ? $motor->tarifRental->tarif_mingguan : 0 }}, {{ $motor->tarifRental ? $motor->tarifRental->tarif_bulanan : 0 }})" class="text-blue-600 hover:text-blue-900">
                                Atur Tarif
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            Tidak ada motor yang tersedia
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $motors->links() }}
        </div>
    </div>
</div>

<!-- Edit Tarif Modal -->
<div id="editTarifModal" class="hidden fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm z-50 flex items-center justify-center p-4">
    <div class="relative bg-white rounded-xl shadow-2xl w-full max-w-lg transform transition-all">
        <!-- Header -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-500 px-6 py-5 rounded-t-xl">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-white/20 backdrop-blur-sm rounded-full flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-white">Atur Tarif Rental</h3>
                        <p class="text-white/80 text-sm mt-0.5" id="motorName"></p>
                    </div>
                </div>
                <button type="button" onclick="closeEditTarifModal()" class="text-white/80 hover:text-white transition-all duration-200 hover:rotate-90">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
        
        <!-- Form Content -->
        <form id="tarifForm" class="p-6">
            @csrf
            <input type="hidden" id="motorId" name="motor_id">
            
            <div class="space-y-5">
                <!-- Tarif Harian -->
                <div>
                    <label for="tarif_harian" class="block text-sm font-semibold text-gray-700 mb-2">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1.5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Tarif Harian
                        </span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <span class="text-gray-500 font-medium">Rp</span>
                        </div>
                        <input type="number" id="tarif_harian" name="tarif_harian" 
                               class="block w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all" 
                               placeholder="50.000" required>
                    </div>
                </div>

                <!-- Tarif Mingguan -->
                <div>
                    <label for="tarif_mingguan" class="block text-sm font-semibold text-gray-700 mb-2">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1.5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Tarif Mingguan
                        </span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <span class="text-gray-500 font-medium">Rp</span>
                        </div>
                        <input type="number" id="tarif_mingguan" name="tarif_mingguan" 
                               class="block w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all" 
                               placeholder="300.000" required>
                    </div>
                </div>

                <!-- Tarif Bulanan -->
                <div>
                    <label for="tarif_bulanan" class="block text-sm font-semibold text-gray-700 mb-2">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1.5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            Tarif Bulanan
                        </span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <span class="text-gray-500 font-medium">Rp</span>
                        </div>
                        <input type="number" id="tarif_bulanan" name="tarif_bulanan" 
                               class="block w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all" 
                               placeholder="1.000.000" required>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-3 mt-6 pt-6 border-t border-gray-200">
                <button type="button" onclick="closeEditTarifModal()" 
                        class="flex-1 px-5 py-3 bg-white text-gray-700 border border-gray-300 rounded-lg hover:bg-gray-50 hover:border-gray-400 transition-all font-medium">
                    Batal
                </button>
                <button type="submit" 
                        class="flex-1 px-5 py-3 bg-gradient-to-r from-blue-600 to-blue-500 text-white rounded-lg hover:from-blue-700 hover:to-blue-600 transition-all shadow-md hover:shadow-lg font-medium">
                    Simpan Tarif
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function editTarif(motorId, motorName, tarifHarian, tarifMingguan, tarifBulanan) {
    document.getElementById('motorId').value = motorId;
    document.getElementById('motorName').textContent = motorName;
    document.getElementById('tarif_harian').value = tarifHarian;
    document.getElementById('tarif_mingguan').value = tarifMingguan;
    document.getElementById('tarif_bulanan').value = tarifBulanan;
    document.getElementById('editTarifModal').classList.remove('hidden');
}

function closeEditTarifModal() {
    document.getElementById('editTarifModal').classList.add('hidden');
}

document.getElementById('tarifForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const motorId = document.getElementById('motorId').value;
    const formData = new FormData(this);
    
    fetch(`/admin/tarif-rental/${motorId}/update`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Berhasil', data.message, 'success');
            closeEditTarifModal();
            setTimeout(() => {
                location.reload();
            }, 1500);
        } else {
            showNotification('Gagal', data.message || 'Terjadi kesalahan saat menyimpan tarif', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Error', 'Terjadi kesalahan saat menyimpan tarif', 'error');
    });
});

// Close modal when clicking outside
document.getElementById('editTarifModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeEditTarifModal();
    }
});
</script>

@endsection
