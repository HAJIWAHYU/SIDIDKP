@extends('layouts.app')

@section('content')
<div class="space-y-8 max-w-2xl">
    <!-- Header Page -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Edit Bidang</h2>
            <p class="text-xs text-slate-500 mt-1">Ubah nama unit bidang atau divisi {{ $bidang->nama_bidang }}.</p>
        </div>
        <div>
            <a href="{{ route('bidang.index') }}" class="inline-flex items-center gap-1.5 px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-semibold rounded-xl transition-colors shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-2xl border border-slate-200/60 p-6 shadow-sm">
        <form action="{{ route('bidang.update', $bidang->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Nama Bidang -->
            <div class="space-y-1.5">
                <label for="nama_bidang" class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">
                    Nama Unit Bidang
                </label>
                <input type="text" id="nama_bidang" name="nama_bidang" value="{{ old('nama_bidang', $bidang->nama_bidang) }}" required placeholder="Contoh: Bidang Hubungan Masyarakat" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-xs text-slate-700 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all">
                @error('nama_bidang')
                    <p class="text-xs text-rose-500 mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Actions Buttons -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('bidang.index') }}" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-semibold rounded-xl transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded-xl shadow transition-colors">
                    Update Bidang
                </button>
            </div>
        </form>
    </div>
</div>
@endsection