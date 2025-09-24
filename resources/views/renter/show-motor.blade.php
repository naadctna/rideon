@extends('layouts.app')

@section('title', 'Detail Motor - RideOn')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Detail Motor</h1>
                <p class="text-gray-600 mt-1">{{ $motor->merk }} - {{ $motor->no_plat }}</p>
            </div>
            <a href="{{ route('renter.search') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-md transition duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali ke Pencarian
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Motor Photo -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                @if($motor->photo)
                    <img src="{{ asset('storage/' . $motor->photo) }}" alt="{{ $motor->merk }}" class="w-full h-96 object-cover">
                @else
                    <div class="w-full h-96 bg-gray-200 flex items-center justify-center">
                        <svg class="w-24 h-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                @endif
            </div>

            <!-- Motor Details -->
            <div class="bg-white rounded-lg shadow-sm p-6 mt-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Informasi Motor</h3>
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Merk Motor</dt>
                        <dd class="mt-1 text-sm text-gray-900 font-semibold">{{ $motor->merk }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Tipe CC</dt>
                        <dd class="mt-1">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                {{ $motor->tipe_cc }}cc
                            </span>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Nomor Plat</dt>
                        <dd class="mt-1 text-sm text-gray-900 font-semibold">{{ $motor->no_plat }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Status</dt>
                        <dd class="mt-1">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                Tersedia
                            </span>
                        </dd>
                    </div>
                </dl>
            </div>
        </div>

        <!-- Booking Form -->
        <div class="lg:col-span-1">
            @if($motor->tarifRental)
                <div class="bg-white rounded-lg shadow-sm p-6 sticky top-6" id="rent-form">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Sewa Motor Ini</h3>
                    
                    <!-- Pricing Info -->
                    <div class="mb-6 space-y-3">
                        <div class="flex justify-between items-center p-3 bg-blue-50 rounded-lg">
                            <span class="text-sm font-medium text-gray-700">Tarif Harian</span>
                            <span class="text-lg font-bold text-blue-600">Rp {{ number_format($motor->tarifRental->tarif_harian, 0, ',', '.') }}</span>
                        </div>
                        @if($motor->tarifRental->tarif_mingguan)
                        <div class="flex justify-between items-center p-3 bg-green-50 rounded-lg">
                            <span class="text-sm font-medium text-gray-700">Tarif Mingguan</span>
                            <span class="text-lg font-bold text-green-600">Rp {{ number_format($motor->tarifRental->tarif_mingguan, 0, ',', '.') }}</span>
                        </div>
                        @endif
                        @if($motor->tarifRental->tarif_bulanan)
                        <div class="flex justify-between items-center p-3 bg-purple-50 rounded-lg">
                            <span class="text-sm font-medium text-gray-700">Tarif Bulanan</span>
                            <span class="text-lg font-bold text-purple-600">Rp {{ number_format($motor->tarifRental->tarif_bulanan, 0, ',', '.') }}</span>
                        </div>
                        @endif
                    </div>

                    <!-- Booking Form -->
                    <form action="{{ route('renter.rent-motor', $motor->id) }}" method="POST" class="space-y-4">
                        @csrf
                        
                        <div>
                            <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700">Tanggal Mulai</label>
                            <input type="date" name="tanggal_mulai" id="tanggal_mulai" required 
                                   min="{{ date('Y-m-d') }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 text-base py-3 px-4">
                        </div>

                        <div>
                            <label for="tanggal_selesai" class="block text-sm font-medium text-gray-700">Tanggal Selesai</label>
                            <input type="date" name="tanggal_selesai" id="tanggal_selesai" required 
                                   min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 text-base py-3 px-4">
                        </div>

                        <div>
                            <label for="tipe_durasi" class="block text-sm font-medium text-gray-700">Tipe Durasi</label>
                            <select name="tipe_durasi" id="tipe_durasi" required 
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 text-base py-3 px-4">
                                <option value="">Pilih Durasi</option>
                                <option value="harian">Harian</option>
                                @if($motor->tarifRental->tarif_mingguan)
                                <option value="mingguan">Mingguan</option>
                                @endif
                                @if($motor->tarifRental->tarif_bulanan)
                                <option value="bulanan">Bulanan</option>
                                @endif
                            </select>
                        </div>

                        <!-- Metode Pembayaran -->
                        <div>
                            <label for="metode_pembayaran" class="block text-sm font-medium text-gray-700">Metode Pembayaran</label>
                            <select name="metode_pembayaran" id="metode_pembayaran" required 
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 text-base py-3 px-4">
                                <option value="">Pilih Metode Pembayaran</option>
                                <option value="cash">Bayar Tunai</option>
                                <option value="transfer">Transfer Bank</option>
                                <option value="ewallet">E-Wallet</option>
                            </select>
                        </div>

                        <!-- Estimasi Biaya -->
                        <div id="cost-estimate" class="hidden p-4 bg-gray-50 rounded-lg">
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-medium text-gray-700">Estimasi Total:</span>
                                <span id="total-cost" class="text-lg font-bold text-blue-600"></span>
                            </div>
                            <div class="text-xs text-gray-500 mt-1">
                                <span id="duration-info"></span>
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 rounded-md transition duration-200">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                            Selesaikan Pembayaran
                        </button>
                    </form>

                    <!-- Contact Info -->
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <h4 class="text-md font-semibold text-gray-900 mb-3">Pemilik Motor</h4>
                        <div class="space-y-2">
                            <p class="text-sm text-gray-600">{{ $motor->pemilik->name }}</p>
                            <p class="text-sm text-gray-600">{{ $motor->pemilik->no_tlpn }}</p>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="text-center">
                        <svg class="mx-auto h-12 w-12 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Tarif Belum Ditetapkan</h3>
                        <p class="mt-1 text-sm text-gray-500">Motor ini belum memiliki tarif rental yang ditetapkan oleh admin.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Tariff data for JavaScript -->
@if($motor->tarifRental)
<script type="application/json" id="tariffData">
{
    "harian": {{ $motor->tarifRental->tarif_harian ?? 0 }},
    "mingguan": {{ $motor->tarifRental->tarif_mingguan ?? 0 }},
    "bulanan": {{ $motor->tarifRental->tarif_bulanan ?? 0 }}
}
</script>
@endif

<script>
// Calculate cost estimation
function calculateCost() {
    const startDate = document.getElementById('tanggal_mulai').value;
    const endDate = document.getElementById('tanggal_selesai').value;
    const durationType = document.getElementById('tipe_durasi').value;
    const costEstimate = document.getElementById('cost-estimate');
    const totalCost = document.getElementById('total-cost');
    const durationInfo = document.getElementById('duration-info');

    if (!startDate || !endDate || !durationType) {
        costEstimate.classList.add('hidden');
        return;
    }

    const start = new Date(startDate);
    const end = new Date(endDate);
    const timeDiff = end.getTime() - start.getTime();
    const daysDiff = Math.ceil(timeDiff / (1000 * 3600 * 24)) + 1;

    if (daysDiff <= 0) {
        costEstimate.classList.add('hidden');
        return;
    }

    // Get tariff data from JSON script
    const tariffDataElement = document.getElementById('tariffData');
    let rates = { harian: 0, mingguan: 0, bulanan: 0 };
    
    if (tariffDataElement) {
        rates = JSON.parse(tariffDataElement.textContent);
    }

    let cost = 0;
    let info = '';

    if (durationType === 'harian') {
        cost = rates.harian * daysDiff;
        info = `${daysDiff} hari × Rp ${rates.harian.toLocaleString()}`;
    } else if (durationType === 'mingguan') {
        const weeks = Math.ceil(daysDiff / 7);
        cost = rates.mingguan * weeks;
        info = `${weeks} minggu × Rp ${rates.mingguan.toLocaleString()}`;
    } else if (durationType === 'bulanan') {
        const months = Math.ceil(daysDiff / 30);
        cost = rates.bulanan * months;
        info = `${months} bulan × Rp ${rates.bulanan.toLocaleString()}`;
    }

    totalCost.textContent = `Rp ${cost.toLocaleString()}`;
    durationInfo.textContent = info;
    costEstimate.classList.remove('hidden');
}

// Event listeners
document.getElementById('tanggal_mulai').addEventListener('change', function() {
    const startDate = this.value;
    const endDateInput = document.getElementById('tanggal_selesai');
    
    if (startDate) {
        const minEndDate = new Date(startDate);
        minEndDate.setDate(minEndDate.getDate() + 1);
        endDateInput.min = minEndDate.toISOString().split('T')[0];
        
        if (endDateInput.value && endDateInput.value <= startDate) {
            endDateInput.value = minEndDate.toISOString().split('T')[0];
        }
    }
    
    calculateCost();
});

document.getElementById('tanggal_selesai').addEventListener('change', calculateCost);
document.getElementById('tipe_durasi').addEventListener('change', calculateCost);

// Form submission validation
document.querySelector('form').addEventListener('submit', function(e) {
    const metodePembayaran = document.getElementById('metode_pembayaran').value;
    if (!metodePembayaran) {
        e.preventDefault();
        alert('Silakan pilih metode pembayaran terlebih dahulu.');
        document.getElementById('metode_pembayaran').focus();
        return false;
    }
});
</script>
@endsection