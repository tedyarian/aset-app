<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Akses Ditolak | Sistem Informasi Barang</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-900 text-slate-100 flex items-center justify-center min-h-screen px-4 relative overflow-hidden">

    <!-- Efek Cahaya Background -->
    <div class="absolute -top-32 -left-32 w-96 h-96 bg-red-600/15 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-32 -right-32 w-96 h-96 bg-blue-600/15 rounded-full blur-3xl pointer-events-none"></div>

    <!-- Card Container -->
    <div class="max-w-md w-full bg-slate-800/80 backdrop-blur-xl border border-slate-700/60 rounded-2xl shadow-2xl p-8 text-center relative z-10">
        
        <!-- Ikon Peringatan -->
        <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-red-500/10 text-red-400 border border-red-500/20 mb-6 shadow-inner">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M18.364 5.636l-12.728 12.728m0-12.728l12.728 12.728M12 9v3.75m0 3.75h.008v.008H12v-.008z" />
            </svg>
        </div>

        <!-- Kode & Pesan -->
        <span class="text-xs font-bold tracking-widest uppercase text-red-400 bg-red-500/10 px-3 py-1 rounded-full border border-red-500/20">Error 403 • Unauthorized</span>
        
        <h1 class="text-2xl font-bold text-white mt-4 tracking-tight">Akses Modul Dibatasi</h1>
        <p class="text-sm text-slate-400 mt-2 leading-relaxed">
            Maaf, akun Anda tidak memiliki hak akses untuk masuk ke modul atau halaman ini. Silakan hubungi Super Admin untuk meminta izin akses.
        </p>

        <!-- Tombol Navigasi Kembali -->
        <div class="mt-8 flex flex-col gap-3">
            <a href="{{ url()->previous() }}" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 px-4 rounded-xl text-sm transition shadow-lg shadow-blue-600/30 flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
                <span>Kembali ke Halaman Sebelumnya</span>
            </a>
            
            <a href="/dashboard" class="w-full bg-slate-700 hover:bg-slate-600 text-slate-200 font-medium py-2 px-4 rounded-xl text-xs transition">
                Ke Dashboard Utama
            </a>
        </div>
        
        <div class="mt-6 pt-5 border-t border-slate-700/50 text-xs text-slate-500">
            Sistem Informasi Barang & Inventaris
        </div>
    </div>

</body>
</html>