@extends('layouts.app')

@section('content')
<div class="space-y-6 max-w-7xl mx-auto">
    <!-- Breadcrumb & Header Page -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <nav class="flex text-xs font-semibold text-slate-450 uppercase tracking-wider mb-2" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2">
                    <li class="inline-flex items-center">
                        <a href="{{ route('dashboard') }}" class="hover:text-indigo-600 transition-colors">Dashboard</a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-3.5 h-3.5 text-slate-400 mx-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                            <span class="text-slate-500 font-medium">Buat Disposisi</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <h2 class="text-2xl font-bold text-slate-800">
                @if(auth()->user()->role === 'kabid' || auth()->user()->role === 'kasi')
                    Buat Disposisi Baru
                @else
                    Tulis Surat Baru
                @endif
            </h2>
        </div>
    </div>

    <!-- Main Grid: Split Screen Form & Preview -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-stretch">
        
        <!-- Left Side: Form (span 7) -->
        <div class="lg:col-span-7 flex flex-col">
            <div class="bg-white rounded-2xl border border-slate-200/60 shadow-sm p-6 flex-1 flex flex-col">
                <!-- Form Header -->
                <h3 class="text-base font-bold text-slate-800 mb-6 flex items-center gap-2.5 pb-4 border-b border-slate-100">
                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Informasi Surat & Disposisi
                </h3>

                <form action="{{ route('surat.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6 flex-1 flex flex-col justify-between">
                    @csrf

                    <div class="space-y-5">
                        <!-- File Upload: Drag & Drop Zone -->
                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block">
                                Dokumen Pendukung (PDF)
                            </label>
                            
                            <div id="drop-zone" class="border-2 border-dashed border-slate-200 hover:border-indigo-500 rounded-2xl p-6 text-center hover:bg-slate-50/50 transition-all relative cursor-pointer group">
                                <input type="file" id="file-input" name="file" accept="application/pdf" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" required>
                                
                                <div id="upload-prompt" class="space-y-3">
                                    <div class="mx-auto w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center text-slate-400 group-hover:bg-indigo-50 group-hover:text-indigo-500 transition-colors">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                        </svg>
                                    </div>
                                    <div class="text-xs text-slate-600">
                                        Tarik dan lepas file di sini, atau <span class="text-indigo-600 font-semibold group-hover:text-indigo-700 transition-colors">Pilih File</span>
                                    </div>
                                    <div class="text-[10px] text-slate-400">
                                        Maksimal ukuran file: 10MB (Format: PDF)
                                    </div>
                                </div>

                                <!-- File Selected Info (Hidden by default) -->
                                <div id="file-info" class="hidden flex items-center justify-between bg-indigo-50/60 border border-indigo-100 rounded-xl p-3 text-left">
                                    <div class="flex items-center gap-2.5 overflow-hidden">
                                        <div class="p-2 bg-indigo-500 rounded-lg text-white shrink-0">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                        <div class="overflow-hidden">
                                            <p id="file-name" class="text-xs font-semibold text-slate-750 truncate"></p>
                                            <p id="file-size" class="text-[10px] text-slate-400 mt-0.5"></p>
                                        </div>
                                    </div>
                                    <button type="button" id="btn-remove-file" class="p-1.5 hover:bg-indigo-100 rounded-lg text-slate-400 hover:text-rose-500 transition-colors z-20 relative">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            @error('file')
                                <p class="text-xs text-rose-500 mt-1 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Grid: Nomor Surat & Perihal -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Nomor Surat -->
                            <div class="space-y-1.5">
                                <label for="nomor_surat" class="text-xs font-bold text-slate-500 uppercase tracking-wider block">
                                    Nomor Surat
                                </label>
                                <input type="text" id="nomor_surat" name="nomor_surat" value="{{ old('nomor_surat') }}" placeholder="Contoh: 005/123/DKP-2024" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-xs text-slate-700 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all">
                                @error('nomor_surat')
                                    <p class="text-xs text-rose-500 mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Perihal -->
                            <div class="space-y-1.5">
                                <label for="perihal" class="text-xs font-bold text-slate-500 uppercase tracking-wider block">
                                    Perihal
                                </label>
                                <input type="text" id="perihal" name="perihal" value="{{ old('perihal') }}" required placeholder="Isi perihal surat" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-xs text-slate-700 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all">
                                @error('perihal')
                                    <p class="text-xs text-rose-500 mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Grid: Surat Dari, Tanggal Surat, No. Agenda, Sifat -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Surat Dari -->
                            <div class="space-y-1.5">
                                <label for="surat_dari" class="text-xs font-bold text-slate-500 uppercase tracking-wider block">
                                    Surat Dari
                                </label>
                                <input type="text" id="surat_dari" name="surat_dari" value="{{ old('surat_dari') }}" placeholder="Contoh: Dinas Pendidikan / Nama Pengirim" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-xs text-slate-700 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all">
                                @error('surat_dari')
                                    <p class="text-xs text-rose-500 mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Tanggal Surat -->
                            <div class="space-y-1.5">
                                <label for="tanggal_surat" class="text-xs font-bold text-slate-500 uppercase tracking-wider block">
                                    Tanggal Surat <span class="text-rose-500">*</span>
                                </label>
                                <input type="date" id="tanggal_surat" name="tanggal_surat" value="{{ old('tanggal_surat', date('Y-m-d')) }}" required class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-xs text-slate-700 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all">
                                @error('tanggal_surat')
                                    <p class="text-xs text-rose-500 mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- No. Agenda -->
                            <div class="space-y-1.5">
                                <label for="no_agenda" class="text-xs font-bold text-slate-500 uppercase tracking-wider block">
                                    No. Agenda
                                </label>
                                <input type="text" id="no_agenda" name="no_agenda" value="{{ old('no_agenda') }}" placeholder="Contoh: 001/CAD" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-xs text-slate-700 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all">
                                @error('no_agenda')
                                    <p class="text-xs text-rose-500 mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Sifat -->
                            <div class="space-y-1.5">
                                <label for="sifat" class="text-xs font-bold text-slate-500 uppercase tracking-wider block">
                                    Sifat Surat
                                </label>
                                <select id="sifat" name="sifat" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-xs text-slate-700 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all">
                                    <option value="">-- Pilih Sifat Surat --</option>
                                    <option value="Biasa" {{ old('sifat') === 'Biasa' ? 'selected' : '' }}>Biasa</option>
                                    <option value="Penting" {{ old('sifat') === 'Penting' ? 'selected' : '' }}>Penting</option>
                                    <option value="Segera" {{ old('sifat') === 'Segera' ? 'selected' : '' }}>Segera</option>
                                    <option value="Amat Segera" {{ old('sifat') === 'Amat Segera' ? 'selected' : '' }}>Amat Segera</option>
                                </select>
                                @error('sifat')
                                    <p class="text-xs text-rose-500 mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Instruksi Disposisi -->
                        <div class="space-y-1.5">
                            <label for="isi" class="text-xs font-bold text-slate-500 uppercase tracking-wider block">
                                Instruksi Disposisi
                            </label>
                            <textarea id="isi" name="isi" rows="6" required placeholder="Tuliskan instruksi disposisi secara detail..." class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-xs text-slate-700 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all">{{ old('isi') }}</textarea>
                            @error('isi')
                                <p class="text-xs text-rose-500 mt-1 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Grid: Pilih Bidang & Pilih Staff -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Pilih Bidang -->
                            <div class="space-y-1.5">
                                <label for="filter_bidang_id" class="text-xs font-bold text-slate-500 uppercase tracking-wider block">
                                    Pilih Bidang
                                </label>
                                <select id="filter_bidang_id" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-xs text-slate-700 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all">
                                    <option value="">-- Pilih Bidang Tujuan --</option>
                                    @foreach($bidangs as $b)
                                        <option value="{{ $b->id }}">{{ $b->nama_bidang }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Pilih Staff / Penerima -->
                            <div class="space-y-1.5">
                                <label for="penerima_id" class="text-xs font-bold text-slate-500 uppercase tracking-wider block">
                                    Pilih Staff
                                </label>
                                <select id="penerima_id" name="penerima_id" required class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-xs text-slate-700 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all">
                                    <option value="" data-bidang="">-- Pilih Nama Staff --</option>
                                    @foreach($recipients as $r)
                                        <option value="{{ $r->id }}" data-bidang="{{ $r->bidang_id }}">
                                            {{ $r->name }} ({{ strtoupper($r->role) }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('penerima_id')
                                    <p class="text-xs text-rose-500 mt-1 font-semibold">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="pt-6 border-t border-slate-100 flex items-center justify-end gap-3 mt-8">
                        <a href="{{ route('surat.index') }}" class="px-5 py-2.5 border border-slate-200 hover:border-slate-300 text-slate-650 hover:text-slate-800 text-xs font-bold rounded-xl transition-all hover:bg-slate-50/50">
                            Simpan Draft
                        </a>
                        <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-750 text-white text-xs font-bold rounded-xl shadow transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                            </svg>
                            @if(auth()->user()->role === 'kabid' || auth()->user()->role === 'kasi')
                                Kirim Disposisi
                            @else
                                Kirim Surat
                            @endif
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Right Side: PDF Preview (span 5) -->
        <div class="lg:col-span-5 flex flex-col">
            <div class="bg-indigo-50/30 border border-slate-200/60 rounded-2xl shadow-sm p-6 flex-1 flex flex-col">
                <!-- Preview Header -->
                <div class="flex items-center justify-between mb-4 pb-3 border-b border-slate-100">
                    <h3 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        Pratinjau Dokumen
                    </h3>
                    
                    <!-- Search/Download Icons (Styled for visual completeness) -->
                    <div class="flex items-center gap-2.5 text-slate-400">
                        <button type="button" class="hover:text-slate-600 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </button>
                        <button type="button" class="hover:text-slate-600 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Preview Area -->
                <div class="flex-1 flex flex-col items-center justify-center min-h-[450px]">
                    <!-- Empty State Placeholder -->
                    <div id="preview-empty" class="text-center space-y-4 max-w-xs mx-auto py-8">
                        <div class="mx-auto w-24 h-32 bg-white rounded-xl shadow-sm border border-slate-100 flex items-center justify-center relative overflow-hidden group">
                            <!-- Graphical representation of document layout -->
                            <div class="absolute inset-x-0 top-0 h-2 bg-indigo-500"></div>
                            <div class="w-12 space-y-2">
                                <div class="h-1.5 bg-slate-150 rounded w-10"></div>
                                <div class="h-1 bg-slate-100 rounded w-8"></div>
                                <div class="h-1 bg-slate-100 rounded w-12"></div>
                                <div class="h-1 bg-slate-100 rounded w-10"></div>
                                <div class="h-1 bg-slate-100 rounded w-6"></div>
                            </div>
                            <div class="absolute bottom-2 right-2 w-8 h-8 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-[8px]">
                                PDF
                            </div>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-slate-700">Pilih file untuk melihat pratinjau</h4>
                            <p class="text-[10px] text-slate-400 mt-1 leading-relaxed">
                                Hanya file PDF yang dapat ditampilkan secara otomatis di panel ini.
                            </p>
                        </div>
                    </div>

                    <!-- Live PDF Preview (Canvas for Mobile & iframe for Desktop) -->
                    <div id="preview-active" class="hidden w-full h-full flex-1 flex flex-col items-center justify-start overflow-y-auto">
                        <canvas id="pdf-render-canvas" class="md:hidden max-w-full h-auto shadow-md rounded-xl border border-slate-200 mb-2"></canvas>
                        <iframe id="pdf-viewer" class="hidden md:block w-full h-full min-h-[500px] border border-slate-200 rounded-2xl bg-white shadow-inner" src="" frameborder="0"></iframe>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- PDF.js library for text extraction -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.4.120/pdf.min.js"></script>
<script>
    // Configure PDF.js worker path
    pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.4.120/pdf.worker.min.js';
</script>

<!-- JavaScript to handle interactive upload and dynamic dropdown filtering -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    // ----------------------------------------------------
    // Dropdown Filtering Logic
    // ----------------------------------------------------
    const filterBidangSelect = document.getElementById('filter_bidang_id');
    const penerimaSelect = document.getElementById('penerima_id');
    
    // Store all options of penerima select originally
    const originalPenerimaOptions = Array.from(penerimaSelect.options);

    filterBidangSelect.addEventListener('change', function () {
        const selectedBidangId = this.value;
        
        // Clear all options
        penerimaSelect.innerHTML = '';
        
        // Re-append matches
        originalPenerimaOptions.forEach(option => {
            const optionBidangId = option.getAttribute('data-bidang');
            
            // Show option if no bidang selected, or if the bidang matches, or if it is the placeholder option
            if (selectedBidangId === '' || optionBidangId === selectedBidangId || option.value === '') {
                penerimaSelect.appendChild(option.cloneNode(true));
            }
        });
        
        // Reset selected index
        penerimaSelect.selectedIndex = 0;
    });

    // ----------------------------------------------------
    // Drag & Drop / File Upload & PDF Preview Logic
    // ----------------------------------------------------
    const dropZone = document.getElementById('drop-zone');
    const fileInput = document.getElementById('file-input');
    const uploadPrompt = document.getElementById('upload-prompt');
    const fileInfo = document.getElementById('file-info');
    const fileNameText = document.getElementById('file-name');
    const fileSizeText = document.getElementById('file-size');
    const btnRemoveFile = document.getElementById('btn-remove-file');
    
    const previewEmpty = document.getElementById('preview-empty');
    const previewActive = document.getElementById('preview-active');
    const pdfViewer = document.getElementById('pdf-viewer');
 
    // Trigger drag highlighting
    ['dragenter', 'dragover'].forEach(eventName => {
        dropZone.addEventListener(eventName, highlight, false);
    });
    ['dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, unhighlight, false);
    });

    function highlight(e) {
        e.preventDefault();
        dropZone.classList.add('border-indigo-500', 'bg-indigo-50/10');
    }
    function unhighlight(e) {
        e.preventDefault();
        dropZone.classList.remove('border-indigo-500', 'bg-indigo-50/10');
    }

    // Handle dropped files
    dropZone.addEventListener('drop', handleDrop, false);
    function handleDrop(e) {
        let dt = e.dataTransfer;
        let files = dt.files;
        
        if (files.length > 0) {
            fileInput.files = files;
            handleFileSelection(files[0]);
        }
    }

    // Handle standard file selection
    fileInput.addEventListener('change', function () {
        if (this.files.length > 0) {
            handleFileSelection(this.files[0]);
        }
    });

    function handleFileSelection(file) {
        if (!file) return;

        // Visual upload state updates
        fileNameText.textContent = file.name;
        fileSizeText.textContent = formatBytes(file.size);
        
        uploadPrompt.classList.add('hidden');
        fileInfo.classList.remove('hidden');

        // Check if file is PDF for preview and text extraction
        if (file.type === 'application/pdf') {
            const fileUrl = URL.createObjectURL(file);
            pdfViewer.src = fileUrl;
            
            // Render canvas preview for mobile browsers
            renderPdfToCanvas(file);
            
            previewEmpty.classList.add('hidden');
            previewActive.classList.remove('hidden');

            // Try to extract Nomor Surat and Perihal automatically
            tryExtractPdfInfo(file);
        } else {
            // Not a PDF, hide preview
            resetPreview();
        }
    }

    function renderPdfToCanvas(file) {
        const reader = new FileReader();
        reader.onload = function () {
            const typedarray = new Uint8Array(this.result);
            pdfjsLib.getDocument({data: typedarray}).promise.then(function (pdf) {
                return pdf.getPage(1);
            }).then(function (page) {
                const canvas = document.getElementById('pdf-render-canvas');
                if (!canvas) return;
                const ctx = canvas.getContext('2d');
                const scale = window.innerWidth < 640 ? 0.8 : 1.2;
                const viewport = page.getViewport({ scale: scale });
                canvas.height = viewport.height;
                canvas.width = viewport.width;

                const renderContext = {
                    canvasContext: ctx,
                    viewport: viewport
                };
                page.render(renderContext);
            }).catch(function (err) {
                console.error("PDF Canvas error:", err);
            });
        };
        reader.readAsArrayBuffer(file);
    }

    // PDF Text Extraction Logic using PDF.js
    function tryExtractPdfInfo(file) {
        const reader = new FileReader();
        reader.onload = function () {
            const typedarray = new Uint8Array(this.result);
            
            pdfjsLib.getDocument({data: typedarray}).promise.then(function (pdf) {
                // Fetch first page
                return pdf.getPage(1);
            }).then(function (page) {
                return page.getTextContent();
            }).then(function (textContent) {
                const textItems = textContent.items;
                const rawLines = textItems.map(item => item.str);
                const fullText = rawLines.join(' ');
                
                let foundNomor = '';
                const nomorRegex = /(?:nomor|no\.|no)\s*:\s*([^\s]{3,})/i;
                const nomorMatch = fullText.match(nomorRegex);
                if (nomorMatch && nomorMatch[1]) {
                    const idx = fullText.toLowerCase().indexOf(nomorMatch[0].toLowerCase()) + nomorMatch[0].toLowerCase().indexOf(nomorMatch[1].toLowerCase());
                    const remainder = fullText.substring(idx);
                    const clean = remainder.split(/\s{2,}/)[0].trim().replace(/^[,\s\-\.\/:]+|[,\s\-\.\/:]+$/g, '');
                    if (clean.length > 2 && clean.length < 50 && !clean.toLowerCase().startsWith('surat')) {
                        foundNomor = clean;
                    }
                }

                let foundPerihal = '';
                const perihalRegex = /(?:perihal|hal\.|hal)\s*:\s*([^\s]{3,})/i;
                const perihalMatch = fullText.match(perihalRegex);
                if (perihalMatch && perihalMatch[1]) {
                    const idx = fullText.toLowerCase().indexOf(perihalMatch[0].toLowerCase()) + perihalMatch[0].toLowerCase().indexOf(perihalMatch[1].toLowerCase());
                    const remainder = fullText.substring(idx);
                    const clean = remainder.split(/\s{2,}/)[0].trim().replace(/^[,\s\-\.\/:]+|[,\s\-\.\/:]+$/g, '');
                    if (clean.length > 3 && clean.length < 150) {
                        foundPerihal = clean;
                    }
                }

                // Date Extraction
                let foundTanggal = '';
                const monthsMap = {
                    'januari': '01', 'jan': '01',
                    'februari': '02', 'feb': '02',
                    'maret': '03', 'mar': '03',
                    'april': '04', 'apr': '04',
                    'mei': '05',
                    'juni': '06', 'jun': '06',
                    'juli': '07', 'jul': '07',
                    'agustus': '08', 'agu': '08', 'agst': '08',
                    'september': '09', 'sep': '09',
                    'oktober': '10', 'okt': '10',
                    'november': '11', 'nov': '11',
                    'desember': '12', 'des': '12'
                };
                
                // Match Indonesian Date format, e.g. "12 Agustus 2024" or "Palembang, 7 Juli 2026"
                const indoDateRegex = /\b(\d{1,2})[\s\-]+(januari|februari|maret|april|mei|juni|juli|agustus|september|oktober|november|desember|jan|feb|mar|apr|jun|jul|agu|agst|sep|okt|nov|des)[\s\-]+(\d{4})\b/i;
                const dateMatch = fullText.match(indoDateRegex);
                if (dateMatch) {
                    const day = dateMatch[1].padStart(2, '0');
                    const monthWord = dateMatch[2].toLowerCase();
                    const month = monthsMap[monthWord];
                    const year = dateMatch[3];
                    foundTanggal = `${year}-${month}-${day}`;
                } else {
                    // Match numeric format e.g. 12/08/2024
                    const numericDateRegex1 = /\b(\d{1,2})[\/\.\-](\d{1,2})[\/\.\-](\d{4})\b/;
                    const numMatch1 = fullText.match(numericDateRegex1);
                    if (numMatch1) {
                        const day = numMatch1[1].padStart(2, '0');
                        const month = numMatch1[2].padStart(2, '0');
                        const year = numMatch1[3];
                        const m = parseInt(month), d = parseInt(day);
                        if (m >= 1 && m <= 12 && d >= 1 && d <= 31) {
                            foundTanggal = `${year}-${month}-${day}`;
                        }
                    } else {
                        // Match ISO format e.g. 2024-08-12
                        const numericDateRegex2 = /\b(\d{4})[\/\.\-](\d{1,2})[\/\.\-](\d{1,2})\b/;
                        const numMatch2 = fullText.match(numericDateRegex2);
                        if (numMatch2) {
                            const year = numMatch2[1];
                            const month = numMatch2[2].padStart(2, '0');
                            const day = numMatch2[3].padStart(2, '0');
                            const m = parseInt(month), d = parseInt(day);
                            if (m >= 1 && m <= 12 && d >= 1 && d <= 31) {
                                foundTanggal = `${year}-${month}-${day}`;
                            }
                        }
                    }
                }

                // Sender Agency Extraction (Surat Dari)
                let foundDari = '';
                const dariRegex = /\b(dinas|kementerian|badan|sekretariat|kantor|balai|direktorat|yayasan|pt\s*\.?|cv\s*\.?)\b\s*([a-zA-Z0-9\s&,\.\-\/]+)/i;
                for (let i = 0; i < Math.min(rawLines.length, 20); i++) {
                    const line = rawLines[i].trim();
                    const match = line.match(dariRegex);
                    if (match) {
                        foundDari = match[0].trim().replace(/^[,\s\-\.\/:]+|[,\s\-\.\/:]+$/g, '');
                        if (foundDari.length > 4) {
                            break;
                        }
                    }
                }
                
                if (!foundDari) {
                    for (let i = 0; i < Math.min(rawLines.length, 20); i++) {
                        const line = rawLines[i].trim();
                        if (/^pemerintah\b/i.test(line)) {
                            foundDari = line.replace(/^[,\s\-\.\/:]+|[,\s\-\.\/:]+$/g, '');
                            break;
                        }
                    }
                }

                // Fallback: line-by-line scanning if regex failed due to multi-line positioning
                if (!foundNomor || !foundPerihal) {
                    for (let i = 0; i < rawLines.length; i++) {
                        const line = rawLines[i].trim();
                        
                        // Nomor Surat search
                        if (!foundNomor && /^(?:nomor|no\.|no)\s*:?$/i.test(line)) {
                            for (let j = 1; j <= 3 && (i + j) < rawLines.length; j++) {
                                const val = rawLines[i + j].trim();
                                if (val && val !== ':' && val.length > 2 && val.length < 50) {
                                    foundNomor = val.replace(/^[,\s\-\.\/:]+|[,\s\-\.\/:]+$/g, '');
                                    break;
                                }
                            }
                        }
                        
                        // Perihal search
                        if (!foundPerihal && /^(?:perihal|hal\.|hal)\s*:?$/i.test(line)) {
                            for (let j = 1; j <= 3 && (i + j) < rawLines.length; j++) {
                                const val = rawLines[i + j].trim();
                                if (val && val !== ':' && val.length > 3 && val.length < 150) {
                                    foundPerihal = val.replace(/^[,\s\-\.\/:]+|[,\s\-\.\/:]+$/g, '');
                                    break;
                                }
                            }
                        }
                    }
                }

                // Autofill inputs in UI if they are empty
                if (foundNomor) {
                    const nomorInput = document.getElementById('nomor_surat');
                    if (nomorInput && !nomorInput.value) {
                        nomorInput.value = foundNomor;
                        highlightField(nomorInput);
                    }
                }
                
                if (foundPerihal) {
                    const perihalInput = document.getElementById('perihal');
                    if (perihalInput && !perihalInput.value) {
                        perihalInput.value = foundPerihal;
                        highlightField(perihalInput);
                    }
                }

                if (foundTanggal) {
                    const tanggalInput = document.getElementById('tanggal_surat');
                    if (tanggalInput && (!tanggalInput.value || tanggalInput.value === "{{ date('Y-m-d') }}")) {
                        tanggalInput.value = foundTanggal;
                        highlightField(tanggalInput);
                    }
                }

                if (foundDari) {
                    const dariInput = document.getElementById('surat_dari');
                    if (dariInput && (!dariInput.value || dariInput.value === "{{ auth()->user()->name }}")) {
                        dariInput.value = foundDari;
                        highlightField(dariInput);
                    }
                }
            }).catch(function (err) {
                console.error("PDF Parsing error:", err);
            });
        };
        reader.readAsArrayBuffer(file);
    }

    function highlightField(el) {
        el.classList.add('bg-indigo-50', 'ring-2', 'ring-indigo-500/20');
        setTimeout(() => {
            el.classList.remove('bg-indigo-50', 'ring-2', 'ring-indigo-500/20');
        }, 1500);
    }

    // Handle removal of file
    btnRemoveFile.addEventListener('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        
        // Reset file input
        fileInput.value = '';
        
        // Re-show prompt
        fileInfo.classList.add('hidden');
        uploadPrompt.classList.remove('hidden');
        
        // Reset preview panel
        resetPreview();
    });

    function resetPreview() {
        pdfViewer.src = '';
        previewActive.classList.add('hidden');
        previewEmpty.classList.remove('hidden');
    }

    function formatBytes(bytes, decimals = 2) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const dm = decimals < 0 ? 0 : decimals;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
    }
});
</script>
@endsection
