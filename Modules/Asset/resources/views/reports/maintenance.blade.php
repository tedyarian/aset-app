@extends('asset::layouts.app')

@section('title', 'Laporan Perawatan Aset')
@section('header-title', 'Rekapitulasi Biaya Perawatan & Perbaikan')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    <div class="bg-amber-50 border border-amber-200 p-4 rounded-xl flex items-center justify-between text-xs text-amber-800">
        <span>Total kumulatif biaya operasional dan pemeliharaan seluruh aset.</span>
        <span class="font-bold text-sm bg-amber-200 px-3 py-1 rounded-lg">Total Biaya: Rp {{ number_format($totalCost, 0, ',', '.') }}</span>
    </div>

    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm space-y-4">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="border-b text-slate-400">
                        <th class="py-2">Tanggal</th>
                        <th class="py-2">Aset</th>
                        <th class="py-2">Jenis Perawatan</th>
                        <th class="py-2">Vendor / Teknisi</th>
                        <th class="py-2 text-right">Biaya</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($maintenances as $maint)
                        <tr>
                            <td class="py-3 text-slate-600">{{ $maint->maintenance_date }}</td>
                            <td class="py-3 font-bold text-slate-700">{{ $maint->asset->name ?? '-' }}</td>
                            <td class="py-3 text-slate-600">{{ $maint->maintenance_type }}</td>
                            <td class="py-3 text-slate-600">{{ $maint->vendor_or_technician }}</td>
                            <td class="py-3 text-right font-bold text-slate-700">Rp {{ number_format($maint->cost, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-4 text-center text-slate-400">Belum ada riwayat perawatan tercatat.</td>
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