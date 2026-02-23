<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'RideOn - Motor Rental System')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Navigation -->
    @if(Route::currentRouteName() == 'home' && Auth::guest())
    <!-- Landing Page Navigation (Guest Only) -->
    <nav class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <h1 class="text-xl font-bold text-blue-600">RideOn</h1>
                    </div>
                </div>
                
                <div class="flex items-center space-x-4">
                    <a href="{{ route('login') }}" class="text-gray-700 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition-colors">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">
                        Daftar
                    </a>
                </div>
            </div>
        </div>
    </nav>
    @elseif(auth()->check() && !in_array(Route::currentRouteName(), ['login', 'register']))
    <!-- Authenticated User Navigation -->
    <nav class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-center items-center h-16 relative">
                <div class="absolute left-0 flex items-center">
                    <div class="flex-shrink-0">
                        <h1 class="text-xl font-bold text-blue-600">RideOn</h1>
                    </div>
                </div>
                
                <div class="flex items-center">
                    <!-- Navigation Links for Owner -->
                    @if(Auth::user()->role == 'pemilik')
                    <div class="hidden md:flex items-center space-x-1">
                        <a href="{{ route('owner.dashboard') }}" class="px-4 py-2 rounded-md text-sm font-medium {{ request()->routeIs('owner.dashboard') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }} transition-colors">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                </svg>
                                Beranda
                            </div>
                        </a>
                        <a href="{{ route('owner.create-motor') }}" class="px-4 py-2 rounded-md text-sm font-medium {{ request()->routeIs('owner.create-motor') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }} transition-colors">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Titipkan Motor
                            </div>
                        </a>
                        <a href="{{ route('owner.motors') }}" class="px-4 py-2 rounded-md text-sm font-medium {{ request()->routeIs('owner.motors') || request()->routeIs('owner.show-motor') || request()->routeIs('owner.edit-motor') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }} transition-colors">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                </svg>
                                Status Motor
                            </div>
                        </a>
                        <a href="{{ route('owner.revenue') }}" class="px-4 py-2 rounded-md text-sm font-medium {{ request()->routeIs('owner.revenue') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }} transition-colors">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                                Laporan Bagi Hasil
                            </div>
                        </a>
                    </div>
                    @endif

                    <!-- Navigation Links for Admin -->
                    @if(Auth::user()->role == 'admin')
                    <div class="hidden md:flex items-center space-x-1">
                        <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 rounded-md text-sm font-medium {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }} transition-colors">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                </svg>
                                Beranda
                            </div>
                        </a>
                        <a href="{{ route('admin.motor-verification') }}" class="px-4 py-2 rounded-md text-sm font-medium {{ request()->routeIs('admin.motor-verification*') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }} transition-colors">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Verifikasi Motor
                            </div>
                        </a>
                        <a href="{{ route('admin.tarif-rental') }}" class="px-4 py-2 rounded-md text-sm font-medium {{ request()->routeIs('admin.tarif-rental*') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }} transition-colors">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Tarif Rental
                            </div>
                        </a>
                        <a href="{{ route('admin.rental-management') }}" class="px-4 py-2 rounded-md text-sm font-medium {{ request()->routeIs('admin.rental-management') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }} transition-colors">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                                Pemesanan
                            </div>
                        </a>
                        <a href="{{ route('admin.reports') }}" class="px-4 py-2 rounded-md text-sm font-medium {{ request()->routeIs('admin.reports') || request()->routeIs('admin.revenue-summary') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }} transition-colors">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                                Laporan
                            </div>
                        </a>
                        <a href="{{ route('admin.users') }}" class="px-4 py-2 rounded-md text-sm font-medium {{ request()->routeIs('admin.users*') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }} transition-colors">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                                Kelola Pengguna
                            </div>
                        </a>
                    </div>
                    @endif

                    <!-- Navigation Links for Renter -->
                    @if(Auth::user()->role == 'penyewa')
                    <div class="hidden md:flex items-center space-x-1">
                        <a href="{{ route('renter.dashboard') }}" class="px-4 py-2 rounded-md text-sm font-medium {{ request()->routeIs('renter.dashboard') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }} transition-colors">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                </svg>
                                Beranda
                            </div>
                        </a>
                        <a href="{{ route('renter.search') }}" class="px-4 py-2 rounded-md text-sm font-medium {{ request()->routeIs('renter.search') || request()->routeIs('renter.show-motor') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }} transition-colors">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                Cari Motor
                            </div>
                        </a>
                        <a href="{{ route('renter.my-rentals') }}" class="px-4 py-2 rounded-md text-sm font-medium {{ request()->routeIs('renter.my-rentals') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }} transition-colors">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                                </svg>
                                Riwayat Sewa
                            </div>
                        </a>
                    </div>
                    @endif
                </div>
                
                <div class="absolute right-0 flex items-center space-x-4">
                    <!-- Mobile menu button (Owner, Admin & Renter) -->
                    @if(Auth::user()->role == 'pemilik' || Auth::user()->role == 'admin' || Auth::user()->role == 'penyewa')
                    <button data-action="toggle-mobile-menu" class="md:hidden inline-flex items-center justify-center p-2 rounded-md text-gray-700 hover:text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                    @endif
                    
                    <!-- Profile Dropdown -->
                    <div class="relative">
                        <button data-action="toggle-profile-dropdown" class="flex items-center space-x-3 text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                    <span class="text-blue-600 font-medium text-sm">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                </div>
                                <div class="text-left ml-3">
                                    <div class="font-medium">{{ Auth::user()->name }}</div>
                                    <div class="text-xs text-gray-500">{{ ucfirst(Auth::user()->role) }}</div>
                                </div>
                                <svg class="w-4 h-4 text-gray-400 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </button>

                        <!-- Dropdown Menu -->
                        <div id="profile-dropdown" class="hidden absolute right-0 z-50 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu">
                            <div class="py-1" role="none">
                                <!-- Profile Header -->
                                <div class="px-4 py-3 border-b border-gray-100">
                                    <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                                    <p class="text-sm text-gray-500">{{ Auth::user()->email }}</p>
                                    <p class="text-xs text-gray-400 mt-1">{{ ucfirst(Auth::user()->role) }}</p>
                                </div>
                                
                                <!-- Profile Actions -->
                                <button onclick="showEditProfileModal(); return false;" class="group flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">
                                    <svg class="w-4 h-4 mr-3 text-gray-400 group-hover:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    Edit Profile
                                </button>
                                
                                <button data-action="confirm-logout" class="group flex items-center w-full px-4 py-2 text-sm text-red-700 hover:bg-red-50" role="menuitem">
                                    <svg class="w-4 h-4 mr-3 text-red-500 group-hover:text-red-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                    Logout
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Mobile Menu (Owner only) -->
        @if(Auth::user()->role == 'pemilik')
        <div id="mobile-menu" class="hidden md:hidden border-t border-gray-200 bg-white">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="{{ route('owner.dashboard') }}" class="flex items-center px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('owner.dashboard') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }} transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Beranda
                </a>
                <a href="{{ route('owner.create-motor') }}" class="flex items-center px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('owner.create-motor') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }} transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Titipkan Motor
                </a>
                <a href="{{ route('owner.motors') }}" class="flex items-center px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('owner.motors') || request()->routeIs('owner.show-motor') || request()->routeIs('owner.edit-motor') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }} transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                    Status Motor
                </a>
                <a href="{{ route('owner.revenue') }}" class="flex items-center px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('owner.revenue') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }} transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    Laporan Bagi Hasil
                </a>
            </div>
        </div>
        @endif

        <!-- Mobile Menu (Admin only) -->
        @if(Auth::user()->role == 'admin')
        <div id="mobile-menu" class="hidden md:hidden border-t border-gray-200 bg-white">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }} transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Beranda
                </a>
                <a href="{{ route('admin.motor-verification') }}" class="flex items-center px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('admin.motor-verification*') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }} transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Verifikasi Motor
                </a>
                <a href="{{ route('admin.tarif-rental') }}" class="flex items-center px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('admin.tarif-rental*') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }} transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Tarif Rental
                </a>
                <a href="{{ route('admin.rental-management') }}" class="flex items-center px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('admin.rental-management') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }} transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    Pemesanan
                </a>
                <a href="{{ route('admin.reports') }}" class="flex items-center px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('admin.reports') || request()->routeIs('admin.revenue-summary') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }} transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    Laporan
                </a>
                <a href="{{ route('admin.users') }}" class="flex items-center px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('admin.users*') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }} transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    Kelola Pengguna
                </a>
            </div>
        </div>
        @endif

        <!-- Mobile Menu (Renter only) -->
        @if(Auth::user()->role == 'penyewa')
        <div id="mobile-menu" class="hidden md:hidden border-t border-gray-200 bg-white">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="{{ route('renter.dashboard') }}" class="flex items-center px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('renter.dashboard') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }} transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Beranda
                </a>
                <a href="{{ route('renter.search') }}" class="flex items-center px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('renter.search') || request()->routeIs('renter.show-motor') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }} transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Cari Motor
                </a>
                <a href="{{ route('renter.my-rentals') }}" class="flex items-center px-3 py-2 rounded-md text-sm font-medium {{ request()->routeIs('renter.my-rentals') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }} transition-colors">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                    Riwayat Sewa
                </a>
            </div>
        </div>
        @endif
    </nav>
    @endif

    <!-- Main Content -->
    <main class="@auth @if(!in_array(Route::currentRouteName(), ['home'])) py-6 @endif @else @if(!in_array(Route::currentRouteName(), ['home'])) py-12 @endif @endauth">
        @if(!in_array(Route::currentRouteName(), ['home']))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @endif
            
            @yield('content')
        @if(!in_array(Route::currentRouteName(), ['home']))
        </div>
        @endif
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-auto">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <p class="text-center text-sm text-gray-500">
                © 2025 RideOn Motor Rental System. All rights reserved.
            </p>
        </div>
    </footer>

    @auth
    <!-- Edit Profile Modal -->
    <div id="editProfileModal" class="fixed inset-0 z-[9999] hidden flex items-center justify-center p-4" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-black bg-opacity-50 modal-backdrop" aria-hidden="true" onclick="closeEditProfileModal()"></div>
        
        <div class="relative bg-white rounded-lg shadow-2xl modal-content max-w-3xl w-full z-10 max-h-[90vh] overflow-y-auto transform transition-all duration-200 scale-100">
                <!-- Header -->
                <div class="bg-blue-600 px-4 py-3 text-white relative rounded-t-lg">
                    <button onclick="closeEditProfileModal()" class="absolute top-3 right-4 text-white/80 hover:text-white transition-all duration-200 hover:rotate-90 z-10">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                    
                    <!-- Header Layout -->
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center mr-4">
                            <span class="text-lg font-bold text-white">{{ substr(Auth::user()->name, 0, 1) }}</span>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold mb-0">Edit Profil</h3>
                            <p class="text-white/80 text-sm">Perbarui informasi akun Anda</p>
                        </div>
                    </div>
                </div>
                
                <!-- Form Content -->
                <div class="p-4 rounded-b-lg">
                    
                    <form id="editProfileForm" method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                            <!-- Personal Information Card -->
                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                <div class="flex items-center mb-4">
                                    <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center mr-3">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="text-lg font-bold text-gray-900">Informasi Personal</h4>
                                        <p class="text-sm text-gray-500">Detail akun dasar</p>
                                    </div>
                                </div>
                                
                                <div class="space-y-4">
                                    <div class="relative">
                                        <label for="edit_name" class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                                        <input type="text" id="edit_name" name="name" value="{{ Auth::user()->name }}" required
                                               class="block w-full px-4 py-3 border border-gray-300 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-white">
                                    </div>
                                    
                                    <div class="relative">
                                        <label for="edit_email" class="block text-sm font-semibold text-gray-700 mb-2">Alamat Email</label>
                                        <input type="email" id="edit_email" name="email" value="{{ Auth::user()->email }}" required
                                               class="block w-full px-4 py-3 border border-gray-300 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-white">
                                    </div>
                                </div>
                            </div>

                            <!-- Contact Information Card -->
                            <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                <div class="flex items-center mb-4">
                                    <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center mr-3">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="text-lg font-bold text-gray-900">Kontak & Lokasi</h4>
                                        <p class="text-sm text-gray-500">Detail komunikasi</p>
                                    </div>
                                </div>
                                
                                <div class="space-y-4">
                                    <div class="relative">
                                        <label for="edit_phone" class="block text-sm font-semibold text-gray-700 mb-2">Nomor Telepon</label>
                                        <input type="tel" id="edit_phone" name="phone" value="{{ Auth::user()->no_tlpn }}" 
                                               class="block w-full px-4 py-3 border border-gray-300 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-white"
                                               placeholder="08123456789">
                                        <p class="text-xs text-gray-500 mt-1">Untuk koordinasi pickup motor</p>
                                    </div>
                                    
                                    <div class="relative">
                                        <label for="edit_address" class="block text-sm font-semibold text-gray-700 mb-2">Alamat</label>
                                        <textarea id="edit_address" name="address" rows="2" 
                                                  class="block w-full px-4 py-3 border border-gray-300 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 bg-white resize-none"
                                                  placeholder="Area/kecamatan untuk koordinasi...">{{ Auth::user()->address }}</textarea>
                                        <p class="text-xs text-gray-500 mt-1">Referensi area umum</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="mt-4 flex justify-center space-x-4 pt-4 pb-1">
                            <button type="button" onclick="closeEditProfileModal()" 
                                    class="px-8 py-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 hover:bg-gray-50 rounded-lg transition-all duration-200 min-w-[120px]">
                                Batal
                            </button>
                            <button type="submit" 
                                    class="px-8 py-3 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-all duration-200 shadow-md min-w-[140px]">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
    </div>

    <!-- Logout Confirmation Modal -->
    <div id="logoutModal" class="fixed inset-0 z-[9999] hidden flex items-center justify-center p-4" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-black bg-opacity-50 modal-backdrop" aria-hidden="true" onclick="closeLogoutModal()"></div>
        
        <div class="relative bg-white rounded-xl shadow-2xl modal-content max-w-md w-full z-10 overflow-hidden transform transition-all duration-200 scale-100">
                <div class="p-6">
                    <div class="flex items-start">
                        <div class="flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                            <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                        </div>
                        <div class="ml-4 flex-1">
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Konfirmasi Logout</h3>
                            <p class="text-sm text-gray-600">
                                Apakah Anda yakin ingin keluar dari akun <strong>{{ Auth::user()->name }}</strong>? Anda perlu login kembali untuk mengakses dashboard.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-6 py-4 flex flex-col-reverse sm:flex-row sm:justify-end sm:space-x-3 space-y-3 space-y-reverse sm:space-y-0">
                    <button onclick="closeLogoutModal()" type="button" class="w-full sm:w-auto px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        Batal
                    </button>
                    <form id="logoutForm" method="POST" action="{{ route('logout') }}" class="w-full sm:w-auto">
                        @csrf
                        <button type="submit" class="w-full px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors">
                            Ya, Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
    // Profile Dropdown Toggle Function
    function toggleProfileDropdown() {
        const dropdown = document.getElementById('profile-dropdown');
        if (dropdown) {
            dropdown.classList.toggle('hidden');
        }
    }

    // Profile Dropdown Toggle
    document.addEventListener('click', function(e) {
        const actionElement = e.target.closest('[data-action]');
        
        if (actionElement && actionElement.dataset.action) {
            const action = actionElement.dataset.action;
            
            switch(action) {
                case 'toggle-profile-dropdown':
                    e.preventDefault();
                    toggleProfileDropdown();
                    break;
                case 'toggle-mobile-menu':
                    e.preventDefault();
                    toggleMobileMenu();
                    break;
                case 'confirm-logout':
                    e.preventDefault();
                    showLogoutModal();
                    break;
            }
        }
    });

    function toggleProfileDropdown() {
        const dropdown = document.getElementById('profile-dropdown');
        dropdown.classList.toggle('hidden');
    }

    function toggleMobileMenu() {
        const mobileMenu = document.getElementById('mobile-menu');
        if (mobileMenu) {
            mobileMenu.classList.toggle('hidden');
        }
    }

    function showEditProfileModal() {
        const modal = document.getElementById('editProfileModal');
        const dropdown = document.getElementById('profile-dropdown');
        
        if (modal) {
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            
            // Hide dropdown
            if (dropdown) {
                dropdown.classList.add('hidden');
            }
            
            // Focus trap - focus on first input
            setTimeout(() => {
                const firstInput = modal.querySelector('input[type="text"], input[type="email"]');
                if (firstInput) {
                    firstInput.focus();
                }
            }, 200);
        }
    }

    function closeEditProfileModal() {
        const modal = document.getElementById('editProfileModal');
        if (modal) {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
    }

    function showLogoutModal() {
        document.getElementById('logoutModal').classList.remove('hidden');
        document.getElementById('profile-dropdown').classList.add('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeLogoutModal() {
        document.getElementById('logoutModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        if (!event.target.closest('[data-action="toggle-profile-dropdown"]') && !event.target.closest('#profile-dropdown')) {
            document.getElementById('profile-dropdown').classList.add('hidden');
        }
        
        // Close mobile menu when clicking outside
        const mobileMenu = document.getElementById('mobile-menu');
        if (mobileMenu && !event.target.closest('[data-action="toggle-mobile-menu"]') && !event.target.closest('#mobile-menu')) {
            mobileMenu.classList.add('hidden');
        }
    });

    // Close modals with Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeEditProfileModal();
            closeLogoutModal();
        }
    });

    // Close modals when clicking backdrop
    document.addEventListener('DOMContentLoaded', function() {
        const editProfileModal = document.getElementById('editProfileModal');
        const logoutModal = document.getElementById('logoutModal');
        
        if (editProfileModal) {
            editProfileModal.addEventListener('click', function(event) {
                if (event.target === this || event.target.classList.contains('modal-backdrop')) {
                    closeEditProfileModal();
                }
            });
        }
        
        if (logoutModal) {
            logoutModal.addEventListener('click', function(event) {
                if (event.target === this || event.target.classList.contains('modal-backdrop')) {
                    closeLogoutModal();
                }
            });
        }
    });
    </script>
    @endauth

    <!-- Notification Popup -->
    <div id="notificationPopup" class="fixed top-4 left-1/2 -translate-x-1/2 z-[10000] hidden transform transition-all duration-300 ease-in-out">
        <div class="bg-white rounded-lg shadow-2xl border border-gray-200 max-w-md w-full">
            <div class="p-4">
                <div class="flex items-start">
                    <div id="notificationIcon" class="flex-shrink-0 mr-3">
                        <!-- Icon will be set by JavaScript -->
                    </div>
                    <div class="flex-1 min-w-0">
                        <div id="notificationTitle" class="text-sm font-medium text-gray-900"></div>
                        <div id="notificationMessage" class="text-sm text-gray-600 mt-1"></div>
                    </div>
                    <div class="flex-shrink-0 ml-4">
                        <button onclick="closeNotification()" class="text-gray-400 hover:text-gray-600 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    function showNotification(title, message, type = 'success') {
        const popup = document.getElementById('notificationPopup');
        const icon = document.getElementById('notificationIcon');
        const titleEl = document.getElementById('notificationTitle');
        const messageEl = document.getElementById('notificationMessage');
        
        // Set content
        titleEl.textContent = title;
        messageEl.textContent = message;
        
        // Set icon based on type
        let iconHTML = '';
        let iconClass = '';
        
        switch(type) {
            case 'success':
                iconClass = 'text-green-500';
                iconHTML = '<svg class="w-5 h-5 ' + iconClass + '" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';
                break;
            case 'error':
                iconClass = 'text-red-500';
                iconHTML = '<svg class="w-5 h-5 ' + iconClass + '" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';
                break;
            case 'warning':
                iconClass = 'text-yellow-500';
                iconHTML = '<svg class="w-5 h-5 ' + iconClass + '" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.5 0L4.268 18.5c-.77.833.192 2.5 1.732 2.5z"></path></svg>';
                break;
            default:
                iconClass = 'text-blue-500';
                iconHTML = '<svg class="w-5 h-5 ' + iconClass + '" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';
        }
        
        icon.innerHTML = iconHTML;
        
        // Show notification
        popup.classList.remove('hidden');
        popup.style.transform = 'translate(-50%, 0)';
        
        // Auto hide after 4 seconds
        setTimeout(() => {
            closeNotification();
        }, 4000);
    }
    
    function closeNotification() {
        const popup = document.getElementById('notificationPopup');
        popup.style.transform = 'translateX(100%)';
        setTimeout(() => {
            popup.classList.add('hidden');
        }, 300);
    }
    
    // Check for Laravel flash messages and show notifications
    document.addEventListener('DOMContentLoaded', function() {
        @if(session('success'))
            showNotification('Berhasil', '{{ session('success') }}', 'success');
        @endif
        
        @if(session('error'))
            showNotification('Error', '{{ session('error') }}', 'error');
        @endif
        
        @if(session('warning'))
            showNotification('Peringatan', '{{ session('warning') }}', 'warning');
        @endif
        
        @if(session('info'))
            showNotification('Informasi', '{{ session('info') }}', 'info');
        @endif
        
        @if($errors->any())
            @foreach($errors->all() as $error)
                showNotification('Error Validasi', '{{ $error }}', 'error');
            @endforeach
        @endif
    });
    </script>

    <!-- Additional Page Scripts -->
    @stack('scripts')
</body>
</html>