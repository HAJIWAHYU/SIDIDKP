<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Login</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="font-sans antialiased h-full bg-[#f3f7fa] text-slate-800">
    <div class="min-h-screen flex items-center justify-center p-4 sm:p-6">
        
        <!-- Main Card Container -->
        <div class="w-full max-w-[950px] min-h-[580px] bg-white rounded-[24px] shadow-2xl shadow-slate-200/50 flex flex-col md:flex-row overflow-hidden border border-slate-100">
            
            <!-- Left Pane: Branding & Info (Slate/Purple Gradient matching Dashboard) -->
            <div class="w-full md:w-[45%] bg-gradient-to-br from-slate-900 via-purple-950 to-slate-900 p-8 md:p-10 flex flex-col justify-between relative overflow-hidden border-b md:border-b-0 md:border-r border-slate-200/30">
                <!-- Decorative background elements -->
                <div class="absolute -top-10 -left-10 w-40 h-40 bg-purple-500/10 rounded-full blur-2xl"></div>
                
                <!-- SVG Boat Sail Illustration (Bottom Right) -->
                <div class="absolute bottom-0 right-0 w-72 h-72 opacity-40 text-purple-400/10">
                    <svg viewBox="0 0 100 100" fill="currentColor" class="w-full h-full transform translate-x-4 translate-y-4">
                        <path d="M15 75 L85 75 L75 83 L25 83 Z" />
                        <path d="M48 15 L48 72 L80 72 Z" />
                        <path d="M44 22 L44 72 L18 72 Z" />
                    </svg>
                </div>

                <!-- Brand Header -->
                <div class="relative z-10">
                    <div class="flex items-center gap-3">
                        <!-- Clean and Modern SIDI Logo Icon -->
                        <div class="w-10 h-10 rounded-xl bg-purple-600 flex items-center justify-center shadow-md shadow-purple-950/40 shrink-0">
                            <svg class="w-6 h-6 text-white" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 3.5L20.5 18H3.5L12 3.5Z" stroke="currentColor" stroke-width="2.5" stroke-linejoin="round" stroke-linecap="round" fill="none"/>
                                <rect x="11.25" y="13.5" width="1.5" height="3" fill="currentColor" rx="0.5"/>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-sm font-black text-white tracking-wider uppercase leading-none">SIDI</h2>
                            <p class="text-[7.5px] font-bold text-purple-300 tracking-widest uppercase mt-1 leading-none">Sistem Informasi Disposisi Internal</p>
                        </div>
                    </div>
                </div>

                <!-- Center Presentation Content -->
                <div class="relative z-10 my-8 md:my-0">
                    <h1 class="text-[25px] font-extrabold text-white leading-tight">
                        Efisiensi Administrasi Kelautan & Perikanan
                    </h1>
                    <p class="text-[11.5px] text-slate-300 leading-relaxed mt-3.5 font-medium">
                        Digitalisasi alur dokumen disposisi untuk layanan yang lebih cepat di lingkungan Provinsi Sumatera Selatan.
                    </p>

                    <!-- Layanan Terpadu Floating Card (Glassmorphic) -->
                    <div class="mt-8 bg-white/5 border border-white/10 p-5 rounded-2xl shadow-inner backdrop-blur-sm">
                        <div class="flex items-center gap-2 mb-2">
                            <span class="w-2 h-2 rounded-full bg-purple-400"></span>
                            <span class="text-[9px] font-bold text-purple-300 uppercase tracking-widest">Layanan Terpadu</span>
                        </div>
                        <p class="text-[11px] text-slate-300 leading-relaxed font-medium">
                            Disposisi surat masuk diteruskan secara real-time di dinas Kelautan & Perikanan.
                        </p>
                    </div>
                </div>

                <!-- Bottom Footer (Secure Gateway) -->
                <div class="relative z-10 pt-4 border-t border-white/10">
                    <div class="flex items-center gap-1.5 text-slate-400">
                        <svg class="w-3.5 h-3.5 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                        <span class="text-[9.5px] font-bold tracking-wide text-slate-350">Secure Institutional Gateway Access</span>
                    </div>
                </div>

            </div>

            <!-- Right Pane: Login Form (White) -->
            <div class="flex-1 bg-white p-8 md:p-12 flex flex-col justify-center">
                <div class="w-full max-w-sm mx-auto">
                    
                    <!-- Form Header -->
                    <div class="mb-8">
                        <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">Selamat Datang</h2>
                        <p class="text-xs text-slate-400 mt-2 font-medium leading-relaxed">
                            Silakan masuk menggunakan akun resmi kedinasan Anda untuk melanjutkan proses disposisi.
                        </p>
                    </div>

                    <!-- Session Status Alert -->
                    @if (session('status'))
                        <div class="mb-6 p-3.5 rounded-xl bg-emerald-50 border border-emerald-200 text-xs text-emerald-600 font-bold">
                            {{ session('status') }}
                        </div>
                    @endif

                    <!-- Login Form -->
                    <form method="POST" action="{{ route('login') }}" class="space-y-5">
                        @csrf

                        <!-- Email Input Group -->
                        <div class="space-y-1.5">
                            <label for="email" class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block">
                                Email Kedinasan
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                </span>
                                <input id="email" 
                                       class="w-full bg-[#f8fafc] border border-slate-200 rounded-xl pl-10 pr-4 py-3 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600 transition-all duration-250" 
                                       type="email" 
                                       name="email" 
                                       value="{{ old('email') }}" 
                                       required 
                                       autofocus 
                                       autocomplete="username"
                                       placeholder="nama@sumselprov.go.id" />
                            </div>
                            @if ($errors->has('email'))
                                <p class="text-xs text-rose-500 mt-1 flex items-center gap-1 font-semibold">
                                    <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                    </svg>
                                    {{ $errors->first('email') }}
                                </p>
                            @endif
                        </div>

                        <!-- Password Input Group -->
                        <div class="space-y-1.5">
                            <label for="password" class="text-[10px] font-bold text-slate-400 uppercase tracking-widest block">
                                Kata Sandi
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                </span>
                                <input id="password" 
                                       class="w-full bg-[#f8fafc] border border-slate-200 rounded-xl pl-10 pr-10 py-3 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600 transition-all duration-250" 
                                       type="password" 
                                       name="password" 
                                       required 
                                       autocomplete="current-password"
                                       placeholder="••••••••" />
                                <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-slate-650 transition-colors">
                                    <svg id="eye-icon" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </button>
                            </div>
                            @if ($errors->has('password'))
                                <p class="text-xs text-rose-500 mt-1 flex items-center gap-1 font-semibold">
                                    <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                    </svg>
                                    {{ $errors->first('password') }}
                                </p>
                            @endif
                        </div>

                        <!-- Remember Me Checkbox -->
                        <div class="flex items-center pt-1">
                            <input id="remember_me" 
                                   type="checkbox" 
                                   class="w-4 h-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500 transition-colors" 
                                   name="remember">
                            <label for="remember_me" class="ml-2 text-xs font-bold text-slate-500 select-none cursor-pointer">
                                Ingat saya di perangkat ini
                            </label>
                        </div>

                        <!-- Submit Button -->
                        <div class="pt-2">
                            <button type="submit" 
                                    class="w-full py-3.5 px-4 bg-gradient-to-r from-slate-900 via-purple-950 to-slate-900 hover:opacity-95 text-white text-xs font-bold rounded-xl shadow-lg shadow-purple-950/20 hover:shadow-purple-950/30 transition-all duration-200 flex items-center justify-center gap-2 transform active:scale-[0.99]">
                                <span>Masuk</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 16l-4-4m0 0l4-4m-4 4h12m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                            </button>
                        </div>
                    </form>

                    <span class="text-[9px] text-slate-300 font-extrabold tracking-widest text-center mt-8 uppercase block select-none">
                        &mdash; PROVINSI SUMATERA SELATAN &mdash;
                    </span>

                </div>
            </div>
            
        </div>
    </div>

    <!-- Password visibility toggle script -->
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"></path>`;
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>`;
            }
        }
    </script>
</body>
</html>
