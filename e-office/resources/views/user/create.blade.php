@extends('layouts.app')

@section('content')
<div class="space-y-8 max-w-3xl">
    <!-- Header Page -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Tambah User Baru</h2>
            <p class="text-xs text-slate-500 mt-1">Buat akun pengguna baru dengan menetapkan hak akses (peran) dan unit bidang.</p>
        </div>
        <div>
            <a href="{{ route('user.index') }}" class="inline-flex items-center gap-1.5 px-3 py-2 bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-semibold rounded-xl transition-colors shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali
            </a>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-white rounded-2xl border border-slate-200/60 p-6 shadow-sm">
        <form action="{{ route('user.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Nama -->
            <div class="space-y-1.5">
                <label for="name" class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">
                    Nama Lengkap
                </label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required placeholder="Contoh: Ahmad Subardjo" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-xs text-slate-700 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all">
                @error('name')
                    <p class="text-xs text-rose-500 mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div class="space-y-1.5">
                <label for="email" class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">
                    Alamat Email
                </label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="Contoh: ahmad@domain.com" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-xs text-slate-700 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all">
                @error('email')
                    <p class="text-xs text-rose-500 mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div class="space-y-1.5">
                <label for="password" class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">
                    Kata Sandi (Password)
                </label>
                <input type="password" id="password" name="password" required placeholder="Minimal 6 karakter" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-xs text-slate-700 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all">
                @error('password')
                    <p class="text-xs text-rose-500 mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Role (Peran) -->
            <div class="space-y-1.5">
                <label for="role" class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">
                    Peran (Role)
                </label>
                <select id="role" name="role" required class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-xs text-slate-700 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all">
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="kabid" {{ old('role') == 'kabid' ? 'selected' : '' }}>Kepala Bidang (KABID)</option>
                    <option value="kasi" {{ old('role') == 'kasi' ? 'selected' : '' }}>Kepala Seksi (KASI)</option>
                    <option value="staff" {{ old('role') == 'staff' ? 'selected' : '' }}>Staff</option>
                </select>
                @error('role')
                    <p class="text-xs text-rose-500 mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Bidang -->
            <div class="space-y-1.5">
                <label for="bidang_id" class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">
                    Unit Bidang
                </label>
                <select id="bidang_id" name="bidang_id" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-xs text-slate-700 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all">
                    <option value="">-- Pilih Bidang --</option>
                    @foreach($bidangs as $b)
                        <option value="{{ $b->id }}" {{ old('bidang_id') == $b->id ? 'selected' : '' }}>
                            {{ $b->nama_bidang }}
                        </option>
                    @endforeach
                </select>
                @error('bidang_id')
                    <p class="text-xs text-rose-500 mt-1 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Actions Buttons -->
            <div class="pt-4 border-t border-slate-100 flex items-center justify-end gap-3">
                <a href="{{ route('user.index') }}" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-semibold rounded-xl transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-semibold rounded-xl shadow transition-colors">
                    Simpan User
                </button>
            </div>
        </form>
    </div>
</div>
@endsection