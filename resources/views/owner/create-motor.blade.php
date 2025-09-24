@extends('layouts.app')

@section('title', 'Daftarkan Motor - RideOn')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow-sm">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center">
                <a href="{{ route('owner.dashboard') }}" class="text-gray-400 hover:text-gray-600 mr-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <h1 class="text-xl font-semibold text-gray-900">Daftarkan Motor Baru</h1>
            </div>
        </div>
        
        <form method="POST" action="{{ route('owner.store-motor') }}" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf
            
            <div>
                <label for="merk" class="block text-sm font-medium text-gray-700">Merk Motor *</label>
                <input type="text" id="merk" name="merk" required
                       class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-base @error('merk') border-red-500 @enderror"
                       placeholder="Contoh: Honda Beat, Yamaha Mio, dll."
                       value="{{ old('merk') }}">
                @error('merk')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="tipe_cc" class="block text-sm font-medium text-gray-700">Tipe CC *</label>
                <select id="tipe_cc" name="tipe_cc" required
                        class="mt-1 block w-full px-4 py-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-base @error('tipe_cc') border-red-500 @enderror">
                    <option value="">Pilih Tipe CC</option>
                    <option value="100" {{ old('tipe_cc') == '100' ? 'selected' : '' }}>100cc</option>
                    <option value="125" {{ old('tipe_cc') == '125' ? 'selected' : '' }}>125cc</option>
                    <option value="150" {{ old('tipe_cc') == '150' ? 'selected' : '' }}>150cc</option>
                </select>
                @error('tipe_cc')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="no_plat" class="block text-sm font-medium text-gray-700">Nomor Plat *</label>
                <input type="text" id="no_plat" name="no_plat" required
                       class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-base @error('no_plat') border-red-500 @enderror"
                       placeholder="Contoh: D 1234 ABC"
                       value="{{ old('no_plat') }}">
                @error('no_plat')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="photo" class="block text-sm font-medium text-gray-700">Foto Motor</label>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-gray-400 transition-colors">
                    <div class="space-y-1 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex text-sm text-gray-600">
                            <label for="photo" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                <span>Upload foto</span>
                                <input id="photo" name="photo" type="file" class="sr-only" accept="image/*">
                            </label>
                            <p class="pl-1">atau drag and drop</p>
                        </div>
                        <p class="text-xs text-gray-500">PNG, JPG, JPEG up to 2MB</p>
                    </div>
                </div>
                @error('photo')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="dokumen_kepemilikan" class="block text-sm font-medium text-gray-700">Dokumen Kepemilikan</label>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-gray-400 transition-colors">
                    <div class="space-y-1 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                        </svg>
                        <div class="flex text-sm text-gray-600">
                            <label for="dokumen_kepemilikan" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                <span>Upload dokumen</span>
                                <input id="dokumen_kepemilikan" name="dokumen_kepemilikan" type="file" class="sr-only" accept=".pdf,.jpg,.jpeg,.png">
                            </label>
                            <p class="pl-1">atau drag and drop</p>
                        </div>
                        <p class="text-xs text-gray-500">PDF, JPG, JPEG, PNG up to 2MB</p>
                    </div>
                </div>
                @error('dokumen_kepemilikan')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="bg-blue-50 border border-blue-200 rounded-md p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-blue-800">Informasi Penting</h3>
                        <div class="mt-2 text-sm text-blue-700">
                            <ul class="list-disc list-inside space-y-1">
                                <li>Motor akan melalui proses verifikasi oleh admin sebelum dapat disewakan</li>
                                <li>Pastikan foto dan dokumen yang diupload jelas dan mudah dibaca</li>
                                <li>Tarif sewa akan ditetapkan oleh admin setelah verifikasi</li>
                                <li>Status motor akan berubah menjadi "Tersedia" setelah diverifikasi</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end space-x-4">
                <a href="{{ route('owner.dashboard') }}" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200">
                    Batal
                </a>
                <button type="submit" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-200">
                    Daftarkan Motor
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.getElementById('photo').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            // You can add preview functionality here if needed
            console.log('Photo selected:', file.name);
        };
        reader.readAsDataURL(file);
    }
});

document.getElementById('dokumen_kepemilikan').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        console.log('Document selected:', file.name);
    }
});
</script>
@endsection