@extends('asset::layouts.app')

@section('title', 'Laporan Posisi Aset')
@section('header-title', 'Laporan Posisi & Rekapitulasi Aset')

@section('content')
<div id="print-area" class="max-w-5xl mx-auto space-y-6">
    
    <!-- KOP SURAT DINAMIS (Hanya muncul saat dicetak) -->
    <div class="hidden print:block mb-2">
        @include('asset::reports.partials.kop')
    </div>

    <!-- Kontainer Utama Laporan -->
    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm space-y-4 print:border-none print:shadow-none print:p-0 print:m-0">
        
        <!-- Header Bagian Atas: Judul di Kiri dan Tombol Cetak di Kanan -->
        <div class="flex justify-between items-center print:hidden">
            <h3 class="text-xs font-bold text-slate-700 uppercase">DAFTAR REKAPITULASI POSISI ASET</h3>           
            <button onclick="window.print()" class="px-3 py-1.5 bg-slate-100 text-slate-600 rounded-lg text-xs font-medium hover:bg-slate-200 transition">🖨️ Cetak / PDF</button>
        </div>

        <!-- Judul khusus untuk cetak -->
        <div class="hidden print:block text-center mb-4">
            <h3 class="text-sm font-bold text-black uppercase">DAFTAR REKAPITULASI POSISI ASET</h3>
        </div>

        <div class="w-full">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="border-b-2 border-slate-300 text-slate-700 bg-slate-50 print:bg-transparent">
                        <th class="py-2 px-2 border border-slate-300 text-center" style="width: 5%;">No</th>
                        <th class="py-2 px-2 border border-slate-300" style="width: 18%;">Kode BMN</th>
                        <th class="py-2 px-2 border border-slate-300" style="width: 25%;">Nama Aset</th>
                        <th class="py-2 px-2 border border-slate-300" style="width: 22%;">Lokasi / Ruangan</th>
                        <th class="py-2 px-2 border border-slate-300" style="width: 15%;">PIC</th>
                        <th class="py-2 px-2 border border-slate-300 text-center" style="width: 15%;">Kondisi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($assets as $index => $asset)
                        <tr>
                            <td class="py-2 px-2 border border-slate-300 text-center">{{ $index + 1 }}</td>
                            <td class="py-2 px-2 border border-slate-300 font-bold text-slate-700">{{ $asset->asset_code ?? '-' }}</td>
                            <td class="py-2 px-2 border border-slate-300 text-slate-600">{{ $asset->name }}</td>
                            <td class="py-2 px-2 border border-slate-300 text-slate-600">
                                <div>{{ $asset->location->name ?? '-' }}</div>
                                <div class="text-xs text-gray-400">({{ $asset->room->name ?? '-' }})</div>
                            </td>
                            <!-- <td class="py-2 px-2 border border-slate-300 text-slate-600">{{ $asset->room->name ?? '-' }}</td> -->
                            <td class="py-2 px-2 border border-slate-300 text-slate-600">{{ $asset->pic ?? '-' }}</td>
                            <td class="py-2 px-2 border border-slate-300 text-slate-600 font-semibold text-center whitespace-nowrap">{{ $asset->status }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-4 text-center text-slate-400 border border-slate-300">Tidak ada data aset ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- TANDA TANGAN / PENGETAHUAN (Hanya muncul saat dicetak) -->
    <div class="print-footer hidden print:flex justify-between pt-10 text-xs text-slate-800 w-full">
        <div class="text-center space-y-12">
            <p>Mengetahui,<br>Kepala Unit / Pengelola Barang</p>
            <p class="font-bold underline">( _________________________ )</p>
        </div>
        <div class="text-center space-y-12">
            <p>Bengkulu, {{ date('d F Y') }}<br>Petugas / Pengurus Aset</p>
            <p class="font-bold underline">( Tedy Arian )</p>
        </div>
    </div>

    <div class="flex justify-end print:hidden">
        <a href="{{ route('reports.index') }}" class="px-4 py-2 bg-slate-100 text-slate-600 rounded-lg text-xs font-medium hover:bg-slate-200 transition">Kembali ke Menu Laporan</a>
    </div>
</div>

<!-- CSS KHUSUS PRINT LAPORAN -->
<style>
@media print {
    /* Sembunyikan seluruh elemen di dalam body halaman secara global */
    body * {
        visibility: hidden !important;
    }
    
    /* Hanya tampilkan #print-area beserta seluruh isinya */
    #print-area, #print-area * {
        visibility: visible !important;
    }
    
    /* Paksa posisi area cetak mulai dari pojok kiri atas kertas */
    #print-area {
        position: absolute !important;
        left: 0 !important;
        top: 0 !important;
        width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    .print\:block { display: block !important; }
    .print\:flex { display: flex !important; }
    .print\:hidden { display: none !important; }

    body {
        background: white !important;
        color: black !important;
    }

    table {
        width: 100% !important;
        border-collapse: collapse !important;
    }
    
     /* {
        border: 1px solid #cbd5e1 !important;
        padding: 6px 8px !important;
        font-size: 11px !important;
    } */
}
</style>
@endsection