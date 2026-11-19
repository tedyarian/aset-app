@extends('asset::layouts.app')

@section('title', 'Menu Laporan Aset')
@section('header-title', 'Pusat Laporan & Rekapitulasi Aset')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        
        <!-- 1. Laporan Posisi Aset -->
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex flex-col justify-between space-y-3">
            <div>
                <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-lg mb-2">📍</div>
                <h3 class="text-sm font-bold text-slate-800">1. Laporan Posisi Aset</h3>
                <p class="text-xs text-slate-500 mt-1">Rekapitulasi aset berdasarkan lokasi, kategori, atau departemen secara real-time.</p>
            </div>
            <a href="{{ route('reports.position') }}" class="w-full text-center bg-blue-600 text-white text-xs px-4 py-2 rounded-lg font-medium hover:bg-blue-700 transition">
                Buka Laporan Posisi
            </a>
        </div>

        <!-- Kartu Tambahan: Laporan Barang per Ruangan -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200 flex flex-col justify-between space-y-4">
            <div class="space-y-2">
                <div class="w-10 h-10 rounded-lg bg-indigo-50 flex items-center justify-center text-indigo-600 font-bold text-lg">
                    🏢
                </div>
                <h3 class="text-sm font-bold text-slate-800">5. Laporan barang berdasarkan Ruangan</h3>
                <p class="text-xs text-slate-500 leading-relaxed">
                    Daftar Inventaris Ruangan (DIR) lengkap dengan rincian unit, kondisi, dan penanggung jawab per ruangan.
                </p>
            </div>
            <a href="{{ route('reports.room') }}" class="w-full text-center bg-indigo-600 text-white text-xs font-semibold py-2.5 rounded-lg hover:bg-indigo-700 transition">
                Buka Laporan Ruangan
            </a>
        </div>

        <!-- 2. Laporan Keuangan & Penyusutan -->
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex flex-col justify-between space-y-3">
            <div>
                <div class="w-10 h-10 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-lg mb-2">📊</div>
                <h3 class="text-sm font-bold text-slate-800">2. Laporan Keuangan & Penyusutan (Depreciation)</h3>
                <p class="text-xs text-slate-500 mt-1">Menghitung nilai susut aset setiap tahunnya untuk keperluan akuntansi dan audit.</p>
            </div>
            <a href="{{ route('reports.depreciation') }}" class="w-full text-center bg-emerald-600 text-white text-xs px-4 py-2 rounded-lg font-medium hover:bg-emerald-700 transition">
                Buka Laporan Penyusutan
            </a>
        </div>

        <!-- 3. Laporan Perawatan -->
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex flex-col justify-between space-y-3">
            <div>
                <div class="w-10 h-10 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center font-bold text-lg mb-2">🛠️</div>
                <h3 class="text-sm font-bold text-slate-800">3. Laporan Perawatan</h3>
                <p class="text-xs text-slate-500 mt-1">Rekap total biaya operasional dan perbaikan/servis aset dalam periode tertentu.</p>
            </div>
            <a href="{{ route('reports.maintenance') }}" class="w-full text-center bg-amber-600 text-white text-xs px-4 py-2 rounded-lg font-medium hover:bg-amber-700 transition">
                Buka Laporan Perawatan
            </a>
        </div>

        <!-- 4. Laporan Penghapusan Aset -->
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex flex-col justify-between space-y-3">
            <div>
                <div class="w-10 h-10 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center font-bold text-lg mb-2">🗑️</div>
                <h3 class="text-sm font-bold text-slate-800">4. Laporan Penghapusan Aset</h3>
                <p class="text-xs text-slate-500 mt-1">Daftar aset yang sudah rusak total atau dijual kembali (disposed).</p>
            </div>
            <a href="{{ route('reports.disposal') }}" class="w-full text-center bg-rose-600 text-white text-xs px-4 py-2 rounded-lg font-medium hover:bg-rose-700 transition">
                Buka Laporan Penghapusan
            </a>
        </div>

    </div>

</div>
@endsection