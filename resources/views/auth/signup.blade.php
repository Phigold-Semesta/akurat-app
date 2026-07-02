<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Registrasi Koperasi | AKURAT</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-[#e6f7f0] min-h-screen flex items-center justify-center p-6">
    <div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-md border border-emerald-100">
        <h2 class="text-2xl font-black text-emerald-900 text-center mb-6 italic">Registrasi Koperasi</h2>
        
        <form action="{{ route('signup') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-bold text-emerald-900">Nama Koperasi</label>
                <input type="text" name="nama_koperasi" class="w-full p-3 rounded-xl border border-emerald-200 focus:ring-2 focus:ring-emerald-600 outline-none" required>
            </div>
            <div>
                <label class="block text-sm font-bold text-emerald-900">Email</label>
                <input type="email" name="email" class="w-full p-3 rounded-xl border border-emerald-200 focus:ring-2 focus:ring-emerald-600 outline-none" required>
            </div>
            <div>
                <label class="block text-sm font-bold text-emerald-900">Password</label>
                <input type="password" name="password" class="w-full p-3 rounded-xl border border-emerald-200 focus:ring-2 focus:ring-emerald-600 outline-none" required>
            </div>
            <div>
                <label class="block text-sm font-bold text-emerald-900">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="w-full p-3 rounded-xl border border-emerald-200 focus:ring-2 focus:ring-emerald-600 outline-none" required>
            </div>
            <button type="submit" class="w-full bg-emerald-800 text-white py-3 rounded-xl font-bold hover:bg-emerald-900 transition-all shadow-lg shadow-emerald-800/20">
                Daftar Koperasi
            </button>
        </form>
        
        <p class="text-center text-sm mt-4 text-emerald-800 font-medium">Sudah punya akun? 
            <a href="{{ route('login.koperasi') }}" class="text-emerald-600 font-bold hover:underline">Login Koperasi</a>
        </p>
    </div>

    @if(session('status') == 'registrasi_berhasil')
    <script>
        Swal.fire({
            title: 'Berhasil!',
            text: 'Akun koperasi Anda telah terdaftar. Silakan login.',
            icon: 'success',
            confirmButtonColor: '#064e3b',
            confirmButtonText: 'Login Sekarang'
        });
    </script>
    @endif
</body>
</html>