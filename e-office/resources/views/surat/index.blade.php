@extends('layouts.app')

@section('content')
<div class="space-y-8">
    <!-- Header Page -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Manajemen Surat</h2>
            <p class="text-xs text-slate-500 mt-1">Kirim dan terima dokumen persuratan antar bidang.</p>
        </div>
        
        <div class="flex items-center gap-3 self-end sm:self-center">
            <!-- Search Bar -->
            <form method="GET" action="{{ route('surat.index') }}" class="relative w-48 sm:w-64">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </span>
                <input type="text" 
                       id="search-input"
                       name="search" 
                       value="{{ request('search') }}" 
                       class="w-full bg-white border border-slate-200 rounded-xl pl-9 pr-8 py-2 text-xs text-slate-805 placeholder-slate-400 focus:outline-none focus:border-indigo-650 focus:ring-1 focus:ring-indigo-650 transition-all duration-200 shadow-sm shadow-slate-100/50" 
                       placeholder="Cari surat..." 
                       autocomplete="off" />
                <button type="button" id="clear-search" class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-slate-650 {{ request('search') ? '' : 'hidden' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </form>

            @if(auth()->user()->role !== 'staff')
            <a href="{{ route('surat.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded-xl shadow transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                @if(auth()->user()->role === 'kabid' || auth()->user()->role === 'kasi')
                    Disposisi Baru
                @else
                    Tulis Surat Baru
                @endif
            </a>
            @endif
        </div>
    </div>

    <!-- Alert Success -->
    @if(session('success'))
        <div class="p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-xs text-emerald-600 font-semibold">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 gap-8">
        
        <!-- Tab Surat Masuk -->
        <div id="inbox-container" class="bg-white rounded-2xl border border-slate-200/60 p-6 shadow-sm">
            <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                <span class="w-1.5 h-5 bg-indigo-500 rounded-full"></span>
                Surat Masuk (Inbox)
            </h3>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr class="border-b border-slate-100 text-slate-400 font-semibold uppercase tracking-wider">
                            <th class="py-3 px-4">No</th>
                            <th class="py-3 px-4">Pengirim</th>
                            <th class="py-3 px-4">Nomor Surat</th>
                            <th class="py-3 px-4">Perihal</th>
                            <th class="py-3 px-4">Tanggal Kirim</th>
                            <th class="py-3 px-4">Status</th>
                            <th class="py-3 px-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @forelse($incomingLetters as $s)
                            @php
                                $nomorSurat = '-';
                                $perihalText = $s->perihal;
                                if (preg_match('/^\[(.*?)\]\s*(.*)$/', $s->perihal, $matches)) {
                                    $nomorSurat = $matches[1];
                                    $perihalText = $matches[2];
                                }
                            @endphp
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="py-3.5 px-4 font-medium">{{ ($incomingLetters->currentPage() - 1) * $incomingLetters->perPage() + $loop->iteration }}</td>
                                <td class="py-3.5 px-4">
                                    <div class="font-semibold">{{ $s->pengirim?->name ?? 'Pengirim Tidak Ditemukan' }}</div>
                                    <div class="text-[10px] text-slate-400 mt-0.5">{{ $s->pengirim?->bidang?->nama_bidang ?? 'Tanpa Bidang' }}</div>
                                </td>
                                <td class="py-3.5 px-4 font-medium text-slate-650">{{ $nomorSurat }}</td>
                                <td class="py-3.5 px-4 font-semibold text-slate-800">{{ $perihalText }}</td>
                                <td class="py-3.5 px-4 text-slate-500">{{ $s->created_at->format('d M Y, H:i') }} WIB</td>
                                <td class="py-3.5 px-4">
                                    @if($s->is_read)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-600">
                                            Sudah Dibaca
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-600">
                                            Belum Dibaca
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 text-center">
                                    <a href="{{ route('surat.show', $s->id) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-100 hover:bg-indigo-50 text-slate-600 hover:text-indigo-600 font-semibold rounded-lg transition-colors">
                                        Buka Surat
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-8 px-4 text-center text-slate-400 italic">
                                    {{ request('search') ? 'Tidak ditemukan surat masuk yang cocok.' : 'Belum ada surat masuk untuk Anda.' }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination Surat Masuk -->
            <div class="mt-5">
                {{ $incomingLetters->appends(request()->except('incoming'))->links() }}
            </div>
        </div>

        <!-- Tab Surat Keluar -->
        @if(auth()->user()->role !== 'staff')
        <div id="sent-container" class="bg-white rounded-2xl border border-slate-200/60 p-6 shadow-sm">
            <h3 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                <span class="w-1.5 h-5 bg-purple-500 rounded-full"></span>
                Surat Keluar (Sent)
            </h3>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs border-collapse">
                    <thead>
                        <tr class="border-b border-slate-100 text-slate-400 font-semibold uppercase tracking-wider">
                            <th class="py-3 px-4">No</th>
                            <th class="py-3 px-4">Penerima</th>
                            <th class="py-3 px-4">Nomor Surat</th>
                            <th class="py-3 px-4">Perihal</th>
                            <th class="py-3 px-4">Tanggal Kirim</th>
                            <th class="py-3 px-4">Status Penerima</th>
                            <th class="py-3 px-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-slate-700">
                        @forelse($outgoingLetters as $s)
                            @php
                                $nomorSurat = '-';
                                $perihalText = $s->perihal;
                                if (preg_match('/^\[(.*?)\]\s*(.*)$/', $s->perihal, $matches)) {
                                    $nomorSurat = $matches[1];
                                    $perihalText = $matches[2];
                                }
                            @endphp
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="py-3.5 px-4 font-medium">{{ ($outgoingLetters->currentPage() - 1) * $outgoingLetters->perPage() + $loop->iteration }}</td>
                                <td class="py-3.5 px-4">
                                    <div class="font-semibold">{{ $s->penerima?->name ?? 'Penerima Tidak Ditemukan' }}</div>
                                    <div class="text-[10px] text-slate-400 mt-0.5">{{ $s->penerima?->bidang?->nama_bidang ?? 'Tanpa Bidang' }}</div>
                                </td>
                                <td class="py-3.5 px-4 font-medium text-slate-650">{{ $nomorSurat }}</td>
                                <td class="py-3.5 px-4 font-semibold text-slate-800">{{ $perihalText }}</td>
                                <td class="py-3.5 px-4 text-slate-500">{{ $s->created_at->format('d M Y, H:i') }} WIB</td>
                                <td class="py-3.5 px-4">
                                    @if($s->is_read)
                                        <span class="inline-flex items-center gap-1 text-[10px] font-bold text-emerald-600">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                            Sudah Dibaca
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 text-[10px] font-bold text-slate-400">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            Belum Dibaca
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3.5 px-4 text-center flex items-center justify-center gap-2">
                                    <a href="{{ route('surat.show', $s->id) }}" class="inline-flex items-center px-2.5 py-1.5 bg-slate-100 hover:bg-indigo-50 text-slate-600 hover:text-indigo-600 font-semibold rounded-lg transition-colors">
                                        Detail
                                    </a>
                                    
                                    <form action="{{ route('surat.destroy', $s->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus arsip surat keluar ini?')" class="inline-flex items-center px-2.5 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-600 font-semibold rounded-lg transition-colors cursor-pointer">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-8 px-4 text-center text-slate-400 italic">
                                    {{ request('search') ? 'Tidak ditemukan surat keluar yang cocok.' : 'Belum ada surat keluar yang dikirim.' }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination Surat Keluar -->
            <div class="mt-5">
                {{ $outgoingLetters->appends(request()->except('outgoing'))->links() }}
            </div>
        </div>
        @endif

    </div>
</div>

<!-- Live Search and Asynchronous Pagination Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search-input');
    const clearSearch = document.getElementById('clear-search');
    const inboxContainer = document.getElementById('inbox-container');
    const sentContainer = document.getElementById('sent-container');
    let debounceTimer;

    function fetchResults(query) {
        const url = new URL(window.location.href);
        if (query) {
            url.searchParams.set('search', query);
        } else {
            url.searchParams.delete('search');
        }
        url.searchParams.delete('incoming'); // Reset pagination on new search
        url.searchParams.delete('outgoing');

        fetch(url)
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                
                // Swap Inbox Container
                if (inboxContainer && doc.getElementById('inbox-container')) {
                    inboxContainer.innerHTML = doc.getElementById('inbox-container').innerHTML;
                }
                // Swap Sent Container
                if (sentContainer && doc.getElementById('sent-container')) {
                    sentContainer.innerHTML = doc.getElementById('sent-container').innerHTML;
                }
                
                // Update Address Bar URL
                window.history.replaceState({ path: url.href }, '', url.href);
                
                bindPagination();
            })
            .catch(err => console.error('Error fetching search results:', err));
    }

    function bindPagination() {
        const paginationLinks = document.querySelectorAll('.pagination a, [role="navigation"] a');
        paginationLinks.forEach(link => {
            link.replaceWith(link.cloneNode(true));
        });

        document.querySelectorAll('.pagination a, [role="navigation"] a').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const pageUrl = this.getAttribute('href');
                
                fetch(pageUrl)
                    .then(response => response.text())
                    .then(html => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');
                        
                        if (inboxContainer && doc.getElementById('inbox-container')) {
                            inboxContainer.innerHTML = doc.getElementById('inbox-container').innerHTML;
                        }
                        if (sentContainer && doc.getElementById('sent-container')) {
                            sentContainer.innerHTML = doc.getElementById('sent-container').innerHTML;
                        }
                        
                        window.history.replaceState({ path: pageUrl }, '', pageUrl);
                        bindPagination();
                        
                        document.querySelector('.space-y-8').scrollIntoView({ behavior: 'smooth' });
                    })
                    .catch(err => console.error('Error paginating:', err));
            });
        });
    }

    if (searchInput) {
        const searchForm = searchInput.closest('form');
        if (searchForm) {
            searchForm.addEventListener('submit', function(e) {
                e.preventDefault();
            });
        }

        searchInput.addEventListener('input', function() {
            const query = this.value;
            
            // Toggle clear button visibility
            if (query.trim() !== '') {
                clearSearch.classList.remove('hidden');
            } else {
                clearSearch.classList.add('hidden');
            }

            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                fetchResults(query);
            }, 300); // 300ms debounce delay
        });
    }

    if (clearSearch) {
        clearSearch.addEventListener('click', function() {
            searchInput.value = '';
            this.classList.add('hidden');
            fetchResults('');
            searchInput.focus();
        });
    }
    
    bindPagination();
});
</script>
@endsection
