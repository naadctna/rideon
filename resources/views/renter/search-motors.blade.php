@extends('layouts.app')

@section('title', 'Cari Motor - RideOn')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h1 class="text-2xl font-bold text-gray-900">Cari Motor</h1>
        <p class="text-gray-600 mt-1">Temukan motor sesuai kebutuhan dan budget Anda</p>
    </div>

    <!-- Search Filter -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <form method="GET" action="{{ route('renter.search') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="merk" class="block text-sm font-medium text-gray-700">Merk Motor</label>
                    <select name="merk" id="merk" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Semua Merk</option>
                        @foreach($merkOptions as $merk)
                            <option value="{{ $merk }}" {{ request('merk') == $merk ? 'selected' : '' }}>{{ $merk }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="tipe_cc" class="block text-sm font-medium text-gray-700">Tipe CC</label>
                    <select name="tipe_cc" id="tipe_cc" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Semua Tipe</option>
                        <option value="100" {{ request('tipe_cc') == '100' ? 'selected' : '' }}>100cc</option>
                        <option value="125" {{ request('tipe_cc') == '125' ? 'selected' : '' }}>125cc</option>
                        <option value="150" {{ request('tipe_cc') == '150' ? 'selected' : '' }}>150cc</option>
                    </select>
                </div>

                <div>
                    <label for="min_price" class="block text-sm font-medium text-gray-700">Harga Min/Hari</label>
                    <input type="number" name="min_price" id="min_price" value="{{ request('min_price') }}" 
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                           placeholder="50000">
                </div>

                <div>
                    <label for="max_price" class="block text-sm font-medium text-gray-700">Harga Max/Hari</label>
                    <input type="number" name="max_price" id="max_price" value="{{ request('max_price') }}" 
                           class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                           placeholder="200000">
                </div>
            </div>

            <div class="flex justify-between items-center">
                <p class="text-sm text-gray-600">{{ $motors->total() }} motor tersedia</p>
                <div class="flex space-x-2">
                    <a href="{{ route('renter.search') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                        Reset
                    </a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Cari
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Motors Grid -->
    @if($motors->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($motors as $motor)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition duration-200">
                <div class="aspect-w-16 aspect-h-12">
                    @if($motor->photo)
                        <img src="{{ asset('storage/' . $motor->photo) }}" alt="{{ $motor->merk }}" class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                    @endif
                </div>

                <div class="p-4">
                    <div class="flex items-center justify-between mb-2">
                        <h3 class="text-lg font-semibold text-gray-900">{{ $motor->merk }}</h3>
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                            {{ $motor->tipe_cc }}cc
                        </span>
                    </div>
                    
                    <p class="text-sm text-gray-600 mb-3">{{ $motor->no_plat }}</p>

                    @if($motor->tarifRental)
                        <div class="space-y-2 mb-4">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Harian:</span>
                                <span class="font-semibold">Rp {{ number_format($motor->tarifRental->tarif_harian, 0, ',', '.') }}</span>
                            </div>
                            @if($motor->tarifRental->tarif_mingguan)
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Mingguan:</span>
                                <span class="font-semibold">Rp {{ number_format($motor->tarifRental->tarif_mingguan, 0, ',', '.') }}</span>
                            </div>
                            @endif
                            @if($motor->tarifRental->tarif_bulanan)
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Bulanan:</span>
                                <span class="font-semibold">Rp {{ number_format($motor->tarifRental->tarif_bulanan, 0, ',', '.') }}</span>
                            </div>
                            @endif
                        </div>
                    @else
                        <div class="mb-4">
                            <span class="text-sm text-red-600">Tarif belum ditetapkan</span>
                        </div>
                    @endif

                    <div class="flex space-x-2">
                        <a href="{{ route('renter.show-motor', $motor->id) }}" class="flex-1 bg-gray-100 text-gray-700 text-center py-2 px-3 rounded-md text-sm font-medium hover:bg-gray-200 transition duration-200">
                            Detail
                        </a>
                        @if($motor->tarifRental)
                            <a href="{{ route('renter.show-motor', $motor->id) }}#rent-form" class="flex-1 bg-blue-600 text-white text-center py-2 px-3 rounded-md text-sm font-medium hover:bg-blue-700 transition duration-200">
                                Sewa
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="bg-white rounded-lg shadow-sm p-4">
            {{ $motors->withQueryString()->links() }}
        </div>

    @else
        <div class="bg-white rounded-lg shadow-sm p-8 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada motor ditemukan</h3>
            <p class="mt-1 text-sm text-gray-500">Coba ubah kriteria pencarian Anda</p>
            <div class="mt-6">
                <a href="{{ route('renter.search') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-md transition duration-200">
                    Reset Pencarian
                </a>
            </div>
        </div>
    @endif
</div>
@endsection