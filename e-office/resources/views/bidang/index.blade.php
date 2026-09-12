@extends('layouts.app')

@section('content')
<div class="space-y-8">
    <!-- Header Page -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Manajemen Bidang</h2>
            <p class="text-xs text-slate-500 mt-1">Kelola unit bidang, bagian, atau divisi dalam struktur organisasi E-Office.</p>
        </div>
        
        <div>
            <a href="{{ route('bidang.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded-xl shadow transition-colors shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Bidang Baru
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
    <div class="bg-white rounded-2xl border border-slate-200/60 p-6 shadow-sm max-w-4xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="border-b border-slate-100 text-slate-400 font-semibold uppercase tracking-wider">
                        <th class="py-3 px-4 w-16">No</th>
                        <th class="py-3 px-4">Nama Bidang</th>
                        <th class="py-3 px-4 text-center w-40">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-700">
                    @forelse($bidangs as $b)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="py-3.5 px-4 font-medium">{{ $loop->iteration }}</td>
                            <td class="py-3.5 px-4 font-semibold text-slate-800">
                                {{ $b->nama_bidang }}
                            </td>
                            <td class="py-3.5 px-4 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('bidang.edit', $b->id) }}" class="inline-flex items-center px-3 py-1.5 bg-slate-100 hover:bg-indigo-50 text-slate-600 hover:text-indigo-600 font-semibold rounded-lg transition-colors">
                                        Edit
                                    </a>
                                    <form action="{{ route('bidang.destroy', $b->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus bidang ini? User yang berada di bidang ini akan kehilangan asosiasi unit bidang mereka.')" style="display:inline;">
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
                            <td colspan="3" class="py-8 px-4 text-center text-slate-400 italic">
                                Belum ada data bidang.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection