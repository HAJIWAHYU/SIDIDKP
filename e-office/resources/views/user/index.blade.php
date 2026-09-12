@extends('layouts.app')

@section('content')
<div class="space-y-8">
    <!-- Header Page -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Manajemen User</h2>
            <p class="text-xs text-slate-500 mt-1">Kelola data pengguna, peran, dan unit bidang masing-masing.</p>
        </div>
        
        <div class="flex items-center gap-3 self-end sm:self-center">
            <!-- Search Bar -->
            <form method="GET" action="{{ route('user.index') }}" class="relative w-48 sm:w-64">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </span>
                <input type="text" 
                       id="search-input"
                       name="search" 
                       value="{{ request('search') }}" 
                       class="w-full bg-white border border-slate-200 rounded-xl pl-9 pr-8 py-2 text-xs text-slate-808 placeholder-slate-400 focus:outline-none focus:border-indigo-650 focus:ring-1 focus:ring-indigo-650 transition-all duration-200 shadow-sm shadow-slate-100/50" 
                       placeholder="Cari user..." 
                       autocomplete="off" />
                <button type="button" id="clear-search" class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-slate-650 {{ request('search') ? '' : 'hidden' }}">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </form>

            <a href="{{ route('user.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded-xl shadow transition-colors shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah User Baru
            </a>
        </div>
    </div>

    <!-- Alert Success -->
    @if(session('success'))
        <div class="p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-xs text-emerald-600 font-semibold">
            {{ session('success') }}
        </div>
    @endif

    <!-- Table Card -->
    <div id="user-container" class="bg-white rounded-2xl border border-slate-200/60 p-6 shadow-sm space-y-4">
        
        @if(request('search'))
            <div class="flex items-center justify-between pb-1">
                <span class="text-[10px] text-slate-405 font-bold uppercase tracking-wider">
                    Ditemukan <span class="text-indigo-600">{{ $users->total() }}</span> user
                </span>
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="border-b border-slate-100 text-slate-400 font-semibold uppercase tracking-wider">
                        <th class="py-3 px-4 w-12">No</th>
                        <th class="py-3 px-4">Nama</th>
                        <th class="py-3 px-4">Email</th>
                        <th class="py-3 px-4">Role</th>
                        <th class="py-3 px-4">Bidang</th>
                        <th class="py-3 px-4 text-center w-40">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($users as $u)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="py-3.5 px-4 font-medium">{{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}</td>
                            <td class="py-3.5 px-4">
                                <div class="font-semibold text-slate-800">{{ $u->name }}</div>
                            </td>
                            <td class="py-3.5 px-4 text-slate-500 font-medium">{{ $u->email }}</td>
                            <td class="py-3.5 px-4">
                                @if($u->role == 'admin')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-indigo-50 text-indigo-700">
                                        Admin
                                    </span>
                                @elseif($u->role == 'kabid')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-purple-50 text-purple-700">
                                        Kepala Bidang
                                    </span>
                                @elseif($u->role == 'kasi')
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700">
                                        Kepala Seksi
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700">
                                        Staff
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 font-medium text-slate-650">
                                {{ $u->bidang->nama_bidang ?? '-' }}
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('user.edit', $u->id) }}" class="inline-flex items-center px-3 py-1.5 bg-slate-100 hover:bg-indigo-50 text-slate-600 hover:text-indigo-600 font-semibold rounded-lg transition-colors">
                                        Edit
                                    </a>
                                    <form action="{{ route('user.destroy', $u->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?')" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-rose-50 hover:bg-rose-100 text-rose-600 font-semibold rounded-lg transition-colors">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 px-4 text-center text-slate-400 italic">
                                {{ request('search') ? 'Tidak ditemukan user yang cocok.' : 'Belum ada data user.' }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination User -->
        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>
</div>

<!-- Live Search and Asynchronous Pagination Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search-input');
    const clearSearch = document.getElementById('clear-search');
    const userContainer = document.getElementById('user-container');
    let debounceTimer;

    function fetchResults(query) {
        const url = new URL(window.location.href);
        if (query) {
            url.searchParams.set('search', query);
        } else {
            url.searchParams.delete('search');
        }
        url.searchParams.delete('page'); // Reset pagination on new search

        fetch(url)
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                
                // Swap User Container
                if (userContainer && doc.getElementById('user-container')) {
                    userContainer.innerHTML = doc.getElementById('user-container').innerHTML;
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
                        
                        if (userContainer && doc.getElementById('user-container')) {
                            userContainer.innerHTML = doc.getElementById('user-container').innerHTML;
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