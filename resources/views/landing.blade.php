@extends('layouts.app')

@section('title', 'RideOn - Rental Motor Terpercaya')

@section('content')
<style>
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-20px); }
    }
    @keyframes slide-up {
        from { opacity: 0; transform: translateY(40px); }
        to { opacity: 1; transform: translateY(0); }
    }
    @keyframes fade-in {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    .animate-float { animation: float 6s ease-in-out infinite; }
    .animate-slide-up { animation: slide-up 0.8s ease-out; }
    .animate-fade-in { animation: fade-in 1s ease-out; }
</style>

<!-- Hero Section -->
<div class="relative bg-gradient-to-br from-gray-900 via-gray-800 to-black text-white overflow-hidden">
    <!-- Animated Grid Pattern -->
    <div class="absolute inset-0 opacity-5">
        <div class="absolute inset-0" style="background-image: linear-gradient(rgba(59, 130, 246, 0.3) 1.5px, transparent 1.5px), linear-gradient(90deg, rgba(59, 130, 246, 0.3) 1.5px, transparent 1.5px); background-size: 60px 60px;"></div>
    </div>
    
    <!-- Floating Gradient Orbs -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute -top-40 -right-40 w-[600px] h-[600px] bg-gradient-to-br from-blue-600 to-blue-800 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-float"></div>
        <div class="absolute -bottom-40 -left-40 w-[600px] h-[600px] bg-gradient-to-tr from-blue-700 to-blue-500 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-float" style="animation-delay: 2s;"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-gradient-to-br from-white/5 to-blue-500/10 rounded-full mix-blend-overlay filter blur-3xl opacity-30 animate-float" style="animation-delay: 4s;"></div>
    </div>
    
    <div class="relative max-w-7xl mx-auto px-4 py-28 sm:px-6 lg:px-8 lg:py-40">
        <div class="text-center animate-slide-up">
            <h1 class="text-6xl md:text-8xl font-black mb-8 tracking-tight leading-none">
                <span class="bg-gradient-to-r from-white via-white to-blue-300 bg-clip-text text-transparent">
                    Sewa Motor
                </span><br/>
                <span class="bg-gradient-to-r from-blue-400 via-blue-500 to-blue-600 bg-clip-text text-transparent">
                    Cepat & Mudah
                </span>
            </h1>
            <p class="text-2xl md:text-3xl mb-12 text-gray-300 max-w-4xl mx-auto leading-relaxed font-medium">
                Temukan motor impian Anda dengan harga terjangkau dan pelayanan terbaik di RideOn
            </p>
            <div class="flex flex-col sm:flex-row gap-5 justify-center">
                <a href="{{ route('login') }}" class="group inline-flex items-center justify-center px-10 py-5 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-black rounded-2xl hover:from-blue-700 hover:to-blue-800 transition-all duration-300 shadow-2xl shadow-blue-600/50 hover:shadow-3xl hover:shadow-blue-700/60 transform hover:-translate-y-1 text-lg">
                    <svg class="w-6 h-6 mr-3 group-hover:translate-x-1 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                    Mulai Sewa Sekarang
                </a>
                <a href="{{ route('register') }}" class="group inline-flex items-center justify-center px-10 py-5 bg-white/10 backdrop-blur-md border-2 border-white/30 text-white font-black rounded-2xl hover:bg-white hover:text-gray-900 hover:border-white transition-all duration-300 shadow-xl text-lg">
                    <svg class="w-6 h-6 mr-3 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                    </svg>
                    Daftar Gratis
                </a>
            </div>
        </div>
    </div>
    
    <!-- Modern Wave Separator -->
    <div class="absolute bottom-0 w-full">
        <svg viewBox="0 0 1440 140" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none" class="w-full h-28">
            <path d="M0,80L48,85.3C96,91,192,101,288,96C384,91,480,69,576,64C672,59,768,69,864,80C960,91,1056,101,1152,96C1248,91,1344,69,1392,58.7L1440,48L1440,140L1392,140C1344,140,1248,140,1152,140C1056,140,960,140,864,140C768,140,672,140,576,140C480,140,384,140,288,140C192,140,96,140,48,140L0,140Z" fill="white"/>
        </svg>
    </div>
</div>

<!-- Features Section -->
<div class="py-24 bg-white relative">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-20 animate-fade-in">
            <h2 class="text-5xl md:text-6xl font-black text-gray-900 mb-6 tracking-tight">
                Mengapa Pilih <span class="bg-gradient-to-r from-blue-600 to-blue-700 bg-clip-text text-transparent">RideOn</span>?
            </h2>
            <p class="text-2xl text-gray-600 max-w-3xl mx-auto leading-relaxed">
                Pengalaman sewa motor terbaik dengan berbagai keunggulan yang memudahkan perjalanan Anda
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <div class="group text-center p-10 bg-gradient-to-br from-white to-blue-50/30 rounded-3xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-3 border-2 border-gray-100 hover:border-blue-500">
                <div class="w-24 h-24 bg-gradient-to-br from-blue-600 to-blue-700 rounded-2xl flex items-center justify-center mx-auto mb-8 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-xl shadow-blue-600/40">
                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-black text-gray-900 mb-4">Proses Cepat</h3>
                <p class="text-gray-600 leading-relaxed text-base font-medium">
                    Booking motor hanya dalam hitungan menit dengan proses yang mudah dan cepat
                </p>
            </div>
            
            <!-- Feature 2 -->
            <div class="group text-center p-10 bg-gradient-to-br from-white to-gray-50/50 rounded-3xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-3 border-2 border-gray-100 hover:border-gray-900">
                <div class="w-24 h-24 bg-gradient-to-br from-gray-800 to-gray-950 rounded-2xl flex items-center justify-center mx-auto mb-8 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-xl shadow-gray-900/40">
                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-black text-gray-900 mb-4">Aman & Terpercaya</h3>
                <p class="text-gray-600 leading-relaxed text-base font-medium">
                    Semua motor terawat dengan baik dan data pribadi Anda aman bersama kami
                </p>
            </div>
            
            <!-- Feature 3 -->
            <div class="group text-center p-10 bg-gradient-to-br from-white to-blue-50/30 rounded-3xl hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-3 border-2 border-gray-100 hover:border-blue-500 md:col-span-2 lg:col-span-1 md:max-w-sm md:mx-auto lg:max-w-none">
                <div class="w-24 h-24 bg-gradient-to-br from-blue-600 to-blue-700 rounded-2xl flex items-center justify-center mx-auto mb-8 group-hover:scale-110 group-hover:rotate-3 transition-all duration-300 shadow-xl shadow-blue-600/40">
                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-black text-gray-900 mb-4">Harga Terjangkau</h3>
                <p class="text-gray-600 leading-relaxed text-base font-medium">
                    Tarif sewa yang kompetitif dengan berbagai pilihan motor sesuai budget
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Available Motors Section -->
<div class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Motor Tersedia</h2>
            <p class="text-xl text-gray-600">Pilihan motor berkualitas untuk perjalanan Anda</p>
        </div>
        
        @if($availableMotors->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($availableMotors as $motor)
                <div class="bg-white rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 overflow-hidden border border-gray-200">
                    <!-- Motor Image -->
                    <div class="relative h-48 bg-gray-200">
                        @if($motor->photo)
                            <img src="{{ asset('storage/' . $motor->photo) }}" 
                                 alt="{{ $motor->merk }}" 
                                 class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gray-100">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <circle cx="12" cy="12" r="9" stroke-width="2"></circle>
                                    <circle cx="12" cy="12" r="3" stroke-width="2"></circle>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v6m0 6v6m9-9h-6m-6 0H3"></path>
                                </svg>
                            </div>
                        @endif
                        
                        <!-- Status Badge -->
                        <div class="absolute top-2 right-2">
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                Tersedia
                            </span>
                        </div>
                    </div>
                    
                    <!-- Motor Info -->
                    <div class="p-4">
                        <div class="flex items-center justify-between mb-2">
                            <h3 class="text-lg font-bold text-gray-900">{{ $motor->merk }}</h3>
                            <span class="text-sm text-gray-600 bg-gray-100 px-2 py-1 rounded">{{ $motor->no_plat }}</span>
                        </div>
                        
                        <div class="space-y-2 mb-4">
                            <div class="flex items-center text-sm text-gray-600">
                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-2m-14 0h2m-2 0h-2m3-6h12.5"></path>
                                </svg>
                                {{ $motor->tipe_cc }} CC
                            </div>
                            
                            <div class="flex items-center text-sm text-gray-600">
                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                {{ $motor->owner->name }}
                            </div>
                        </div>
                        
                        <!-- Price -->
                        <div class="flex items-center justify-between">
                            <div>
                                <span class="text-2xl font-bold text-blue-600">Rp {{ number_format($motor->tarif_harian, 0, ',', '.') }}</span>
                                <span class="text-sm text-gray-500">/hari</span>
                            </div>
                        </div>
                        
                        <!-- Action Button -->
                        <div class="mt-4">
                            <button onclick="showLoginPrompt()" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors duration-200">
                                Sewa Sekarang
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            @if($availableMotors->hasPages())
                <div class="mt-12 flex justify-center">
                    {{ $availableMotors->links() }}
                </div>
            @endif
        @else
            <!-- Empty State -->
            <div class="text-center py-16">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Belum Ada Motor Tersedia</h3>
                <p class="text-gray-600 mb-6">Saat ini belum ada motor yang tersedia untuk disewa.</p>
                <a href="{{ route('register') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors">
                    Daftar Sebagai Pemilik Motor
                </a>
            </div>
        @endif
    </div>
</div>

<!-- CTA Section -->
<div class="bg-blue-600 text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-bold mb-4">Siap Memulai Perjalanan?</h2>
        <p class="text-xl text-blue-100 mb-8 max-w-2xl mx-auto">
            Bergabunglah dengan ribuan pengguna yang telah mempercayai RideOn untuk kebutuhan transportasi mereka
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('register') }}" class="inline-flex items-center px-8 py-4 bg-white text-blue-600 font-bold rounded-lg hover:bg-blue-50 transition-all duration-300 shadow-lg">
                Daftar Sekarang
            </a>
            <a href="{{ route('login') }}" class="inline-flex items-center px-8 py-4 bg-transparent border-2 border-white text-white font-bold rounded-lg hover:bg-white hover:text-blue-600 transition-all duration-300">
                Masuk ke Akun
            </a>
        </div>
    </div>
</div>

<!-- Login Prompt Modal -->
<div id="loginPromptModal" class="fixed inset-0 z-[9999] hidden pointer-events-none flex items-center justify-center p-4" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-black bg-opacity-50 modal-backdrop pointer-events-auto" onclick="closeLoginPrompt()"></div>
    
    <div class="relative bg-white rounded-xl shadow-2xl modal-content max-w-md w-full z-10 overflow-hidden transform transition-all duration-200 scale-100 pointer-events-auto">
        <div class="p-6">
            <div class="flex items-start">
                <div class="flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100">
                    <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                </div>
                <div class="ml-4 flex-1">
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Login Diperlukan</h3>
                    <p class="text-sm text-gray-600">
                        Untuk menyewa motor, Anda perlu login terlebih dahulu. Jika belum memiliki akun, silakan daftar gratis.
                    </p>
                </div>
            </div>
        </div>
        <div class="bg-gray-50 px-6 py-4 flex flex-col-reverse sm:flex-row sm:justify-end sm:space-x-3 space-y-3 space-y-reverse sm:space-y-0">
            <button onclick="closeLoginPrompt()" type="button" class="w-full sm:w-auto px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                Tutup
            </button>
            <div class="flex space-x-2 w-full sm:w-auto">
                <a href="{{ route('register') }}" class="flex-1 sm:flex-none px-4 py-2 text-sm font-medium text-blue-600 bg-blue-50 border border-blue-300 rounded-lg hover:bg-blue-100 transition-colors text-center">
                    Daftar
                </a>
                <a href="{{ route('login') }}" class="flex-1 sm:flex-none px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700 transition-colors text-center">
                    Login
                </a>
            </div>
        </div>
    </div>
</div>

<script>
function showLoginPrompt() {
    const modal = document.getElementById('loginPromptModal');
    modal.classList.remove('hidden', 'pointer-events-none');
    document.body.style.overflow = 'hidden';
}

function closeLoginPrompt() {
    const modal = document.getElementById('loginPromptModal');
    modal.classList.add('hidden', 'pointer-events-none');
    document.body.style.overflow = 'auto';
}

// Close modal with Escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closeLoginPrompt();
    }
});

// Close modal when clicking backdrop
document.getElementById('loginPromptModal').addEventListener('click', function(event) {
    if (event.target === this || event.target.classList.contains('modal-backdrop')) {
        closeLoginPrompt();
    }
});
</script>
@endsection