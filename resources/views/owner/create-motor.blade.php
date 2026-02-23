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
                <div class="mt-1 relative">
                    <input type="number" id="tipe_cc" name="tipe_cc" required min="50" max="2000" step="1"
                           class="block w-full px-4 py-3 pr-12 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 text-base @error('tipe_cc') border-red-500 @enderror"
                           placeholder="Contoh: 125, 150, 250"
                           value="{{ old('tipe_cc') }}">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <span class="text-gray-500 text-sm font-medium">cc</span>
                    </div>
                </div>
                <p class="mt-1 text-xs text-gray-500">Masukkan kapasitas mesin motor dalam satuan cc (50-2000cc)</p>
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
                
                <!-- Photo Preview Area -->
                <div id="photo-preview" class="mt-1 mb-3 hidden">
                    <div class="relative inline-block">
                        <img id="photo-preview-img" src="" alt="Preview" class="h-32 w-32 object-cover rounded-lg border border-gray-300">
                        <button type="button" id="remove-photo-preview" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <p class="text-sm text-gray-600 mt-2">Preview foto motor</p>
                </div>
                
                <!-- Upload Area -->
                <div id="photo-upload-area" class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-gray-400 transition-colors">
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
                
                <!-- Document Preview Area -->
                <div id="document-preview" class="mt-1 mb-3 hidden">
                    <div class="relative inline-block">
                        <div id="document-preview-content" class="border border-gray-300 rounded-lg p-4 bg-gray-50">
                            <!-- PDF Preview -->
                            <div id="pdf-preview" class="hidden text-center">
                                <svg class="mx-auto h-16 w-16 text-red-500 mb-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"></path>
                                </svg>
                                <p class="text-sm font-medium text-gray-700" id="pdf-filename"></p>
                                <p class="text-xs text-gray-500">PDF Document</p>
                            </div>
                            <!-- Image Preview -->
                            <img id="document-preview-img" src="" alt="Document Preview" class="h-32 w-auto mx-auto hidden rounded border">
                        </div>
                        <button type="button" id="remove-document-preview" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <p class="text-sm text-gray-600 mt-2">Preview dokumen kepemilikan</p>
                </div>
                
                <!-- Upload Area -->
                <div id="document-upload-area" class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-gray-400 transition-colors">
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
// Photo Preview Functionality
document.getElementById('photo').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const previewArea = document.getElementById('photo-preview');
    const previewImg = document.getElementById('photo-preview-img');
    const uploadArea = document.getElementById('photo-upload-area');
    
    if (file) {
        // Validate file type
        if (!file.type.startsWith('image/')) {
            alert('Hanya file gambar yang diizinkan (JPG, PNG, JPEG)');
            this.value = '';
            return;
        }
        
        // Validate file size (2MB)
        if (file.size > 2 * 1024 * 1024) {
            alert('Ukuran file terlalu besar. Maksimal 2MB');
            this.value = '';
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            previewArea.classList.remove('hidden');
            uploadArea.classList.add('hidden');
        };
        reader.readAsDataURL(file);
    }
});

// Remove Photo Preview
document.getElementById('remove-photo-preview').addEventListener('click', function() {
    document.getElementById('photo').value = '';
    document.getElementById('photo-preview').classList.add('hidden');
    document.getElementById('photo-upload-area').classList.remove('hidden');
});

// Document Preview Functionality
document.getElementById('dokumen_kepemilikan').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const previewArea = document.getElementById('document-preview');
    const uploadArea = document.getElementById('document-upload-area');
    const pdfPreview = document.getElementById('pdf-preview');
    const imagePreview = document.getElementById('document-preview-img');
    const pdfFilename = document.getElementById('pdf-filename');
    
    if (file) {
        // Validate file size (2MB)
        if (file.size > 2 * 1024 * 1024) {
            alert('Ukuran file terlalu besar. Maksimal 2MB');
            this.value = '';
            return;
        }
        
        const fileType = file.type;
        const fileName = file.name;
        
        if (fileType === 'application/pdf') {
            // Show PDF preview
            pdfFilename.textContent = fileName;
            pdfPreview.classList.remove('hidden');
            imagePreview.classList.add('hidden');
        } else if (fileType.startsWith('image/')) {
            // Show image preview
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                imagePreview.classList.remove('hidden');
                pdfPreview.classList.add('hidden');
            };
            reader.readAsDataURL(file);
        } else {
            alert('Hanya file PDF, JPG, PNG, JPEG yang diizinkan');
            this.value = '';
            return;
        }
        
        previewArea.classList.remove('hidden');
        uploadArea.classList.add('hidden');
    }
});

// Remove Document Preview
document.getElementById('remove-document-preview').addEventListener('click', function() {
    document.getElementById('dokumen_kepemilikan').value = '';
    document.getElementById('document-preview').classList.add('hidden');
    document.getElementById('document-upload-area').classList.remove('hidden');
    document.getElementById('pdf-preview').classList.add('hidden');
    document.getElementById('document-preview-img').classList.add('hidden');
});

// Drag and Drop functionality for photo
const photoUploadArea = document.getElementById('photo-upload-area');
photoUploadArea.addEventListener('dragover', function(e) {
    e.preventDefault();
    this.classList.add('border-blue-400', 'bg-blue-50');
});

photoUploadArea.addEventListener('dragleave', function(e) {
    e.preventDefault();
    this.classList.remove('border-blue-400', 'bg-blue-50');
});

photoUploadArea.addEventListener('drop', function(e) {
    e.preventDefault();
    this.classList.remove('border-blue-400', 'bg-blue-50');
    
    const files = e.dataTransfer.files;
    if (files.length > 0) {
        document.getElementById('photo').files = files;
        document.getElementById('photo').dispatchEvent(new Event('change'));
    }
});

// Drag and Drop functionality for document
const documentUploadArea = document.getElementById('document-upload-area');
documentUploadArea.addEventListener('dragover', function(e) {
    e.preventDefault();
    this.classList.add('border-blue-400', 'bg-blue-50');
});

documentUploadArea.addEventListener('dragleave', function(e) {
    e.preventDefault();
    this.classList.remove('border-blue-400', 'bg-blue-50');
});

documentUploadArea.addEventListener('drop', function(e) {
    e.preventDefault();
    this.classList.remove('border-blue-400', 'bg-blue-50');
    
    const files = e.dataTransfer.files;
    if (files.length > 0) {
        document.getElementById('dokumen_kepemilikan').files = files;
        document.getElementById('dokumen_kepemilikan').dispatchEvent(new Event('change'));
    }
});
</script>
@endsection