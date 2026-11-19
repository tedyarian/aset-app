@extends('asset::layouts.app')

@section('title', 'Manajemen Aset')
@section('header-title', 'Daftar Semua Aset (Asset Inventory)')

@section('content')
<div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200 space-y-4">
    <div class="flex justify-between items-center">
        <h3 class="text-md font-bold text-slate-800">Inventaris Barang & Aset</h3>
        <a href="{{ route('inventory.create') }}" class="bg-blue-600 text-white text-xs px-4 py-2 rounded-lg font-medium hover:bg-blue-700 transition">+ Tambah Aset Baru</a>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-xs">
    <!-- Perbarui bagian header tabel (th) -->
    <thead>
        <tr class="border-b text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
            <th class="px-3 py-3 w-12 text-center">No.Urut</th>
            <th class="px-3 py-3">Kode / Nama Barang</th>
            <th class="px-3 py-3">Merk / Tipe</th>
            <th class="px-3 py-3">Lokasi / Ruangan</th>
            <th class="px-3 py-3">Jumlah</th>
            <th class="px-3 py-3 text-center">Tahun Perolehan</th>
            <th class="px-3 py-3 text-center">Sumber Dana</th>
            <th class="px-3 py-3">Status</th>
            <th class="px-3 py-3 text-center">Aksi</th>
        </tr>
    </thead>
    <!-- Perbarui bagian baris data (tbody tr td) -->
    <tbody class="divide-y divide-gray-200 text-sm">
        @forelse($assets as $index => $item)
        <tr class="hover:bg-gray-50">
            <td class="px-3 py-3 text-center text-gray-500 font-medium">{{ $index + 1 }}</td>
            <td class="px-3 py-3">
                <div class="font-semibold text-gray-900">{{ $item->name }}</div>
                <div class="text-xs text-gray-400">Kode: {{ $item->code ?? '-' }}</div>
            </td>
            <td class="px-3 py-3 text-gray-600">{{ $item->brand ?? '-' }}</td>
            <td class="px-3 py-3 text-gray-600">
                <div>{{ $item->location->name ?? '-' }}</div>
                <div class="text-xs text-gray-400">({{ $item->room->name ?? '-' }})</div>
            </td>
            <td class="px-3 py-3 text-gray-600">{{ $item->quantity ?? 1 }} Pcs</td>
            <td class="px-3 py-3 text-gray-600 text-center">{{ $item->acquisition_year}}</td>
            <td class="px-3 py-3 text-gray-600 text-center">{{ $item->sumber_dana}}</td>
            <td class="px-3 py-3">
                <span class="px-2 py-0.5 rounded text-xs font-medium {{ $item->status == 'Baik' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                    {{ $item->status }}
                </span>
            </td>
            <td class="px-3 py-3 text-center whitespace-nowrap">
                <div class="inline-flex items-center space-x-1.5">
                    <a href="{{ route('inventory.show', $item->id) }}" class="text-indigo-600 bg-indigo-50 hover:bg-indigo-100 px-2 py-1 rounded text-xs font-semibold">Detail</a>
                    <a href="{{ route('inventory.edit', $item->id) }}" class="text-amber-600 bg-amber-50 hover:bg-amber-100 px-2 py-1 rounded text-xs font-semibold">Edit</a>
                    <a href="{{ route('inventory.barcode', $item->id) }}" class="text-emerald-600 bg-emerald-50 hover:bg-emerald-100 px-2 py-1 rounded text-xs font-semibold" target="_blank">Barcode</a>
                    <form action="{{ route('inventory.destroy', $item->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus aset ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 bg-red-50 hover:bg-red-100 px-2 py-1 rounded text-xs font-semibold">Hapus</button>
                    </form>
                </div>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="7" class="px-3 py-4 text-center text-gray-500">Belum ada data inventaris aset.</td>
        </tr>
        @endforelse
    </tbody>
</table>
    </div>
</div>
@endsection