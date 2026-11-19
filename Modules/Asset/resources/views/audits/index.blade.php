@extends('asset::layouts.app')

@section('title', 'Audit & Stok Opname')
@section('header-title', 'Manajemen Audit & Stok Opname Aset')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">

    @if(session('success'))
        <div class="bg-emerald-100 border border-emerald-400 text-emerald-700 px-4 py-3 rounded-xl text-xs flex justify-between items-center">
            <span>{{ session('success') }}</span>
            <span class="font-bold cursor-pointer" onclick="this.parentElement.style.display='none'">&times;</span>
        </div>
    @endif

    <!-- KARTU MENU UTAMA SESUAI GAMBAR -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        
        <!-- Sesi Audit -->
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex flex-col justify-between space-y-3">
            <div>
                <div class="w-10 h-10 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center font-bold text-lg mb-2">📅</div>
                <h3 class="text-sm font-bold text-slate-800">1. Sesi Audit</h3>
                <p class="text-xs text-slate-500 mt-1">Membuat jadwal stock opname tahunan atau bulanan untuk inventaris ruangan.</p>
            </div>
            <a href="{{ route('audits.create') }}" class="w-full text-center bg-indigo-600 text-white text-xs px-4 py-2 rounded-lg font-medium hover:bg-indigo-700 transition">
                + Buat Sesi Audit Baru
            </a>
        </div>

        <!-- Scan Barcode Audit -->
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex flex-col justify-between space-y-3">
            <div>
                <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-lg mb-2">📷</div>
                <h3 class="text-sm font-bold text-slate-800">2. Scan Barcode Audit</h3>
                <p class="text-xs text-slate-500 mt-1">Fitur pemindaian menggunakan kamera HP atau scanner untuk mencatat aset saat audit.</p>
            </div>
            <span class="text-[11px] text-slate-400 italic">Pilih sesi aktif di bawah untuk mulai scan.</span>
        </div>

        <!-- Laporan Selisih (Discrepancy) -->
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm flex flex-col justify-between space-y-3">
            <div>
                <div class="w-10 h-10 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center font-bold text-lg mb-2">⚠️</div>
                <h3 class="text-sm font-bold text-slate-800">3. Laporan Selisih (Discrepancy)</h3>
                <p class="text-xs text-slate-500 mt-1">Menampilkan daftar aset tercatat di sistem tapi tidak ditemukan di lapangan.</p>
            </div>
            <span class="text-[11px] text-slate-400 italic">Tersedia pada detail laporan sesi.</span>
        </div>

    </div>

    <!-- DAFTAR SESI AUDIT -->
    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm space-y-4">
        <h3 class="text-xs font-bold text-slate-700 uppercase tracking-wider">Daftar Sesi Stock Opname</h3>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="border-b text-slate-400">
                        <th class="py-2">Nama Sesi Audit</th>
                        <th class="py-2">Periode</th>
                        <th class="py-2">Status</th>
                        <th class="py-2 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($sessions as $session)
                        <tr>
                            <td class="py-3 font-bold text-slate-700">{{ $session->session_name }}</td>
                            <td class="py-3 text-slate-600">{{ $session->start_date }} s/d {{ $session->end_date }}</td>
                            <td class="py-3">
                                <span class="px-2 py-0.5 rounded text-[10px] font-medium bg-amber-100 text-amber-700">{{ $session->status }}</span>
                            </td>
                            <td class="py-3 text-right space-x-2">
                                <a href="{{ route('audits.scan', $session->id) }}" class="px-3 py-1 bg-blue-50 text-blue-600 rounded-md hover:bg-blue-100 font-medium">Mulai Scan</a>
                                <a href="{{ route('audits.report', $session->id) }}" class="px-3 py-1 bg-rose-50 text-rose-600 rounded-md hover:bg-rose-100 font-medium">Laporan Selisih</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-4 text-center text-slate-400">Belum ada sesi audit yang dibuat.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection