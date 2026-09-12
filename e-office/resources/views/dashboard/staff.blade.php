@extends('layouts.app')

@section('content')
<div class="space-y-8">
    <!-- Welcome Banner -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-slate-900 via-blue-950 to-slate-900 p-8 shadow-lg border border-slate-800">
        <div class="absolute -right-10 -top-10 w-40 h-40 bg-blue-500/10 rounded-full blur-3xl"></div>
        <div class="absolute -left-10 -bottom-10 w-40 h-40 bg-indigo-500/10 rounded-full blur-3xl"></div>
        
        <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <span class="text-blue-400 text-xs font-semibold uppercase tracking-wider bg-blue-500/10 px-3 py-1 rounded-full border border-blue-500/20">
                    Staff Panel
                </span>
                <h2 class="mt-3 text-3xl font-extrabold text-white tracking-tight">
                    Selamat Datang, {{ auth()->user()->name }}
                </h2>
                <p class="mt-2 text-slate-400 max-w-xl text-sm leading-relaxed">
                    Lihat instruksi kerja, surat tugas, dan dokumen dinas masuk yang ditujukan kepada Anda dari atasan.
                </p>
            </div>
            
            <div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-blue-300 bg-blue-500/10 border border-blue-500/20 rounded-full">
                    <span class="w-1.5 h-1.5 bg-blue-450 rounded-full animate-ping"></span>
                    Sistem Aktif
                </span>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        
        <!-- Card 1: Surat Baru (Unread) -->
        <div class="group relative overflow-hidden rounded-2xl bg-white p-6 shadow-sm border border-slate-200/60 transition-all duration-300 hover:-translate-y-1 hover:shadow-md hover:border-amber-500/30">
            <div class="absolute right-0 top-0 w-24 h-24 bg-gradient-to-br from-amber-500/5 to-transparent rounded-bl-full transition-all duration-300 group-hover:scale-110"></div>
            
            <div class="flex items-start justify-between">
                <div class="space-y-4">
                    <div class="p-3 bg-amber-50 rounded-xl w-fit border border-amber-100/50">
                        <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-500 uppercase tracking-wider">Surat Masuk Baru</p>
                        <h3 class="text-3xl font-extrabold text-slate-800 mt-1 group-hover:text-amber-650 transition-colors">
                            {{ $suratMasukBelumDibaca }}
                        </h3>
                    </div>
                </div>
                <span class="text-[10px] font-bold text-amber-700 bg-amber-50 px-2.5 py-1 rounded-full uppercase tracking-wider">
                    Unread
                </span>
            </div>

            <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between">
                <span class="text-xs text-slate-400">Butuh segera dibaca & ditindaklanjuti</span>
                <a href="{{ route('surat.index') }}" class="text-xs font-semibold text-amber-600 hover:text-amber-700 transition-colors flex items-center gap-1">
                    Lihat Inbox
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </a>
            </div>
        </div>

        <!-- Card 2: Total Surat Masuk -->
        <div class="group relative overflow-hidden rounded-2xl bg-white p-6 shadow-sm border border-slate-200/60 transition-all duration-300 hover:-translate-y-1 hover:shadow-md hover:border-blue-500/30">
            <div class="absolute right-0 top-0 w-24 h-24 bg-gradient-to-br from-blue-500/5 to-transparent rounded-bl-full transition-all duration-300 group-hover:scale-110"></div>
            
            <div class="flex items-start justify-between">
                <div class="space-y-4">
                    <div class="p-3 bg-blue-50 rounded-xl w-fit border border-blue-100/50">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 19v-8.93a2 2 0 01.89-1.664l8-5.333a2 2 0 012.22 0l8 5.333A2 2 0 0121 10.07V19M3 19a2 2 0 002 2h14a2 2 0 002-2M3 19l6.75-4.5M21 19l-6.75-4.5M3 10l6.75 4.5M21 10l-6.75 4.5m0 0l-2.25-1.5a2 2 0 00-2.22 0l-2.25 1.5M12 14v2m-3 0h6"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-500 uppercase tracking-wider">Total Surat Diterima</p>
                        <h3 class="text-3xl font-extrabold text-slate-800 mt-1 group-hover:text-blue-600 transition-colors">
                            {{ $totalSuratMasuk }}
                        </h3>
                    </div>
                </div>
                <span class="text-[10px] font-bold text-blue-600 bg-blue-50 px-2.5 py-1 rounded-full uppercase tracking-wider">
                    Total
                </span>
            </div>

            <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between">
                <span class="text-xs text-slate-400">Total arsip seluruh surat masuk</span>
                <span class="text-xs font-semibold text-slate-500">
                    {{ $totalSuratMasuk }} Arsip
                </span>
            </div>
        </div>

    </div>

    <!-- Recent Letters & Role Info Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Recent Letters -->
        <div class="lg:col-span-2 rounded-2xl bg-white p-6 shadow-sm border border-slate-200/60">
            <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                <span class="w-1.5 h-5 bg-blue-500 rounded-full"></span>
                Surat Masuk Terkini
            </h3>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr class="border-b border-slate-100 text-slate-400 font-semibold uppercase tracking-wider">
                            <th class="py-2.5 px-3">Pengirim</th>
                            <th class="py-2.5 px-3">Nomor Surat</th>
                            <th class="py-2.5 px-3">Perihal</th>
                            <th class="py-2.5 px-3">Status</th>
                            <th class="py-2.5 px-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @forelse($recentSurats as $s)
                            @php
                                $nomorSurat = '-';
                                $perihalText = $s->perihal;
                                if (preg_match('/^\[(.*?)\]\s*(.*)$/', $s->perihal, $matches)) {
                                    $nomorSurat = $matches[1];
                                    $perihalText = $matches[2];
                                }
                            @endphp
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="py-3 px-3">
                                    <div class="font-semibold text-slate-800">{{ $s->pengirim->name }}</div>
                                    <div class="text-[10px] text-slate-400">{{ $s->pengirim->bidang->nama_bidang ?? 'Tanpa Bidang' }}</div>
                                </td>
                                <td class="py-3 px-3 font-semibold text-slate-600 max-w-[150px] truncate">{{ $nomorSurat }}</td>
                                <td class="py-3 px-3 font-semibold text-slate-800 max-w-[200px] truncate">{{ $perihalText }}</td>
                                <td class="py-3 px-3">
                                    @if($s->is_read)
                                        <span class="text-[9px] font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">
                                            Dibaca
                                        </span>
                                    @else
                                        <span class="text-[9px] font-bold text-amber-600 bg-amber-50 px-2 py-0.5 rounded-full animate-pulse">
                                            Baru
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3 px-3 text-center">
                                    <a href="{{ route('surat.show', $s->id) }}" class="inline-flex items-center px-2 py-1 bg-indigo-50 hover:bg-indigo-100 text-indigo-600 font-bold rounded transition-colors text-[10px]">
                                        Buka
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-slate-400 italic">
                                    Belum ada surat masuk dinas yang diterima.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Role Security Card -->
        <div class="rounded-2xl bg-white p-6 shadow-sm border border-slate-200/60 flex flex-col justify-between">
            <div>
                <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                    <span class="w-1.5 h-5 bg-rose-500 rounded-full"></span>
                    Informasi Tugas
                </h3>
                
                <p class="text-xs text-slate-500 leading-relaxed">
                    Sebagai pengguna dengan peran <strong>Staff</strong>, Anda berada di bawah wewenang <strong>{{ auth()->user()->bidang->nama_bidang ?? 'Tanpa Bidang' }}</strong>.
                </p>
                <p class="text-xs text-slate-500 leading-relaxed mt-2">
                    Hak akses Anda diatur untuk <strong>Hanya Menerima Surat</strong>. Anda dapat melihat, membaca, dan mengunduh berkas lampiran surat dinas masuk tetapi tidak memiliki otoritas untuk mengirim surat keluar baru.
                </p>
            </div>
            
            <div class="mt-6 pt-4 border-t border-slate-100 space-y-2">
                <div class="flex items-center justify-between text-[11px]">
                    <span class="text-slate-400">Bidang Anda:</span>
                    <span class="font-semibold text-slate-700">{{ auth()->user()->bidang->nama_bidang ?? 'Belum Diatur' }}</span>
                </div>
                <div class="flex items-center justify-between text-[11px]">
                    <span class="text-slate-400">Hak Akses:</span>
                    <span class="px-1.5 py-0.5 bg-blue-100 text-blue-800 font-bold rounded uppercase tracking-wider text-[9px]">
                        {{ auth()->user()->role }}
                    </span>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
