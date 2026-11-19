@extends('asset::layouts.app')

@section('title', 'Laporan Selisih Aset')
@section('header-title', 'Laporan Selisih (Discrepancy): ' . $session->session_name)

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    <div class="bg-rose-50 border border-rose-200 p-4 rounded-xl flex items-center justify-between text-xs text-rose-800">
        <span>Berikut adalah daftar aset yang tercatat di sistem namun <strong>belum/tidak ditemukan</strong> selama sesi pemindaian stock opname berlangsung.</span>
        <span class="font-bold text-sm bg-rose-200 px-3 py-1 rounded-lg">Total Selisih: {{ $discrepancies->count() }} Unit</span>
    </div>

    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm space-y-4">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="border-b text-slate-400">
                        <th class="py-2">Kode BMN</th>
                        <th class="py-2">Nama Barang</th>
                        <th class="py-2">Merk / Tipe</th>
                        <th class="py-2">Status Sistem</th>
                        <th class="py-2 text-right">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($discrepancies as $disc)
                        <tr>
                            <td class="py-3 font-bold text-slate-700">{{ $disc->asset->code ?? '-' }}</td>
                            <td class="py-3 text-slate-600">{{ $disc->asset->name ?? '-' }}</td>
                            <td class="py-3 text-slate-600">{{ $disc->asset->brand ?? '-' }}</td>
                            <td class="py-3"><span class="px-2 py-0.5 rounded text-[10px] bg-slate-100 text-slate-700">{{ $disc->asset->status ?? '-' }}</span></td>
                            <td class="py-3 text-right text-rose-600 font-medium">Tidak Ditemukan / Hilang</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-6 text-center text-emerald-600 font-medium">Luar biasa! Tidak ada selisih aset. Semua inventaris ditemukan lengkap di lapangan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="flex justify-end">
        <a href="{{ route('audits.index') }}" class="px-4 py-2 bg-slate-100 text-slate-600 rounded-lg text-xs font-medium hover:bg-slate-200">Kembali ke Daftar Audit</a>
    </div>

</div>
@endsection