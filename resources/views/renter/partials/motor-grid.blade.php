@if($motors->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach($motors as $motor)
        <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition duration-300 overflow-hidden">
            <div class="relative">
                @if($motor->photo)
                    <img src="{{ asset('storage/' . $motor->photo) }}" alt="{{ $motor->merk }}" class="w-full h-56 object-cover">
                @else
                    <div class="w-full h-56 bg-gray-200 flex items-center justify-center">
                        <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="9" stroke-width="2"></circle>
                            <circle cx="12" cy="12" r="3" stroke-width="2"></circle>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v6m0 6v6m9-9h-6m-6 0H3"></path>
                        </svg>
                    </div>
                @endif
                <div class="absolute top-2 right-2">
                    @if($motor->status == 'tersedia')
                        <span class="bg-green-500 text-white px-2 py-1 rounded text-xs font-semibold">
                            Tersedia
                        </span>
                    @elseif($motor->status == 'disewa')
                        <span class="bg-red-500 text-white px-2 py-1 rounded text-xs font-semibold">
                            Disewa
                        </span>
                    @else
                        <span class="bg-gray-500 text-white px-2 py-1 rounded text-xs font-semibold">
                            {{ ucfirst($motor->status) }}
                        </span>
                    @endif
                </div>
            </div>
            <div class="p-4">
                <h3 class="font-semibold text-lg text-gray-900 mb-2">{{ $motor->merk }}</h3>
                <div class="space-y-1 text-sm text-gray-600 mb-3">
                    <div class="flex justify-between">
                        <span>Plat:</span>
                        <span class="font-medium text-gray-900">{{ $motor->no_plat }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>CC:</span>
                        <span class="font-medium text-gray-900">{{ $motor->tipe_cc }}cc</span>
                    </div>
                </div>
                @if($motor->tarifRental)
                    <div class="border-t pt-3">
                        <div class="flex justify-between items-center mb-3">
                            <span class="text-sm text-gray-600">Harga per hari:</span>
                            <span class="text-lg font-bold text-green-600">
                                Rp {{ number_format($motor->tarifRental->tarif_harian, 0, ',', '.') }}
                            </span>
                        </div>
                        @if($motor->status == 'tersedia')
                            <a href="{{ route('renter.show-motor', $motor->id) }}" 
                               class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition duration-200 text-center block">
                                Lihat Detail
                            </a>
                        @else
                            <button disabled 
                               class="w-full bg-gray-400 text-white font-medium py-2 px-4 rounded-md text-center cursor-not-allowed">
                                Sedang Disewa
                            </button>
                        @endif
                    </div>
                @else
                    <div class="border-t pt-3">
                        <span class="text-sm text-gray-500 italic">Tarif belum diset</span>
                    </div>
                @endif
            </div>
        </div>
        @endforeach
    </div>
@else
    <div class="text-center py-12 bg-gray-50 rounded-lg">
        <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <circle cx="12" cy="12" r="9" stroke-width="2"></circle>
            <circle cx="12" cy="12" r="3" stroke-width="2"></circle>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v6m0 6v6m9-9h-6m-6 0H3"></path>
        </svg>
        <h3 class="mt-4 text-lg font-medium text-gray-900">Tidak ada motor ditemukan</h3>
        <p class="mt-2 text-gray-500">Coba ubah filter atau lihat semua motor di halaman pencarian</p>
        <div class="mt-6">
            <a href="{{ route('renter.search') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md transition duration-200">
                Lihat Semua Motor
            </a>
        </div>
    </div>
@endif