@extends('layouts.app')

@section('content')
<div class="space-y-8">
    <!-- Welcome Banner -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 p-8 shadow-lg border border-slate-800">
        <div class="absolute -right-10 -top-10 w-40 h-40 bg-indigo-500/10 rounded-full blur-3xl"></div>
        <div class="absolute -left-10 -bottom-10 w-40 h-40 bg-blue-500/10 rounded-full blur-3xl"></div>
        
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <span class="text-indigo-400 text-xs font-semibold uppercase tracking-wider bg-indigo-500/10 px-3 py-1 rounded-full border border-indigo-500/20">
                    Sistem E-Office
                </span>
                <h2 class="mt-3 text-3xl font-extrabold text-white tracking-tight">
                    Selamat Datang di Portal Utama Admin
                </h2>
                <p class="mt-2 text-slate-400 max-w-xl text-sm leading-relaxed">
                    Kelola data pengguna, konfigurasi bidang divisi, dan pantau aktivitas surat dengan kendali penuh.
                </p>
            </div>
            
            <div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-indigo-300 bg-indigo-500/10 border border-indigo-500/20 rounded-full">
                    <span class="w-1.5 h-1.5 bg-indigo-400 rounded-full animate-ping"></span>
                    Sistem Online
                </span>
            </div>
        </div>
    </div>

    <!-- Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Card: Total User -->
        <div class="group relative overflow-hidden rounded-2xl bg-white p-6 shadow-sm border border-slate-200/60 transition-all duration-300 hover:-translate-y-1 hover:shadow-md hover:border-indigo-500/30">
            <div class="absolute right-0 top-0 w-24 h-24 bg-gradient-to-br from-indigo-500/5 to-transparent rounded-bl-full transition-all duration-300 group-hover:scale-110"></div>
            
            <div class="flex items-start justify-between">
                <div class="space-y-4">
                    <div class="p-3 bg-indigo-50 rounded-xl w-fit border border-indigo-100/50">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-500 uppercase tracking-wider">Total User</p>
                        <h3 class="text-3xl font-extrabold text-slate-800 mt-1 group-hover:text-indigo-600 transition-colors">
                            {{ $totalUser }}
                        </h3>
                    </div>
                </div>
                <span class="text-[10px] font-bold text-indigo-600 bg-indigo-50 px-2.5 py-1 rounded-full uppercase tracking-wider">
                    Pengguna
                </span>
            </div>

            <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between">
                <span class="text-xs text-slate-400">Terintegrasi dalam sistem</span>
                <a href="{{ route('user.index') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800 flex items-center gap-1 transition-all group-hover:translate-x-0.5">
                    Kelola User
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
            </div>
        </div>

        <!-- Card: Total Bidang -->
        <div class="group relative overflow-hidden rounded-2xl bg-white p-6 shadow-sm border border-slate-200/60 transition-all duration-300 hover:-translate-y-1 hover:shadow-md hover:border-purple-500/30">
            <div class="absolute right-0 top-0 w-24 h-24 bg-gradient-to-br from-purple-500/5 to-transparent rounded-bl-full transition-all duration-300 group-hover:scale-110"></div>
            
            <div class="flex items-start justify-between">
                <div class="space-y-4">
                    <div class="p-3 bg-purple-50 rounded-xl w-fit border border-purple-100/50">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-500 uppercase tracking-wider">Total Bidang</p>
                        <h3 class="text-3xl font-extrabold text-slate-800 mt-1 group-hover:text-purple-600 transition-colors">
                            {{ $totalBidang }}
                        </h3>
                    </div>
                </div>
                <span class="text-[10px] font-bold text-purple-600 bg-purple-50 px-2.5 py-1 rounded-full uppercase tracking-wider">
                    Divisi
                </span>
            </div>

            <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between">
                <span class="text-xs text-slate-400">Unit kerja organisasi</span>
                <a href="{{ route('bidang.index') }}" class="text-xs font-semibold text-purple-600 hover:text-purple-800 flex items-center gap-1 transition-all group-hover:translate-x-0.5">
                    Kelola Bidang
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
            </div>
        </div>

        <!-- Card: Total Surat -->
        <div class="group relative overflow-hidden rounded-2xl bg-white p-6 shadow-sm border border-slate-200/60 transition-all duration-300 hover:-translate-y-1 hover:shadow-md hover:border-emerald-500/30">
            <div class="absolute right-0 top-0 w-24 h-24 bg-gradient-to-br from-emerald-500/5 to-transparent rounded-bl-full transition-all duration-300 group-hover:scale-110"></div>
            
            <div class="flex items-start justify-between">
                <div class="space-y-4">
                    <div class="p-3 bg-emerald-50 rounded-xl w-fit border border-emerald-100/50">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 19v-8.93a2 2 0 01.89-1.664l8-5.333a2 2 0 012.22 0l8 5.333A2 2 0 0121 10.07V19M3 19a2 2 0 002 2h14a2 2 0 002-2M3 19l6.75-4.5M21 19l-6.75-4.5M3 10l6.75 4.5M21 10l-6.75 4.5m0 0l-1.14.76a2 2 0 01-2.22 0l-1.14-.76"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-500 uppercase tracking-wider">Total Surat</p>
                        <h3 class="text-3xl font-extrabold text-slate-800 mt-1 group-hover:text-emerald-600 transition-colors">
                            0
                        </h3>
                    </div>
                </div>
                <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2.5 py-1 rounded-full uppercase tracking-wider">
                    Arsip
                </span>
            </div>

            <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between">
                <span class="text-xs text-slate-400">Dokumen surat e-office</span>
                <span class="text-xs font-semibold text-slate-400 flex items-center gap-1">
                    Belum Tersedia
                </span>
            </div>
        </div>
    </div>

    <!-- Quick Links Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Quick Action Menu -->
        <div class="lg:col-span-2 rounded-2xl bg-white p-6 shadow-sm border border-slate-200/60">
            <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                <span class="w-1.5 h-5 bg-indigo-500 rounded-full"></span>
                Akses Cepat Admin
            </h3>
            
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <a href="{{ route('user.create') }}" class="flex items-center gap-4 p-4 rounded-xl border border-slate-100 hover:bg-slate-50 transition-all group">
                    <div class="p-3 bg-blue-50 rounded-xl text-blue-600 group-hover:scale-105 transition-transform">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-semibold text-slate-850 group-hover:text-blue-600 transition-colors">Tambah User</h4>
                        <p class="text-xs text-slate-400 mt-0.5">Daftarkan akun baru.</p>
                    </div>
                </a>

                <a href="{{ route('bidang.create') }}" class="flex items-center gap-4 p-4 rounded-xl border border-slate-100 hover:bg-slate-50 transition-all group">
                    <div class="p-3 bg-purple-50 rounded-xl text-purple-600 group-hover:scale-105 transition-transform">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-semibold text-slate-850 group-hover:text-purple-600 transition-colors">Tambah Bidang</h4>
                        <p class="text-xs text-slate-400 mt-0.5">Buat divisi baru.</p>
                    </div>
                </a>

                <form method="POST" action="{{ route('logout') }}" class="h-full">
                    @csrf
                    <button type="submit" class="w-full h-full flex items-center gap-4 p-4 rounded-xl border border-slate-100 hover:bg-rose-50/50 transition-all group text-left">
                        <div class="p-3 bg-rose-50 rounded-xl text-rose-600 group-hover:scale-105 transition-transform">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-sm font-semibold text-slate-850 group-hover:text-rose-600 transition-colors">Logout</h4>
                            <p class="text-xs text-slate-400 mt-0.5">Keluar dari sesi.</p>
                        </div>
                    </button>
                </form>
            </div>
        </div>

        <!-- Info System Status -->
        <div class="rounded-2xl bg-white p-6 shadow-sm border border-slate-200/60">
            <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                <span class="w-1.5 h-5 bg-indigo-500 rounded-full"></span>
                Status Sistem
            </h3>
            
            <div class="space-y-4">
                <div class="flex items-center justify-between text-xs py-2.5 border-b border-slate-100">
                    <span class="text-slate-400">Laravel Version</span>
                    <span class="font-semibold text-slate-750">v{{ app()->version() }}</span>
                </div>
                <div class="flex items-center justify-between text-xs py-2.5 border-b border-slate-100">
                    <span class="text-slate-400">PHP Version</span>
                    <span class="font-semibold text-slate-750">v{{ phpversion() }}</span>
                </div>
                <div class="flex items-center justify-between text-xs py-2.5">
                    <span class="text-slate-400">Driver DB</span>
                    <span class="font-semibold text-slate-750 uppercase">{{ config('database.default') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection