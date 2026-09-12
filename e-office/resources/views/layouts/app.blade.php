<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://cdn.tailwindcss.com"></script>
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </head>
    <body class="font-sans antialiased">
    <div x-data="{ sidebarOpen: false }" class="flex h-screen overflow-hidden bg-white">

        <!-- Backdrop Overlay (Mobile Only) -->
        <div x-show="sidebarOpen" 
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="sidebarOpen = false" 
             class="fixed inset-0 z-40 bg-slate-900/50 backdrop-blur-sm lg:hidden"
             style="display: none;"></div>

        <!-- Sidebar -->
        <div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
             class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-slate-200/60 flex flex-col shrink-0 h-full transition-transform duration-300 -translate-x-full lg:translate-x-0 lg:static lg:h-full">
            <!-- Brand logo / title (Height h-16 matches Top Bar exactly!) -->
            <div class="h-16 px-6 border-b border-slate-150 flex items-center justify-between gap-3 shrink-0">
                <div class="flex items-center gap-3">
                    <!-- Clean and Modern SIDI Logo Icon -->
                    <div class="w-9 h-9 rounded-xl bg-purple-600 flex items-center justify-center shadow-md shadow-purple-600/20 shrink-0">
                        <svg class="w-5.5 h-5.5 text-white" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 3.5L20.5 18H3.5L12 3.5Z" stroke="currentColor" stroke-width="2.5" stroke-linejoin="round" stroke-linecap="round" fill="none"/>
                            <rect x="11.25" y="13.5" width="1.5" height="3" fill="currentColor" rx="0.5"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-sm font-black text-slate-800 tracking-wider uppercase leading-none">
                            SIDI
                        </h2>
                        <p class="text-[7px] text-slate-400 font-bold tracking-wider uppercase mt-1 leading-none">Sistem Informasi Disposisi Internal</p>
                    </div>
                </div>
                <!-- Close Sidebar Button (Mobile Only) -->
                <button @click="sidebarOpen = false" class="lg:hidden p-1.5 rounded-lg hover:bg-slate-100 text-slate-500 hover:text-slate-700 transition-colors">
                    <svg class="w-5.5 h-5.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Sidebar Navigation Content -->
            <div class="flex-1 p-6 flex flex-col justify-between overflow-y-auto">
                <!-- Navigation List -->
                <ul class="space-y-1.5">
                    @if(auth()->user()->role == 'admin')
                        <li>
                            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-[11px] font-bold transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-600' : 'hover:bg-slate-50 hover:text-slate-800 text-slate-500' }}">
                                <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('dashboard') ? 'text-indigo-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z"></path>
                                </svg>
                                Dashboard
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('user.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-[11px] font-bold transition-all duration-200 {{ request()->routeIs('user.*') ? 'bg-indigo-50 text-indigo-600' : 'hover:bg-slate-50 hover:text-slate-800 text-slate-500' }}">
                                <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('user.*') ? 'text-indigo-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                                Manajemen User
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('bidang.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-[11px] font-bold transition-all duration-200 {{ request()->routeIs('bidang.*') ? 'bg-indigo-50 text-indigo-600' : 'hover:bg-slate-50 hover:text-slate-800 text-slate-500' }}">
                                <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('bidang.*') ? 'text-indigo-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                                Manajemen Bidang
                            </a>
                        </li>
                    @endif

                    @if(auth()->user()->role == 'kabid' || auth()->user()->role == 'kasi')
                        <li>
                            <a href="{{ route('kabid.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-[11px] font-bold transition-all duration-200 {{ request()->routeIs('kabid.dashboard') ? 'bg-indigo-50 text-indigo-600' : 'hover:bg-slate-50 hover:text-slate-800 text-slate-500' }}">
                                <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('kabid.dashboard') ? 'text-indigo-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z"></path>
                                </svg>
                                {{ auth()->user()->role == 'kasi' ? 'Dashboard Kasi' : 'Dashboard Kabid' }}
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('surat.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-[11px] font-bold transition-all duration-200 {{ request()->routeIs('surat.*') ? 'bg-indigo-50 text-indigo-600' : 'hover:bg-slate-50 hover:text-slate-800 text-slate-500' }}">
                                <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('surat.*') ? 'text-indigo-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                Surat & Disposisi
                            </a>
                        </li>
                    @endif

                    @if(auth()->user()->role == 'staff')
                        <li>
                            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-[11px] font-bold transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-600' : 'hover:bg-slate-50 hover:text-slate-800 text-slate-500' }}">
                                <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('dashboard') ? 'text-indigo-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H6a2 2 0 01-2-2v-4zM14 16a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 01-2-2v-4z"></path>
                                </svg>
                                Dashboard Staff
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('surat.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-[11px] font-bold transition-all duration-200 {{ request()->routeIs('surat.*') ? 'bg-indigo-50 text-indigo-600' : 'hover:bg-slate-50 hover:text-slate-800 text-slate-500' }}">
                                <svg class="w-4 h-4 shrink-0 {{ request()->routeIs('surat.*') ? 'text-indigo-600' : 'text-slate-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                Surat & Disposisi
                            </a>
                        </li>
                    @endif
                </ul>

                <!-- Logout -->
                <div class="border-t border-slate-100 pt-4 mt-auto">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full px-4 py-3 text-[11px] font-bold rounded-xl text-slate-500 hover:text-slate-805 hover:bg-slate-50 transition-all flex items-center gap-3">
                            <svg class="w-4 h-4 shrink-0 text-slate-450" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            Logout Akun
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Right Content Pane -->
        <div class="flex-1 flex flex-col h-full overflow-hidden bg-slate-50/60">

            <!-- Sticky Header Navbar Wrapper (Unified / Flush with Sidebar) -->
            <div class="h-16 bg-white border-b border-slate-200/60 px-4 sm:px-6 flex items-center justify-between shrink-0">
                <!-- Left Side: Burger Menu Button & Institution Name Badge -->
                <div class="flex items-center gap-3">
                    <!-- Toggle Sidebar Button (Mobile Only) -->
                    <button @click="sidebarOpen = true" class="lg:hidden p-1.5 rounded-lg hover:bg-slate-100 text-slate-500 hover:text-slate-700 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                    
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-blue-50/50 text-blue-700 text-[10px] font-bold uppercase tracking-wider rounded-full border border-blue-100">
                        <span class="w-1.5 h-1.5 bg-blue-500 rounded-full"></span>
                        <span class="hidden md:inline">Dinas Kelautan dan Perikanan Prov. Sumatera Selatan</span>
                        <span class="md:hidden">DKP Prov. Sumsel</span>
                    </div>
                </div>

                <!-- Right Side: Alerts & User Profile Info -->
                <div class="flex items-center gap-5">
                    <!-- User Information Card -->
                    <div class="flex items-center gap-3">
                        <div class="text-right hidden sm:block">
                            <h4 class="text-xs font-bold text-slate-805 leading-tight">
                                {{ auth()->user()->name }}
                            </h4>
                            <p class="text-[9px] text-slate-450 uppercase tracking-wider font-semibold mt-0.5">
                                @if(auth()->user()->role === 'admin')
                                    Administrator
                                @elseif(auth()->user()->role === 'kabid')
                                    {{ auth()->user()->bidang->nama_bidang ?? 'Kepala Bidang' }}
                                @elseif(auth()->user()->role === 'kasi')
                                    {{ auth()->user()->bidang->nama_bidang ?? 'Kepala Seksi' }} (Kasi)
                                @else
                                    {{ auth()->user()->bidang->nama_bidang ?? 'Staff' }}
                                @endif
                            </p>
                        </div>
                        <div class="w-8 h-8 rounded-full overflow-hidden border border-slate-200/80 bg-slate-50 flex items-center justify-center">
                            <svg class="w-4.5 h-4.5 text-slate-400" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M7.5 6a4.5 4.5 0 119 0 4.5 4.5 0 01-9 0zM3.751 20.105a8.25 8.25 0 0116.498 0 .75.75 0 01-.437.695A18.683 18.683 0 0112 22.5c-2.786 0-5.433-.608-7.812-1.7a.75.75 0 01-.437-.695z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Scrollable Content Container -->
            <div class="flex-1 overflow-y-auto p-6">
                @yield('content')
            </div>

        </div>

    </div>
</body>
</html>
