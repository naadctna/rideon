@extends('layouts.app')

@section('title', 'Edit Motor - RideOn')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Edit Motor</h1>
                <p class="text-gray-600 mt-1">Perbarui informasi motor {{ $motor->merk }}</p>
            </div>
            <a href="{{ route('owner.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-md transition duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali
            </a>
        </div>
    </div>

    <!-- Edit Form -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <form action="{{ route('owner.update-motor', $motor->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Current Photo -->
            @if($motor->photo)
                <div>
                    <label class="block text-sm font-medium text-gray-700">Foto Saat Ini</label>
                    <div class="mt-2">
                        <img src="{{ asset('storage/' . $motor->photo) }}" alt="{{ $motor->merk }}" class="h-32 w-32 object-cover rounded-lg">
                    </div>
                </div>
            @endif

            <!-- Photo Upload -->
            <div>
                <label for="photo" class="block text-sm font-medium text-gray-700">
                    {{ $motor->photo ? 'Ganti Foto Motor (Opsional)' : 'Foto Motor (Opsional)' }}
                </label>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-gray-400 transition-colors">
                    <div class="space-y-1 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex text-sm text-gray-600">
                            <label for="photo" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                <span>Upload foto</span>
                                <input id="photo" name="photo" type="file" class="sr-only" accept="image/jpeg,image/png,image/jpg">
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

            <!-- Merk Motor -->
            <div>
                <label for="merk" class="block text-sm font-medium text-gray-700">Merk Motor</label>
                <input type="text" name="merk" id="merk" value="{{ old('merk', $motor->merk) }}" required
                       class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm text-base border-gray-300 rounded-md @error('merk') border-red-300 @enderror py-3 px-4"
                       placeholder="Contoh: Honda Beat, Yamaha Mio, dll">
                @error('merk')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tipe CC -->
            <div>
                <label for="tipe_cc" class="block text-sm font-medium text-gray-700">Tipe CC</label>
                <select name="tipe_cc" id="tipe_cc" required
                        class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm text-base border-gray-300 rounded-md @error('tipe_cc') border-red-300 @enderror py-3 px-4">
                    <option value="">Pilih Tipe CC</option>
                    <option value="100" {{ old('tipe_cc', $motor->tipe_cc) == '100' ? 'selected' : '' }}>100cc</option>
                    <option value="125" {{ old('tipe_cc', $motor->tipe_cc) == '125' ? 'selected' : '' }}>125cc</option>
                    <option value="150" {{ old('tipe_cc', $motor->tipe_cc) == '150' ? 'selected' : '' }}>150cc</option>
                </select>
                @error('tipe_cc')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Nomor Plat -->
            <div>
                <label for="no_plat" class="block text-sm font-medium text-gray-700">Nomor Plat</label>
                <input type="text" name="no_plat" id="no_plat" value="{{ old('no_plat', $motor->no_plat) }}" required
                       class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm text-base border-gray-300 rounded-md @error('no_plat') border-red-300 @enderror py-3 px-4"
                       placeholder="Contoh: D 1234 YTR">
                @error('no_plat')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Current Document -->
            @if($motor->dokumen_kepemilikan)
                <div>
                    <label class="block text-sm font-medium text-gray-700">Dokumen Kepemilikan Saat Ini</label>
                    <div class="mt-2 flex items-center space-x-4">
                        <div class="flex-shrink-0">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900">Dokumen Kepemilikan</p>
                            <p class="text-sm text-gray-500">File sudah terupload</p>
                        </div>
                        <a href="{{ asset('storage/' . $motor->dokumen_kepemilikan) }}" target="_blank" class="text-sm text-blue-600 hover:text-blue-500">Lihat</a>
                    </div>
                </div>
            @endif

            <!-- Document Upload -->
            <div>
                <label for="dokumen_kepemilikan" class="block text-sm font-medium text-gray-700">
                    {{ $motor->dokumen_kepemilikan ? 'Ganti Dokumen Kepemilikan (Opsional)' : 'Dokumen Kepemilikan (Opsional)' }}
                </label>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-gray-400 transition-colors">
                    <div class="space-y-1 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                            <path d="M8 18l4-4m0 0l4-4m-4 4v12m0 0l4-4m-4 4L8 18m24-10h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex text-sm text-gray-600">
                            <label for="dokumen_kepemilikan" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                <span>Upload dokumen</span>
                                <input id="dokumen_kepemilikan" name="dokumen_kepemilikan" type="file" class="sr-only" accept=".pdf,image/jpeg,image/png,image/jpg">
                            </label>
                            <p class="pl-1">atau drag and drop</p>
                        </div>
                        <p class="text-xs text-gray-500">PDF, PNG, JPG, JPEG up to 2MB</p>
                    </div>
                </div>
                <p class="mt-1 text-xs text-gray-500">Upload STNK atau dokumen kepemilikan motor lainnya</p>
                @error('dokumen_kepemilikan')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Note -->
            <div class="bg-blue-50 border border-blue-200 rounded-md p-4">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-blue-800">Catatan</h3>
                        <div class="mt-1 text-sm text-blue-700">
                            <p>Jika motor sedang dalam status "disewa", beberapa perubahan mungkin tidak akan berlaku sampai masa sewa berakhir.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('owner.dashboard') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Batal
                </a>
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
// Preview uploaded photo
document.getElementById('photo').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            // Create preview if doesn't exist
            let preview = document.getElementById('photo-preview');
            if (!preview) {
                preview = document.createElement('div');
                preview.id = 'photo-preview';
                preview.className = 'mt-2';
                preview.innerHTML = '<p class="text-sm font-medium text-gray-700 mb-2">Preview:</p><img id="preview-img" class="h-32 w-32 object-cover rounded-lg">';
                document.querySelector('label[for="photo"]').parentNode.parentNode.appendChild(preview);
            }
            document.getElementById('preview-img').src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
});

// File name display for document
document.getElementById('dokumen_kepemilikan').addEventListener('change', function(event) {
    const file = event.target.files[0];
    const label = document.querySelector('label[for="dokumen_kepemilikan"] span');
    if (file) {
        label.textContent = file.name;
    } else {
        label.textContent = 'Upload dokumen';
    }
});
</script>
@endsection