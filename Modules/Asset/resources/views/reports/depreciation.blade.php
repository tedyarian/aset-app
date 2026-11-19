@extends('asset::layouts.app')

@section('title', 'Laporan Penyusutan Aset')
@section('header-title', 'Laporan Keuangan & Penyusutan (Depreciation)')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm space-y-4">
        <div class="flex justify-between items-center">
            <h3 class="text-xs font-bold text-slate-700 uppercase">Tabel Kalkulasi Nilai Susut Aset</h3>
            <button onclick="window.print()" class="px-3 py-1.5 bg-slate-100 text-slate-600 rounded-lg text-xs font-medium hover:bg-slate-200">🖨️ Cetak / PDF</button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="border-b text-slate-400">
                        <th class="py-2">Kode BMN</th>
                        <th class="py-2">Nama Aset</th>
                        <th class="py-2">Harga Perolehan</th>
                        <th class="py-2">Penyusutan / Tahun</th>
                        <th class="py-2">Nilai Buku Saat Ini</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($reportData as $item)
                        <tr>
                            <td class="py-3 font-bold text-slate-700">{{ $item->code }}</td>
                            <td class="py-3 text-slate-600">{{ $item->name }}</td>
                            <td class="py-3 text-slate-600">Rp {{ number_format($item->purchase_price ?? 0, 0, ',', '.') }}</td>
                            <td class="py-3 text-rose-600 font-medium">Rp {{ number_format($item->depreciation_per_year, 0, ',', '.') }}</td>
                            <td class="py-3 text-emerald-600 font-bold">Rp {{ number_format($item->book_value, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-4 text-center text-slate-400">Belum ada data nilai perolehan aset.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="flex justify-end">
        <a href="{{ route('reports.index') }}" class="px-4 py-2 bg-slate-100 text-slate-600 rounded-lg text-xs font-medium hover:bg-slate-200">Kembali ke Menu Laporan</a>
    </div>
</div>
@endsection