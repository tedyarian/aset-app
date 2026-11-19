@extends('asset::layouts.app')

@section('title', 'Transaksi & Operasional Aset')
@section('header-title', 'Transaksi & Operasional Aset')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">

    @if(session('success'))
        <div class="bg-emerald-100 border border-emerald-400 text-emerald-700 px-4 py-3 rounded-xl text-xs flex justify-between items-center">
            <span>{{ session('success') }}</span>
            <span class="font-bold cursor-pointer" onclick="this.parentElement.style.display='none'">&times;</span>
        </div>
    @endif

    <!-- 3 TOMBOL MODUL OPERASIONAL -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        
        <!-- CARD 1: MUTASI -->
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm space-y-3 flex flex-col justify-between">
            <div>
                <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-lg mb-2">
                    ⇄
                </div>
                <h3 class="text-sm font-bold text-slate-800">1. Mutasi / Perpindahan Aset</h3>
                <p class="text-xs text-slate-500 mt-1">Mencatat perpindahan aset dari satu lokasi/ruangan ke lokasi lain, atau perpindahan penanggung jawab.</p>
            </div>
            <a href="{{ route('transactions.mutation.create') }}" class="w-full text-center bg-blue-600 text-white text-xs px-4 py-2 rounded-lg font-medium hover:bg-blue-700 transition">
                + Input Mutasi Aset
            </a>
        </div>

        <!-- CARD 2: PEMINJAMAN & PENGEMBALIAN -->
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm space-y-3 flex flex-col justify-between">
            <div>
                <div class="w-10 h-10 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-lg mb-2">
                    📋
                </div>
                <h3 class="text-sm font-bold text-slate-800">2. Peminjaman & Pengembalian</h3>
                <p class="text-xs text-slate-500 mt-1">Menu khusus aset portabel (laptop, proyektor, kamera) yang dipinjam karyawan. Memuat tanggal, batas, dan kondisi.</p>
            </div>
            <a href="{{ route('transactions.loan.create') }}" class="w-full text-center bg-emerald-600 text-white text-xs px-4 py-2 rounded-lg font-medium hover:bg-emerald-700 transition">
                + Pinjam / Kembalikan Aset
            </a>
        </div>

        <!-- CARD 3: PERAWATAN & PERBAIKAN -->
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm space-y-3 flex flex-col justify-between">
            <div>
                <div class="w-10 h-10 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center font-bold text-lg mb-2">
                    🛠
                </div>
                <h3 class="text-sm font-bold text-slate-800">3. Perawatan & Perbaikan</h3>
                <p class="text-xs text-slate-500 mt-1">Mencatat jadwal servis berkala, riwayat kerusakan, biaya perbaikan, serta teknisi atau vendor yang menangani.</p>
            </div>
            <a href="{{ route('transactions.maintenance.create') }}" class="w-full text-center bg-amber-600 text-white text-xs px-4 py-2 rounded-lg font-medium hover:bg-amber-700 transition">
                + Catat Maintenance
            </a>
        </div>

    </div>

    <!-- TABEL RIWAYAT OPERASIONAL TERBARU -->
    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm space-y-4">
        <h3 class="text-xs font-bold text-slate-700 uppercase tracking-wider">Riwayat Operasional Terbaru</h3>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="border-b text-slate-400">
                        <th class="py-2">Tanggal</th>
                        <th class="py-2">Jenis Transaksi</th>
                        <th class="py-2">Nama / Kode Aset</th>
                        <th class="py-2">Keterangan / Detail</th>
                        <th class="py-2 text-right">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($mutations as $m)
                        <tr>
                            <td class="py-2.5 text-slate-600">{{ $m->mutation_date }}</td>
                            <td class="py-2.5"><span class="px-2 py-0.5 rounded text-[10px] font-medium bg-blue-100 text-blue-700">Mutasi</span></td>
                            <td class="py-2.5 font-bold text-slate-700">{{ $m->asset->name ?? '-' }}</td>
                            <td class="py-2.5 text-slate-600">Pindah ke {{ $m->toRoom->name ?? '-' }} (PIC: {{ $m->to_pic ?? '-' }})</td>
                            <td class="py-2.5 text-right"><span class="text-emerald-600 font-semibold">Selesai</span></td>
                        </tr>
                    @empty
                    @endforelse

                    @forelse($loans as $l)
                        <tr>
                            <td class="py-2.5 text-slate-600">{{ $l->loan_date }}</td>
                            <td class="py-2.5"><span class="px-2 py-0.5 rounded text-[10px] font-medium bg-emerald-100 text-emerald-700">Peminjaman</span></td>
                            <td class="py-2.5 font-bold text-slate-700">{{ $l->asset->name ?? '-' }}</td>
                            <td class="py-2.5 text-slate-600">Dipinjam oleh: {{ $l->borrower_name }} (Kembali: {{ $l->due_date }})</td>
                            <td class="py-2.5 text-right font-medium text-amber-600">{{ $l->status }}</td>
                        </tr>
                    @empty
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection