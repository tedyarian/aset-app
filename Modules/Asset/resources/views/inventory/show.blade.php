@extends('asset::layouts.app')

@section('title', 'Detail Aset')
@section('header-title', 'Detail & Riwayat Aset')

@section('content')
<div class="space-y-6 max-w-4xl mx-auto">
    <!-- Header Info -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200 flex justify-between items-start">
        <div>
            <span class="text-xs font-mono bg-slate-100 text-slate-600 px-2 py-1 rounded">{{ $asset->code }}</span>
            <h2 class="text-xl font-bold text-slate-800 mt-2">{{ $asset->name }}</h2>
            <p class="text-xs text-slate-500">Merk/Tipe: {{ $asset->brand ?? '-' }}</p>
        </div>
        <a href="{{ route('inventory.index') }}" class="text-xs bg-slate-100 text-slate-700 px-3 py-1.5 rounded-lg hover:bg-slate-200">&larr; Kembali</a>
    </div>

    <!-- Grid Informasi (Lokasi, Status, & Foto) -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <!-- 1. Informasi Lokasi & Kepemilikan -->
        <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200 space-y-3">
            <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Lokasi & Kepemilikan</h4>
            <div class="text-xs space-y-2">
                <p><strong class="text-slate-600">Departemen:</strong> {{ $asset->department->name ?? '-' }}</p>
                <p><strong class="text-slate-600">Lokasi Gedung:</strong> {{ $asset->location->name ?? '-' }}</p>
                <p><strong class="text-slate-600">Ruangan:</strong> {{ $asset->room->name ?? '-' }}</p>
                <p><strong class="text-slate-600">Penanggung Jawab:</strong> {{ $asset->pic ?? '-' }}</p>
            </div>
        </div>

        <!-- 2. Status & Jumlah -->
        <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200 space-y-3">
            <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Status & Jumlah</h4>
            <div class="text-xs space-y-2">
                <p><strong class="text-slate-600">Jumlah:</strong> {{ $asset->quantity }} {{ $asset->unit }}</p>
                <p><strong class="text-slate-600">Kondisi:</strong> 
                    <span class="px-2 py-0.5 rounded text-[10px] bg-emerald-100 text-emerald-700 font-medium">{{ $asset->status }}</span>
                </p>
                <p><strong class="text-slate-600">Tanggal Input:</strong> {{ $asset->created_at->format('d M Y') }}</p>
            </div>
        </div>

        <!-- 3. Foto Fisik Aset -->
        <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200 space-y-3">
            <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Foto Fisik Barang</h4>
            <div>
                @if($asset->image)
                    <img src="{{ asset($asset->image) }}" alt="Foto Aset" class="w-full h-32 object-cover rounded-lg border border-slate-200">
                @else
                    <div class="w-full h-32 bg-slate-50 border border-dashed border-slate-300 rounded-lg flex items-center justify-center text-xs text-slate-400 text-center p-2">
                        Tidak ada foto fisik diunggah.
                    </div>
                @endif
            </div>
        </div>

    </div>

    <!-- Bagian Tabel Riwayat Perubahan (Audit Log) -->
        <div class="bg-white p-6 shadow-sm sm:rounded-lg">
            <h3 class="text-lg font-bold mb-4 text-gray-800">Riwayat Perubahan Data Aset</h3>
            
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tanggal Perubahan</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Pengubah</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Perubahan Data</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Alasan Perubahan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-sm">
                    @forelse($asset->histories as $history)
                        <tr>
                            <td class="px-4 py-2 whitespace-nowrap">{{ $history->created_at->format('d-m-Y H:i') }}</td>
                            <td class="px-4 py-2 whitespace-nowrap">{{ $history->changed_by }}</td>
                            <td class="px-4 py-2">{{ $history->changes_summary }}</td>
                            <td class="px-4 py-2 text-yellow-800 bg-yellow-50 font-medium">{{ $history->reason }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-2 text-center text-gray-500">Belum ada riwayat perubahan untuk aset ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    <!-- Riwayat Aset -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200 space-y-4">
        <h3 class="text-sm font-bold text-slate-800">Riwayat Mutasi & Peminjaman Aset</h3>
        <div class="border-t pt-3 text-xs text-slate-500">
            <p>Belum ada catatan riwayat mutasi atau servis untuk aset ini.</p>
        </div>
    </div>
</div>
@endsection