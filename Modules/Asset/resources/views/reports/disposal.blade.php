@extends('asset::layouts.app')

@section('title', 'Laporan Penghapusan Aset')
@section('header-title', 'Daftar Penghapusan Aset (Disposed / Rusak Total)')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm space-y-4">
        <h3 class="text-xs font-bold text-slate-700 uppercase">Daftar Aset Dihapuskan / Dijual Kembali</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="border-b text-slate-400">
                        <th class="py-2">Kode BMN</th>
                        <th class="py-2">Nama Aset</th>
                        <th class="py-2">Kategori</th>
                        <th class="py-2">Status Akhir</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($disposedAssets as $disp)
                        <tr>
                            <td class="py-3 font-bold text-slate-700">{{ $disp->code }}</td>
                            <td class="py-3 text-slate-600">{{ $disp->name }}</td>
                            <td class="py-3 text-slate-600">{{ $disp->category->name ?? '-' }}</td>
                            <td class="py-3"><span class="px-2 py-0.5 rounded text-[10px] bg-rose-100 text-rose-700 font-semibold">{{ $disp->status }}</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-4 text-center text-slate-400">Tidak ada aset yang berstatus dihapuskan atau disposed.</td>
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