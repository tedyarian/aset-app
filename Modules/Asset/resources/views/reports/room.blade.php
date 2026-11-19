@extends('asset::layouts.app')

@section('title', 'Laporan Barang Berdasarkan Ruangan')
@section('header-title', 'Laporan Inventaris Ruangan (DIR)')

@section('content')
<!-- BUNGKUS SELURUH KONTEN DENGAN ID INI -->
<div id="print-area" class="max-w-6xl mx-auto space-y-6">
     <!-- KOP SURAT DINAMIS -->
    <div class="hidden print:block mb-2">
        @include('asset::reports.partials.kop')
    </div>

    <!-- FORM FILTER RUANGAN -->
    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm space-y-4 print:border-none print:shadow-none print:p-0 print:m-0 print:hidden">
        <form action="{{ route('reports.room') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-end">
            
            <div class="flex-1">
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Pilih Gedung</label>
                <select name="location_id" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-xs bg-white focus:ring-2 focus:ring-indigo-500 outline-none" required>
                    <option value="">-- Pilih Gedung --</option>
                    @foreach($rooms as $room)
                        <option value="{{ $room->id }}" {{ $selectedRoomId == $room->id ? 'selected' : '' }}>
                            {{ $room->name }} ({{ $room->location ?? '-' }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex-1">
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Pilih Ruangan</label>
                <select name="room_id" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-xs bg-white focus:ring-2 focus:ring-indigo-500 outline-none" required>
                    <option value="">-- Pilih Ruangan --</option>
                    @foreach($rooms as $room)
                        <option value="{{ $room->id }}" {{ $selectedRoomId == $room->id ? 'selected' : '' }}>
                            {{ $room->name }} ({{ $room->location ?? '-' }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white text-xs font-semibold rounded-lg hover:bg-indigo-700 transition">
                    🔍 Tampilkan Laporan
                </button>
                @if($selectedRoomId)
                    <button type="button" onclick="window.print()" class="px-4 py-2 bg-slate-100 text-slate-700 text-xs font-semibold rounded-lg border border-slate-300 hover:bg-slate-200 transition">
                        🖨️ Cetak / PDF
                    </button>
                @endif
            </div>
        </form>
    </div>

    @if($selectedRoom)
   

    <!-- REKAP RUANGAN & TABEL ASET -->
    <div class="bg-white p-6 rounded-xl  shadow-sm space-y-4">
        
        <!-- JUDUL LAPORAN -->
        <div class="text-center mb-4">
            <h3 class="text-sm font-bold uppercase tracking-wider text-slate-900">DAFTAR BARANG RUANGAN</h3>
        </div>

       <!-- INFORMASI RUANG & GEDUNG -->
        <div class="text-xs text-slate-800 mb-3">
            <table style="width: auto; border: none; background: transparent; border-collapse: collapse;">
                <tr>
                    <td style="border: none; padding: 1px 0; font-weight: bold; width: 55px;">Ruang</td>
                    <td style="border: none; padding: 1px 4px; font-weight: bold; width: 10px; text-align: center;">:</td>
                    <td style="border: none; padding: 1px 0;">{{ $selectedRoom->name }}</td>
                </tr>
                <tr>
                    <td style="border: none; padding: 1px 0; font-weight: bold; width: 55px;">Gedung</td>
                    <td style="border: none; padding: 1px 4px; font-weight: bold; width: 10px; text-align: center;">:</td>
                    <td style="border: none; padding: 1px 0;">{{ $selectedRoom->location ?? '-' }}</td>
                </tr>
            </table>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs border-collapse">
                <thead>
                    <tr class="border-b-2 border-slate-300 text-slate-700 bg-slate-50 print:bg-transparent">
                        <th class="py-2 px-2 border border-slate-300 text-center" style="width: 5%;">No</th>
                        <th class="py-2 px-2 border border-slate-300" style="width: 18%;">Kode Barang</th>
                        <th class="py-2 px-2 border border-slate-300">Nama Barang</th>
                        <th class="py-2 px-2 border border-slate-300">Merek Tipe</th>
                        <th class="py-2 px-2 border border-slate-300 text-center" style="width: 8%;">Jumlah</th>
                        <th class="py-2 px-2 border border-slate-300 text-center" style="width: 10%;">Satuan</th>
                        <th class="py-2 px-2 border border-slate-300 text-center" style="width: 12%;">Ket</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($assets as $index => $item)
                        <tr>
                            <td class="py-1.5 px-2 border border-slate-300 text-center">{{ $index + 1 }}</td>
                            <td class="py-1.5 px-2 border border-slate-300 font-mono text-slate-800">{{ $item->code }}</td>
                            <td class="py-1.5 px-2 border border-slate-300 font-semibold text-slate-700">{{ $item->name }}</td>
                            <td class="py-1.5 px-2 border border-slate-300 text-slate-600">{{ $item->brand ?? '-' }}</td>
                            <td class="py-1.5 px-2 border border-slate-300 text-center">{{ $item->quantity }}</td>
                            <td class="py-1.5 px-2 border border-slate-300 text-center">{{ $item->unit ?? 'Unit' }}</td>
                            <td class="py-1.5 px-2 border border-slate-300 text-center">{{ $item->status ?? 'Baik' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-4 text-center text-slate-400 border border-slate-300">Belum ada aset terdaftar di ruangan ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- BAGIAN TANDA TANGAN (Hanya muncul saat dicetak) -->
    <div class="hidden print:block mt-10 text-xs text-slate-800" style="padding: 0 45px;">
        <table style="width: 100%; border: none; background: transparent;">
            <tr>
                <td style="width: 50%; border: none; vertical-align: top; text-align: left;">
                    Mengetahui,<br>
                    Kepala Unit / Pengelola Barang<br><br><br><br><br>
                    <b>( &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; )</b>
                </td>
                <td style="width: 50%; border: none; vertical-align: top; text-align: right;">
                    Bengkulu, {{ now()->translatedFormat('d F Y') }}<br>
                    Penanggung Jawab Ruangan<br><br><br><br><br>
                    <b>( &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; )</b>
                </td>
            </tr>
        </table>
    </div>

    @else
        <div class="bg-white p-8 rounded-xl border border-slate-200 text-center text-slate-400 text-xs">
            Silakan pilih ruangan di atas untuk menampilkan Daftar Inventaris Ruangan.
        </div>
    @endif
    


    <div class="flex justify-end print:hidden">
        <a href="{{ route('reports.index') }}" class="px-4 py-2 bg-slate-100 text-slate-600 rounded-lg text-xs font-medium hover:bg-slate-200 transition">
            Kembali ke Pusat Laporan
        </a>
    </div>
</div>

<!-- CSS KHUSUS PRINT: SEMbunyikan SEMUA KECUALI #print-area -->
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