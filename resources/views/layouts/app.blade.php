<!DOCTYPE html>
<html lang="id" x-data="{ 
    darkMode: localStorage.getItem('theme') === 'dark',
    toggleTheme() {
        this.darkMode = !this.darkMode;
        localStorage.setItem('theme', this.darkMode ? 'dark' : 'light');
    }
}" :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') | AKURAT - DinkopUKM</title>
    
    <script>
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        }
    </script>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        emerald: {
                            600: '#008f5d',
                            700: '#064e3b',
                            800: '#064e3b',
                            900: '#022c22',
                            950: '#021813'
                        }
                    }
                }
            }
        }
    </script>

    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Plus Jakarta Sans', sans-serif; transition: background-color 0.3s ease; }
        .sidebar-active { background-color: rgba(255, 255, 255, 0.2); backdrop-filter: blur(4px); border: 1px solid rgba(255, 255, 255, 0.3); }
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.3); border-radius: 10px; }
        #main-sidebar { width: 88px; transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1); }
        @media (min-width: 1024px) {
            #main-sidebar:hover { width: 288px; }
            #main-sidebar:not(:hover) .nav-text, 
            #main-sidebar:not(:hover) .menu-header,
            #main-sidebar:not(:hover) .brand-text { opacity: 0; display: none; }
        }
    </style>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
</head>
<body class="antialiased text-slate-800 bg-[#f0f9f4] dark:bg-emerald-950 dark:text-emerald-50 transition-colors duration-300">

    <div class="flex min-h-screen overflow-hidden">
        <aside id="main-sidebar" class="bg-emerald-600 dark:bg-emerald-900 h-screen flex flex-col z-40 shadow-2xl shrink-0 overflow-hidden group border-r border-emerald-700/50">
            <div class="p-6 h-24 flex items-center shrink-0 border-b border-emerald-700/30 overflow-hidden">
                <div class="flex items-center gap-3 whitespace-nowrap">
                    <div class="bg-white p-2 rounded-xl shadow-lg shrink-0"><i class="fas fa-landmark text-emerald-600 text-lg"></i></div>
                    <span class="brand-text font-black text-xl tracking-tighter uppercase text-white transition-opacity duration-300">AKURAT</span>
                </div>
            </div>

            <nav class="flex-1 px-4 mt-6 overflow-y-auto custom-scrollbar space-y-2">
                @php 
                    $role = trim(strtolower(auth()->user()->role ?? '')); 
                @endphp

                @if($role === 'admin' || $role === 'admin_dinas')
                    <a href="{{ route('admin.dashboard') }}" class="nav-item flex items-center py-4 px-5 rounded-2xl transition-all {{ request()->routeIs('admin.dashboard') ? 'sidebar-active text-white' : 'text-white/80 hover:text-white hover:bg-white/10' }}">
                        <i class="fas fa-chart-line w-6 text-center shrink-0"></i><span class="nav-text ml-3 font-bold text-sm tracking-wide">Dashboard</span>
                    </a>
                    <div class="menu-header px-4 py-3 text-[10px] font-black uppercase tracking-[0.2em] text-emerald-200/50 mt-4 transition-opacity">Manajemen Data</div>
                    <a href="{{ route('admin.pengguna.index') }}" class="nav-item flex items-center py-4 px-5 rounded-2xl transition-all text-white/80 hover:text-white hover:bg-white/10"><i class="fas fa-users w-6 text-center shrink-0"></i><span class="nav-text ml-3 text-sm">Data Pengguna</span></a>
                    <a href="{{ route('admin.koperasi.index') }}" class="nav-item flex items-center py-4 px-5 rounded-2xl transition-all text-white/80 hover:text-white hover:bg-white/10"><i class="fas fa-building w-6 text-center shrink-0"></i><span class="nav-text ml-3 text-sm">Data Koperasi</span></a>
                    <a href="{{ route('admin.wilayah.index') }}" class="nav-item flex items-center py-4 px-5 rounded-2xl transition-all text-white/80 hover:text-white hover:bg-white/10"><i class="fas fa-map-marked-alt w-6 text-center shrink-0"></i><span class="nav-text ml-3 text-sm">Data Wilayah</span></a>
                    <div class="menu-header px-4 py-3 text-[10px] font-black uppercase tracking-[0.2em] text-emerald-200/50 transition-opacity">Laporan</div>
                    <a href="{{ route('admin.verifikasi.index') }}" class="nav-item flex items-center py-4 px-5 rounded-2xl transition-all text-white/80 hover:text-white hover:bg-white/10"><i class="fas fa-file-invoice w-6 text-center shrink-0"></i><span class="nav-text ml-3 text-sm">Data RAT</span></a>

                @elseif($role === 'koperasi')
                    <a href="{{ route('dashboard.koperasi') }}" class="nav-item flex items-center py-4 px-5 rounded-2xl transition-all text-white/80 hover:text-white hover:bg-white/10">
                        <i class="fas fa-chart-line w-6 text-center shrink-0"></i><span class="nav-text ml-3 font-bold text-sm tracking-wide">Dashboard</span>
                    </a>
                    <div class="menu-header px-4 py-3 text-[10px] font-black uppercase tracking-[0.2em] text-emerald-200/50 mt-4 transition-opacity">Modul Koperasi</div>
                    <a href="#" class="nav-item flex items-center py-4 px-5 rounded-2xl transition-all text-white/80 hover:text-white hover:bg-white/10"><i class="fas fa-file-upload w-6 text-center shrink-0"></i><span class="nav-text ml-3 text-sm">Laporan RAT</span></a>
                    <a href="#" class="nav-item flex items-center py-4 px-5 rounded-2xl transition-all text-white/80 hover:text-white hover:bg-white/10"><i class="fas fa-notes-medical w-6 text-center shrink-0"></i><span class="nav-text ml-3 text-sm">PEMKES</span></a>
                    <a href="#" class="nav-item flex items-center py-4 px-5 rounded-2xl transition-all text-white/80 hover:text-white hover:bg-white/10"><i class="fas fa-medal w-6 text-center shrink-0"></i><span class="nav-text ml-3 text-sm">Hasil Penilaian</span></a>
                    <a href="#" class="nav-item flex items-center py-4 px-5 rounded-2xl transition-all text-white/80 hover:text-white hover:bg-white/10"><i class="fas fa-user-circle w-6 text-center shrink-0"></i><span class="nav-text ml-3 text-sm">Profil Koperasi</span></a>

                @elseif($role === 'pengawas' || $role === 'pengawas_lapangan')
                    <a href="{{ route('pengawas.dashboard') }}" class="nav-item flex items-center py-4 px-5 rounded-2xl transition-all {{ request()->routeIs('pengawas.dashboard') ? 'sidebar-active text-white' : 'text-white/80 hover:text-white hover:bg-white/10' }}">
                        <i class="fas fa-chart-line w-6 text-center shrink-0"></i><span class="nav-text ml-3 font-bold text-sm tracking-wide">Dashboard</span>
                    </a>
                    <div class="menu-header px-4 py-3 text-[10px] font-black uppercase tracking-[0.2em] text-emerald-200/50 mt-4 transition-opacity">Tugas Pengawasan</div>
                    <a href="{{ route('pengawas.rat.index') }}" class="nav-item flex items-center py-4 px-5 rounded-2xl transition-all {{ request()->routeIs('pengawas.rat.*') ? 'sidebar-active text-white' : 'text-white/80 hover:text-white hover:bg-white/10' }}"><i class="fas fa-check-double w-6 text-center shrink-0"></i><span class="nav-text ml-3 text-sm">Verifikasi RAT</span></a>
                    <a href="{{ route('pengawas.lapangan.index') }}" class="nav-item flex items-center py-4 px-5 rounded-2xl transition-all {{ request()->routeIs('pengawas.lapangan.*') ? 'sidebar-active text-white' : 'text-white/80 hover:text-white hover:bg-white/10' }}"><i class="fas fa-clipboard-check w-6 text-center shrink-0"></i><span class="nav-text ml-3 text-sm">Verifikasi Lapangan</span></a>
                    <a href="{{ route('pengawas.koperasi.index') }}" class="nav-item flex items-center py-4 px-5 rounded-2xl transition-all {{ request()->routeIs('pengawas.koperasi.*') ? 'sidebar-active text-white' : 'text-white/80 hover:text-white hover:bg-white/10' }}"><i class="fas fa-building w-6 text-center shrink-0"></i><span class="nav-text ml-3 text-sm">Data Koperasi</span></a>
                    <a href="{{ route('pengawas.profil.index') }}" class="nav-item flex items-center py-4 px-5 rounded-2xl transition-all {{ request()->routeIs('pengawas.profil.*') ? 'sidebar-active text-white' : 'text-white/80 hover:text-white hover:bg-white/10' }}"><i class="fas fa-user-shield w-6 text-center shrink-0"></i><span class="nav-text ml-3 text-sm">Profil Pengawas</span></a>

                @elseif($role === 'pimpinan')
                    <a href="{{ route('pimpinan.dashboard') }}" class="nav-item flex items-center py-4 px-5 rounded-2xl transition-all {{ request()->routeIs('pimpinan.dashboard') ? 'sidebar-active text-white' : 'text-white/80 hover:text-white hover:bg-white/10' }}">
                        <i class="fas fa-chart-line w-6 text-center shrink-0"></i><span class="nav-text ml-3 font-bold text-sm tracking-wide">Dashboard</span>
                    </a>
                    <div class="menu-header px-4 py-3 text-[10px] font-black uppercase tracking-[0.2em] text-emerald-200/50 mt-4 transition-opacity">Monitoring</div>
                    <a href="{{ route('pimpinan.laporan.index') }}" class="nav-item flex items-center py-4 px-5 rounded-2xl transition-all text-white/80 hover:text-white hover:bg-white/10"><i class="fas fa-file-alt w-6 text-center shrink-0"></i><span class="nav-text ml-3 text-sm">Tinjau Laporan</span></a>
                @endif
            </nav>

            <div class="p-4">
                <button onclick="confirmLogout()" class="w-full flex items-center justify-center py-4 rounded-2xl bg-emerald-700/50 hover:bg-emerald-700 transition-all font-bold text-white">
                    <i class="fas fa-power-off w-6 text-center shrink-0"></i>
                    <span class="nav-text ml-3 text-sm uppercase tracking-widest">Logout</span>
                </button>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
            </div>
        </aside>

        <main class="flex-1 flex flex-col h-screen overflow-hidden">
            <header class="h-20 bg-white dark:bg-emerald-900 border-b border-emerald-100 dark:border-emerald-800 flex justify-between items-center px-10 shrink-0">
                <h1 class="text-2xl font-black uppercase tracking-tighter italic text-emerald-900 dark:text-white">@yield('title')</h1>
                <div class="flex items-center gap-4">
                    <span class="px-3 py-1 text-[10px] font-black uppercase tracking-widest rounded-lg {{ $role == 'admin' || $role == 'admin_dinas' ? 'bg-red-100 text-red-600' : ($role == 'pimpinan' ? 'bg-blue-100 text-blue-600' : ($role == 'pengawas' || $role == 'pengawas_lapangan' ? 'bg-amber-100 text-amber-600' : 'bg-emerald-100 text-emerald-600')) }}">
                        {{ str_replace('_', ' ', $role) }}
                    </span>
                    <button @click="toggleTheme()" class="w-10 h-10 rounded-xl bg-emerald-50 dark:bg-emerald-800 flex items-center justify-center hover:scale-105 transition-all text-emerald-600 dark:text-yellow-400">
                        <i x-show="!darkMode" class="fas fa-moon"></i>
                        <i x-show="darkMode" class="fas fa-sun" x-cloak></i>
                    </button>
                    <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name ?? 'User' }}&background=008f5d&color=fff" class="w-10 h-10 rounded-full border-2 border-white dark:border-emerald-700 shadow-lg">
                </div>
            </header>

            <div class="flex-1 overflow-y-auto p-10 custom-scrollbar">
                <div class="max-w-7xl mx-auto">
                    @yield('content')
                </div>
            </div>
        </main>
    </div>

    <script>
        function confirmLogout() {
            Swal.fire({
                title: 'Yakin ingin keluar?',
                text: "Anda akan mengakhiri sesi login saat ini.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#008f5d',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Logout',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }
            })
        }
    </script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
</body>
</html>