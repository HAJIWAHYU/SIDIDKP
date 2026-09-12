@extends('layouts.app')

@section('content')
<div class="space-y-6 max-w-7xl mx-auto">
    <!-- Header Page -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <a href="{{ route('surat.index') }}" class="inline-flex items-center gap-1 text-xs text-indigo-650 hover:text-indigo-800 transition-colors font-medium">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali ke Daftar Surat
            </a>
            <h2 class="text-2xl font-bold text-slate-800 mt-2">Detail Dokumen Surat</h2>
        </div>
    </div>

    <!-- Main Grid: Split Screen Details & Preview -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <!-- Left Side: Details (span 7) -->
        <div class="lg:col-span-7 flex flex-col">
            <div class="bg-white rounded-2xl border border-slate-200/60 shadow-sm overflow-hidden flex-1 flex flex-col justify-between">
                <div>
                    <!-- Header Info -->
                    <div class="p-6 bg-slate-50/50 border-b border-slate-100 grid grid-cols-1 sm:grid-cols-3 gap-6">
                        <!-- Pengirim -->
                        <div>
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Pengirim</span>
                            <span class="text-sm font-semibold text-slate-805 block mt-1">{{ $surat->pengirim->name }}</span>
                            <span class="text-xs text-slate-500 block mt-0.5">{{ $surat->pengirim->bidang->nama_bidang ?? 'Tanpa Bidang' }}</span>
                        </div>

                        <!-- Penerima -->
                        <div>
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Penerima</span>
                            <span class="text-sm font-semibold text-slate-805 block mt-1">{{ $surat->penerima->name }}</span>
                            <span class="text-xs text-slate-500 block mt-0.5">{{ $surat->penerima->bidang->nama_bidang ?? 'Tanpa Bidang' }}</span>
                        </div>

                        <!-- Waktu Kirim & Status -->
                        <div>
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Waktu Pengiriman</span>
                            <span class="text-xs font-semibold text-slate-805 block mt-1">
                                {{ $surat->created_at->format('d M Y, H:i') }} WIB
                            </span>
                            
                            <span class="inline-flex items-center gap-1.5 mt-2">
                                @if($surat->is_read)
                                    <span class="w-2 h-2 bg-emerald-500 rounded-full"></span>
                                    <span class="text-[10px] font-bold text-emerald-600 uppercase tracking-wider">Sudah Dibaca</span>
                                @else
                                    <span class="w-2 h-2 bg-amber-500 rounded-full"></span>
                                    <span class="text-[10px] font-bold text-amber-600 uppercase tracking-wider">Belum Dibaca</span>
                                @endif
                            </span>
                        </div>
                    </div>

                    <!-- Body / Content -->
                    <div class="p-6 space-y-6">
                        <!-- Nomor Surat & Perihal -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @php
                                $nomorSurat = '-';
                                $perihalText = $surat->perihal;
                                if (preg_match('/^\[(.*?)\]\s*(.*)$/', $surat->perihal, $matches)) {
                                    $nomorSurat = $matches[1];
                                    $perihalText = $matches[2];
                                }
                            @endphp
                            <div>
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Nomor Surat</span>
                                <h3 class="text-sm font-semibold text-slate-805 mt-1 leading-snug">
                                    {{ $nomorSurat }}
                                </h3>
                            </div>
                            <div>
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Perihal</span>
                                <h3 class="text-sm font-semibold text-slate-805 mt-1 leading-snug">
                                    {{ $perihalText }}
                                </h3>
                            </div>
                        </div>

                        <!-- Info Detail Surat Baru -->
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 pt-4 border-t border-slate-100">
                            <!-- Surat Dari -->
                            <div>
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Surat Dari</span>
                                <span class="text-xs font-semibold text-slate-800 block mt-1">
                                    {{ $surat->surat_dari ?? '-' }}
                                </span>
                            </div>

                            <!-- Tanggal Surat -->
                            <div>
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Tanggal Surat</span>
                                <span class="text-xs font-semibold text-slate-800 block mt-1">
                                    {{ $surat->tanggal_surat ? \Carbon\Carbon::parse($surat->tanggal_surat)->format('d M Y') : '-' }}
                                </span>
                            </div>

                            <!-- No. Agenda -->
                            <div>
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block">No. Agenda</span>
                                <span class="text-xs font-semibold text-slate-800 block mt-1">
                                    {{ $surat->no_agenda ?? '-' }}
                                </span>
                            </div>

                            <!-- Sifat Surat -->
                            <div>
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-1">Sifat Surat</span>
                                @php
                                    $sifatColor = 'bg-slate-50 text-slate-650 border-slate-150';
                                    if ($surat->sifat === 'Penting') {
                                        $sifatColor = 'bg-rose-50 text-rose-600 border-rose-100';
                                    } elseif ($surat->sifat === 'Segera') {
                                        $sifatColor = 'bg-amber-50 text-amber-600 border-amber-100';
                                    } elseif ($surat->sifat === 'Amat Segera') {
                                        $sifatColor = 'bg-red-50 text-red-650 border-red-150';
                                    } elseif ($surat->sifat === 'Biasa') {
                                        $sifatColor = 'bg-sky-50 text-sky-600 border-sky-100';
                                    }
                                @endphp
                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-bold border {{ $sifatColor }}">
                                    {{ $surat->sifat ?? '-' }}
                                </span>
                            </div>
                        </div>

                        <!-- Isi Surat -->
                        <div class="pt-4 border-t border-slate-100">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider block mb-2">Disposisi</span>
                            <div class="text-xs text-slate-700 leading-relaxed bg-slate-50/30 rounded-xl p-5 border border-slate-100 whitespace-pre-wrap font-sans">{{ $surat->isi }}</div>
                        </div>
                    </div>
                </div>

                <!-- Footer Download Area -->
                @if($surat->file)
                    <div class="p-6 border-t border-slate-100 bg-slate-50/30">
                        <div class="flex flex-col sm:flex-row gap-4 items-center justify-between p-4 rounded-xl border border-slate-200/80 bg-white shadow-sm">
                            <div class="flex items-center gap-3 overflow-hidden w-full sm:w-auto">
                                <div class="p-2.5 bg-rose-50 text-rose-600 rounded-lg shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div class="overflow-hidden">
                                    <h4 class="text-xs font-semibold text-slate-800 truncate max-w-[200px] sm:max-w-xs">
                                        {{ basename($surat->file) }}
                                    </h4>
                                    <p class="text-[9px] text-slate-400 mt-0.5">Dokumen Resmi E-Office</p>
                                </div>
                            </div>
                            
                            <a href="{{ route('surat.download', $surat->id) }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-1.5 px-4 py-2 bg-indigo-600 hover:bg-indigo-750 text-white text-xs font-semibold rounded-lg shadow-sm transition-colors shrink-0">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                </svg>
                                Unduh Berkas
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Right Side: PDF Preview (span 5) -->
        <div class="lg:col-span-5 flex flex-col">
            <div class="bg-indigo-50/30 border border-slate-200/60 rounded-2xl shadow-sm p-6 flex-1 flex flex-col justify-between min-h-[500px]">
                <!-- Preview Header -->
                <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100 shrink-0">
                    <h3 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        Pratinjau Dokumen
                    </h3>
                    @if($surat->file)
                        <a href="{{ asset('storage/' . $surat->file) }}" target="_blank" class="text-xs text-indigo-650 hover:text-indigo-850 font-bold flex items-center gap-1 transition-colors">
                            Tab Baru
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                        </a>
                    @endif
                </div>

                <!-- Preview Area -->
                <div class="flex-1 flex flex-col">
                    @if($surat->file && strtolower(pathinfo($surat->file, PATHINFO_EXTENSION)) === 'pdf')
                        <div class="w-full flex-1 min-h-[500px] border border-slate-200 rounded-2xl bg-white shadow-inner overflow-y-auto flex flex-col items-center justify-start p-3 relative">
                            <!-- Canvas for Mobile & Universal HTML5 Rendering -->
                            <canvas id="pdf-render-canvas" class="max-w-full h-auto shadow-md rounded-xl border border-slate-100"></canvas>
                            
                            <!-- Fallback Button if Canvas/PDF.js fails -->
                            <div id="pdf-fallback-mobile" class="hidden text-center p-6 my-auto">
                                <div class="w-12 h-12 mx-auto mb-3 bg-indigo-50 text-indigo-600 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <h4 class="text-xs font-bold text-slate-700 mb-1">Pratinjau PDF di Layar HP</h4>
                                <p class="text-[10px] text-slate-400 mb-4 leading-relaxed">
                                    Tekan tombol di bawah untuk membuka dan membaca dokumen secara penuh.
                                </p>
                                <a href="{{ asset('storage/' . $surat->file) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2.5 bg-indigo-600 text-white rounded-xl text-xs font-bold shadow-md hover:bg-indigo-700 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                    </svg>
                                    Buka Dokumen PDF
                                </a>
                            </div>
                        </div>

                        <!-- PDF.js script for cross-device canvas rendering -->
                        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.4.120/pdf.min.js"></script>
                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                const pdfUrl = "{{ asset('storage/' . $surat->file) }}";
                                pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.4.120/pdf.worker.min.js';

                                const canvas = document.getElementById('pdf-render-canvas');
                                if (!canvas) return;
                                const ctx = canvas.getContext('2d');

                                pdfjsLib.getDocument(pdfUrl).promise.then(function (pdf) {
                                    pdf.getPage(1).then(function (page) {
                                        const scale = window.innerWidth < 640 ? 0.8 : 1.2;
                                        const viewport = page.getViewport({ scale: scale });
                                        canvas.height = viewport.height;
                                        canvas.width = viewport.width;

                                        const renderContext = {
                                            canvasContext: ctx,
                                            viewport: viewport
                                        };
                                        page.render(renderContext);
                                    });
                                }).catch(function (err) {
                                    console.error('PDF Render Error:', err);
                                    canvas.classList.add('hidden');
                                    document.getElementById('pdf-fallback-mobile').classList.remove('hidden');
                                });
                            });
                        </script>
                    @else
                        <!-- Fallback empty state -->
                        <div class="flex-1 flex flex-col items-center justify-center text-center space-y-4 max-w-xs mx-auto py-8">
                            <div class="mx-auto w-24 h-32 bg-white rounded-xl shadow-sm border border-slate-100 flex items-center justify-center relative overflow-hidden">
                                <div class="absolute inset-x-0 top-0 h-2 bg-slate-350"></div>
                                <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-slate-700">Tidak ada lampiran PDF</h4>
                                <p class="text-[10px] text-slate-400 mt-1 leading-relaxed">
                                    Tidak ada file PDF pendukung yang dapat ditampilkan di panel ini.
                                </p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
