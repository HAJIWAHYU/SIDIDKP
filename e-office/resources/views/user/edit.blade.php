@extends('layouts.app')

@section('content')
<div class="space-y-6 max-w-7xl mx-auto">
    <!-- Header Page -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Edit User</h2>
            <p class="text-xs text-slate-500 mt-1">Ubah data pengguna, peran, atau unit bidang untuk akun {{ $user->name }}.</p>
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

    <!-- Form Section with Grid -->
    <form action="{{ route('user.update', $user->id) }}" method="POST" class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-stretch">
        @csrf
        @method('PUT')

        <!-- Left Side: Profile Info (span 7) -->
        <div class="lg:col-span-7 flex flex-col">
            <div class="bg-white rounded-2xl border border-slate-200/60 p-6 shadow-sm flex-1 flex flex-col justify-between">
                <div class="space-y-5">
                    <h3 class="text-sm font-bold text-slate-800 pb-3 border-b border-slate-100 flex items-center gap-2">
                        <span class="w-1.5 h-4 bg-indigo-500 rounded-full"></span>
                        Informasi Profil
                    </h3>

                    <!-- Nama -->
                    <div class="space-y-1.5">
                        <label for="name" class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">
                            Nama Lengkap
                        </label>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required placeholder="Contoh: Ahmad Subardjo" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-xs text-slate-700 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all">
                        @error('name')
                            <p class="text-xs text-rose-500 mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="space-y-1.5">
                        <label for="email" class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">
                            Alamat Email
                        </label>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required placeholder="Contoh: ahmad@domain.com" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-xs text-slate-700 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all">
                        @error('email')
                            <p class="text-xs text-rose-500 mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Role (Peran) -->
                    <div class="space-y-1.5">
                        <label for="role" class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">
                            Peran (Role)
                        </label>
                        <select id="role" name="role" required class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-xs text-slate-700 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all">
                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="kabid" {{ old('role', $user->role) == 'kabid' ? 'selected' : '' }}>Kepala Bidang (KABID)</option>
                            <option value="kasi" {{ old('role', $user->role) == 'kasi' ? 'selected' : '' }}>Kepala Seksi (KASI)</option>
                            <option value="staff" {{ old('role', $user->role) == 'staff' ? 'selected' : '' }}>Staff</option>
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
                                <option value="{{ $b->id }}" {{ old('bidang_id', $user->bidang_id) == $b->id ? 'selected' : '' }}>
                                    {{ $b->nama_bidang }}
                                </option>
                            @endforeach
                        </select>
                        @error('bidang_id')
                            <p class="text-xs text-rose-500 mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Actions Buttons -->
                <div class="pt-6 border-t border-slate-100 flex items-center justify-end gap-3 mt-8">
                    <a href="{{ route('user.index') }}" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-semibold rounded-xl transition-colors">
                        Batal
                    </a>
                    <button type="submit" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-750 text-white text-xs font-semibold rounded-xl shadow transition-colors">
                        Update User
                    </button>
                </div>
            </div>
        </div>

        <!-- Right Side: Change Password Card (span 5) -->
        <div class="lg:col-span-5 flex flex-col">
            <div class="bg-indigo-50/30 border border-slate-200/60 rounded-2xl p-6 shadow-sm flex-1 flex flex-col justify-between">
                <div class="space-y-5">
                    <h3 class="text-sm font-bold text-slate-800 pb-3 border-b border-slate-100 flex items-center gap-2">
                        <span class="w-1.5 h-4 bg-purple-500 rounded-full"></span>
                        Ubah Password
                    </h3>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        Isi formulir ini jika pengguna lupa password atau ingin mengganti password akun mereka. Kosongkan jika tidak ingin mengubah password.
                    </p>

                    <!-- Password Baru -->
                    <div class="space-y-1.5">
                        <label for="password" class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">
                            Password Baru
                        </label>
                        <input type="password" id="password" name="password" placeholder="Minimal 6 karakter" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-xs text-slate-700 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all">
                        @error('password')
                            <p class="text-xs text-rose-500 mt-1 font-semibold">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Konfirmasi Password Baru -->
                    <div class="space-y-1.5">
                        <label for="password_confirmation" class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">
                            Konfirmasi Password Baru
                        </label>
                        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ulangi password baru" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-2.5 text-xs text-slate-700 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all">
                    </div>
                </div>

                <div class="text-[10px] text-slate-400 italic pt-4 mt-auto border-t border-slate-150">
                    * Perubahan password langsung aktif setelah Anda menekan tombol "Update User" di sebelah kiri.
                </div>
            </div>
        </div>
    </form>
</div>
@endsection