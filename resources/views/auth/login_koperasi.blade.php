<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Koperasi | Disperindagkop UKM Karawang</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        *{ margin:0; padding:0; box-sizing:border-box; }
        body{ min-height:100vh; overflow-x:hidden; font-family:'Segoe UI',sans-serif; background:linear-gradient(180deg,#ecfdf5 0%,#d1fae5 100%); position:relative; }
        .dots-left{ position:absolute; top:20px; left:20px; width:180px; height:120px; background-image:radial-gradient(#6ee7b7 1.5px,transparent 1.5px); background-size:20px 20px; opacity:.6; z-index:0; }
        .dots-right{ position:absolute; top:180px; right:40px; width:180px; height:180px; background-image:radial-gradient(#6ee7b7 1.5px,transparent 1.5px); background-size:20px 20px; opacity:.6; z-index:0; }
        .wave{ position:absolute; left:0; bottom:0; width:100%; height:260px; overflow:hidden; z-index:0; }
        .wave::before{ content:""; position:absolute; width:140%; height:220px; left:-20%; bottom:60px; background:rgba(16,185,129,.1); border-radius:50%; }
        .wave::after{ content:""; position:absolute; width:140%; height:180px; left:-20%; bottom:-20px; background:rgba(5,150,105,.2); border-radius:50%; }
        .login-card{ background:#fff; border-radius:22px; box-shadow:0 10px 30px rgba(6, 78, 59,.08), 0 20px 60px rgba(6, 78, 59,.12); }
        .input-field{ height:50px; border:1px solid #cbd5e1; border-radius:10px; transition:.25s; }
        .input-field:focus{ outline:none; border-color:#059669; box-shadow:0 0 0 3px rgba(5,150,105,.15); }
        .login-btn{ background:linear-gradient(90deg,#059669,#065f46); transition:.3s; }
        .login-btn:hover{ background:linear-gradient(90deg,#065f46,#064e3b); }
    </style>
</head>

<body>
    <div class="dots-left"></div>
    <div class="dots-right"></div>
    <div class="wave"></div>

    <div class="relative z-10 flex flex-col items-center pt-8 pb-8 px-4">
        <div class="flex items-center justify-center gap-5 mb-4">
            <img src="{{ asset('assets/img/logo_disperindagkopukm.png') }}" alt="Logo Disperindagkop" class="w-[300px] md:w-[350px] h-auto object-contain">
            <div class="w-px h-16 bg-emerald-400"></div>
            <img src="{{ asset('assets/img/LAMBANG_KABUPATEN_KARAWANG.png') }}" alt="Logo Karawang" class="h-20 md:h-24 w-auto object-contain">
        </div>

        <div class="login-card w-full max-w-2xl border border-emerald-50 px-10 md:px-12 py-8 mt-0">
            <div class="text-center mb-6">
                <div class="flex items-center justify-center gap-3 mb-2">
                    <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                    <h1 class="text-3xl font-bold text-slate-800">Login Koperasi</h1>
                </div>
                <p class="text-sm text-gray-500">Sistem Informasi Pengawasan & Pelaporan Koperasi</p>
                <hr class="mt-4 border-emerald-100">
            </div>

            {{-- FORM LOGIN --}}
            <form action="{{ route('login.koperasi') }}" method="POST" class="space-y-4">
                @csrf

                {{-- Pastikan name atribut sama dengan yang di-validate di AuthController --}}
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">email</label>
                    <div class="relative">
                        <input type="text" name="email" value="{{ old('email') }}" placeholder="Masukkan NIK atau ID Koperasi" required class="input-field w-full px-4 pr-12">
                        <span class="absolute right-4 top-3 text-emerald-400 text-lg">🏢</span>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Password</label>
                    <div class="relative">
                        <input type="password" name="password" placeholder="Masukkan password Anda" required class="input-field w-full px-4 pr-12">
                        <span class="absolute right-4 top-3 text-emerald-400 text-lg">🔒</span>
                    </div>
                </div>

                @if ($errors->any())
                    <div class="text-red-500 text-sm mt-2 text-center">
                        {{ $errors->first() }}
                    </div>
                @endif

                <button type="submit" class="login-btn w-full h-12 rounded-lg text-white font-semibold shadow-md">
                    Login Koperasi
                </button>
            </form>

            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    Koperasi baru? <a href="#" class="font-bold text-emerald-600 hover:underline">Registrasi Koperasi</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>