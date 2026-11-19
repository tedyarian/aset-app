<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Workspace App')</title>
  <!-- Tailwind CSS / Vite / Bootstrap bawaan -->
    <!-- @vite(['resources/css/app.css', 'resources/js/app.js']) -->
  <!-- CSS Print Global -->
    <!-- <link rel="stylesheet" href="{{ asset('css/print.css') }}"> -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Alpine.js untuk Interaksi Dropdown Sidebar -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-slate-100 font-sans">
    
    <div class="flex h-screen overflow-hidden">
        
        <!-- Sidebar Menu -->
        <div class="w-64 bg-slate-900 text-white flex flex-col">
            <div class="p-5 text-xl font-bold tracking-wider border-b border-slate-800">Workspace App</div>
            <nav class="flex-1 p-4 space-y-2 text-sm overflow-y-auto">
                <a href="{{ route('dashboard') }}" class="block px-4 py-2.5 rounded {{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white font-medium' : 'hover:bg-slate-800 text-slate-300' }}">Dashboard</a>
                <a href="{{ route('inventory.index') }}" class="block px-4 py-2.5 rounded {{ request()->routeIs('inventory.*') ? 'bg-blue-600 text-white font-medium' : 'hover:bg-slate-800 text-slate-300' }}">Manajemen Aset</a>
                
                <!-- Master Data dengan Sub Menu Dropdown -->
                <div class="space-y-1" x-data="{ open: {{ request()->routeIs('master.*') ? 'true' : 'false' }} }">
                    <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-2.5 rounded {{ request()->routeIs('master.*') ? 'bg-blue-600/20 text-white font-medium' : 'hover:bg-slate-800 text-slate-300' }}">
                        <span>Master Data</span>
                        <svg :class="{'rotate-180': open}" class="w-4 h-4 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </button>

                    <!-- Sub Menu Turunan -->
                    
                    <div x-show="open" x-cloak class="pl-4 space-y-1 pt-1">
                        <a href="{{ route('master.department.index') }}" class="block px-4 py-2 rounded text-xs {{ request()->routeIs('master.department.*') ? 'bg-blue-600 text-white font-medium' : 'hover:bg-slate-800 text-slate-400 hover:text-white' }}">
                            - Daftar Departemen/Divisi
                        </a>
                        <a href="{{ route('master.location.index') }}" class="block px-4 py-2 rounded text-xs {{ request()->routeIs('master.location.*') ? 'bg-blue-600 text-white font-medium' : 'hover:bg-slate-800 text-slate-400 hover:text-white' }}">
                            - Daftar Lokasi
                        </a>
                        <a href="{{ route('master.room.index') }}" class="block px-4 py-2 rounded text-xs {{ request()->routeIs('master.room.*') ? 'bg-blue-600 text-white font-medium' : 'hover:bg-slate-800 text-slate-400 hover:text-white' }}">
                            - Daftar Ruang
                        </a>
                        <a href="{{ route('master.status-barang.index') }}" class="block px-4 py-2 rounded text-xs {{ request()->routeIs('master.status.*') ? 'bg-blue-600 text-white font-medium' : 'hover:bg-slate-800 text-slate-400 hover:text-white' }}">
                            - Daftar Status Barang
                        </a>
                        <a href="{{ route('master.sumber-dana.index') }}" class="block px-4 py-2 rounded text-xs {{ request()->routeIs('master.dana.*') ? 'bg-blue-600 text-white font-medium' : 'hover:bg-slate-800 text-slate-400 hover:text-white' }}">
                            - Daftar Sumber Dana
                        </a>
                        <a href="{{ route('master.kop.index') }}" class="block px-4 py-2 rounded text-xs {{ request()->routeIs('master.kop.*') ? 'bg-blue-600 text-white font-medium' : 'hover:bg-slate-800 text-slate-400 hover:text-white' }}">
                            - KOP Institusi
                        </a>
                    </div>
                

                <a href="{{ route('transactions.index') }}" class="block px-4 py-2.5 rounded {{ request()->routeIs('transactions.*') ? 'bg-blue-600 text-white font-medium' : 'hover:bg-slate-800 text-slate-300' }}">Transaksi & Mutasi</a>
                <a href="{{ route('audits.index') }}" class="block px-4 py-2.5 rounded {{ request()->routeIs('audits.*') ? 'bg-blue-600 text-white font-medium' : 'hover:bg-slate-800 text-slate-300' }}">Audit & Opname</a>
                <a href="{{ route('reports.index') }}" class="block px-4 py-2.5 rounded {{ request()->routeIs('reports.*') ? 'bg-blue-600 text-white font-medium' : 'hover:bg-slate-800 text-slate-300' }}">Laporan (Reports)</a>
                <a href="{{ route('settings.index') }}" class="block px-4 py-2.5 rounded {{ request()->routeIs('settings.*') ? 'bg-blue-600 text-white font-medium' : 'hover:bg-slate-800 text-slate-300' }}">Pengaturan</a>
            </nav>
                <div class="p-4 border-t border-slate-800">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-2 rounded text-red-400 hover:bg-slate-800 text-sm">Logout</button>
                </form>
            </div>
        </div>

        <!-- MAIN CONTENT AREA -->
        <div class="flex-1 flex flex-col overflow-y-auto">
            <header class="bg-white shadow-sm h-16 flex items-center justify-between px-8">
                <h1 class="text-lg font-semibold text-slate-700">@yield('header-title', 'Aplikasi Manajemen Aset')</h1>
                <span class="font-medium text-slate-800">{{ Auth::user()->name ?? 'Admin' }}</span>
            </header>

            <main class="p-8">
                <!-- Flash Message Global -->
                @if(session('success'))
                    <div class="mb-6 bg-emerald-100 border border-emerald-400 text-emerald-700 px-4 py-3 rounded-lg text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Bagian ini akan diisi dinamis oleh halaman lain -->
              <div class="flex-1 p-6">
                @yield('content')
              </div>
            </main>
        </div>

    </div>
    
</body>
</html>