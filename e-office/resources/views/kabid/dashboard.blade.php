@extends('layouts.app')

@section('content')
<div class="space-y-8">
    <!-- Welcome Banner -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-slate-900 via-purple-950 to-slate-900 p-8 shadow-lg border border-slate-800">
        <div class="absolute -right-10 -top-10 w-40 h-40 bg-purple-500/10 rounded-full blur-3xl"></div>
        <div class="absolute -left-10 -bottom-10 w-40 h-40 bg-pink-500/10 rounded-full blur-3xl"></div>
        
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <span class="text-purple-400 text-xs font-semibold uppercase tracking-wider bg-purple-500/10 px-3 py-1 rounded-full border border-purple-500/20">
                    {{ auth()->user()->role == 'kasi' ? 'Kepala Seksi Panel' : 'Kepala Bidang Panel' }}
                </span>
                <h2 class="mt-3 text-3xl font-extrabold text-white tracking-tight">
                    Selamat Datang, {{ auth()->user()->name }}
                </h2>
                <p class="mt-2 text-slate-300 max-w-xl text-sm leading-relaxed">
                    Kelola disposisi, dan koordinasikan seluruh arsip dokumen Anda secara efisien.
                </p>
            </div>
            
            <div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-purple-300 bg-purple-500/10 border border-purple-500/20 rounded-full">
                    <span class="w-1.5 h-1.5 bg-purple-450 rounded-full animate-ping"></span>
                    Bidang Aktif
                </span>
            </div>
        </div>
    </div>

    <!-- Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Card: Surat Masuk -->
        <div class="group relative overflow-hidden rounded-2xl bg-white p-6 shadow-sm border border-slate-200/60 transition-all duration-300 hover:-translate-y-1 hover:shadow-md hover:border-indigo-500/30">
            <div class="absolute right-0 top-0 w-24 h-24 bg-gradient-to-br from-indigo-500/5 to-transparent rounded-bl-full transition-all duration-300 group-hover:scale-110"></div>
            
            <div class="flex items-start justify-between">
                <div class="space-y-4">
                    <div class="p-3 bg-indigo-50 rounded-xl w-fit border border-indigo-100/50">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13a2 2 0 012 2v9m-18 3h18a2 2 0 002-2V6a2 2 0 00-2-2H3a2 2 0 00-2 2v10a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-500 uppercase tracking-wider">Surat Masuk</p>
                        <h3 class="text-3xl font-extrabold text-slate-800 mt-1 group-hover:text-indigo-600 transition-colors">
                            {{ $totalSuratMasuk }}
                        </h3>
                    </div>
                </div>
                <span class="text-[10px] font-bold text-indigo-600 bg-indigo-50 px-2.5 py-1 rounded-full uppercase tracking-wider">
                    Inbox
                </span>
            </div>

            <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between">
                <span class="text-xs text-slate-400">Butuh disposisi & review</span>
                <a href="{{ route('surat.index') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-850 flex items-center gap-1 transition-all group-hover:translate-x-0.5">
                    Lihat Inbox
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
            </div>
        </div>

        <!-- Card: Surat Keluar -->
        <div class="group relative overflow-hidden rounded-2xl bg-white p-6 shadow-sm border border-slate-200/60 transition-all duration-300 hover:-translate-y-1 hover:shadow-md hover:border-purple-500/30">
            <div class="absolute right-0 top-0 w-24 h-24 bg-gradient-to-br from-purple-500/5 to-transparent rounded-bl-full transition-all duration-300 group-hover:scale-110"></div>
            
            <div class="flex items-start justify-between">
                <div class="space-y-4">
                    <div class="p-3 bg-purple-50 rounded-xl w-fit border border-purple-100/50">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-500 uppercase tracking-wider">Surat Keluar</p>
                        <h3 class="text-3xl font-extrabold text-slate-800 mt-1 group-hover:text-purple-600 transition-colors">
                            {{ $totalSuratKeluar }}
                        </h3>
                    </div>
                </div>
                <span class="text-[10px] font-bold text-purple-600 bg-purple-50 px-2.5 py-1 rounded-full uppercase tracking-wider">
                    Sent
                </span>
            </div>

            <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between">
                <span class="text-xs text-slate-400">Arsip surat keluar bidang</span>
                <a href="{{ route('surat.index') }}" class="text-xs font-semibold text-purple-600 hover:text-purple-850 flex items-center gap-1 transition-all group-hover:translate-x-0.5">
                    Lihat Sent
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Quick Action / Activities -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Quick Actions -->
        <div class="lg:col-span-2 rounded-2xl bg-white p-6 shadow-sm border border-slate-200/60">
            <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                <span class="w-1.5 h-5 bg-purple-500 rounded-full"></span>
                Akses Cepat {{ auth()->user()->role == 'kasi' ? 'Kasi' : 'Kabid' }}
            </h3>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <a href="{{ route('surat.create') }}" class="flex items-center gap-4 p-4 rounded-xl border border-slate-100 hover:bg-slate-50 transition-all group">
                    <div class="p-3 bg-purple-50 rounded-xl text-purple-600 group-hover:scale-105 transition-transform">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-sm font-semibold text-slate-850 group-hover:text-purple-600 transition-colors">Buat Disposisi</h4>
                        <p class="text-xs text-slate-400 mt-0.5">Tulis disposisi baru untuk staff.</p>
                    </div>
                </a>
            </div>
        </div>

        <!-- Bidang Info -->
        <div class="rounded-2xl bg-white p-6 shadow-sm border border-slate-200/60">
            <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                <span class="w-1.5 h-5 bg-purple-500 rounded-full"></span>
                Informasi Bidang
            </h3>
            
            <div class="space-y-4">
                <div class="flex items-center justify-between text-xs py-2.5 border-b border-slate-100">
                    <span class="text-slate-400">Nama Bidang</span>
                    <span class="font-semibold text-slate-750">{{ auth()->user()->bidang->nama_bidang ?? 'Tidak Terikat Bidang' }}</span>
                </div>
                <div class="flex items-center justify-between text-xs py-2.5 border-b border-slate-100">
                    <span class="text-slate-400">{{ auth()->user()->role == 'kasi' ? 'Kepala Seksi' : 'Kepala Bidang' }}</span>
                    <span class="font-semibold text-slate-750">{{ auth()->user()->name }}</span>
                </div>
                <div class="flex items-center justify-between text-xs py-2.5">
                    <span class="text-slate-400">Hak Akses</span>
                    <span class="px-2 py-0.5 bg-purple-100 text-purple-700 rounded font-semibold text-[10px] uppercase tracking-wider">
                        {{ auth()->user()->role }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection