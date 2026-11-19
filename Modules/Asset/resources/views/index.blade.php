@extends('asset::layouts.app')

@section('title', 'Dashboard')
@section('header-title', 'Ringkasan Aset')

@section('content')

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col overflow-y-auto">
            <header class="bg-white shadow-sm h-16 flex items-center justify-between px-8">
                <h1 class="text-lg font-semibold text-slate-700">Dashboard Overview</h1>
                <div class="flex items-center space-x-4 text-sm text-slate-600">
                    <span>Notification</span>
                    <span class="font-medium text-slate-900">Admin User</span>
                </div>
            </header>

            <main class="p-8">
                <div class="mb-6">
                    <h2 class="text-2xl font-bold text-slate-800">Welcome back, Admin</h2>
                    <p class="text-sm text-slate-500">Berikut ringkasan statistik dan kondisi aset perusahaan hari ini.</p>
                </div>

                <!-- Metric Cards (Ringkasan Statistik) -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
                        <p class="text-sm text-slate-500">Total Jumlah Aset</p>
                        <h3 class="text-3xl font-bold text-slate-800 mt-2">{{ $metrics['total'] ?? 0 }}</h3>
                        <span class="text-xs text-emerald-600 font-semibold">+3 baru minggu ini</span>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
                        <p class="text-sm text-slate-500">Total Keseluruhan Unit</p>
                        <h3 class="text-2xl font-bold text-slate-800 mt-2">{{ number_format($metrics['total_assets'] ?? 0) }} Unit</h3>
                        <span class="text-xs text-slate-400">Akumulasi jumlah fisik barang</span>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
                        <p class="text-sm text-slate-500">Aset Dalam Perbaikan</p>
                        <!-- Menggunakan huruf kecil 'maintenance' yang benar -->
                        <h3 class="text-3xl font-bold text-amber-600 mt-2">{{ $metrics['maintenance'] ?? 0 }}</h3>
                        <span class="text-xs text-slate-400">Jadwal servis berkala</span>
                    </div>
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
                        <p class="text-sm text-slate-500">Aset Aktif</p>
                        <h3 class="text-3xl font-bold text-blue-600 mt-2">{{ $metrics['active'] ?? 0 }}</h3>
                        <span class="text-xs text-blue-600 font-semibold">Kondisi operasional</span>
                    </div>
                </div>

                <!-- Tabel Daftar Aset Terbaru -->
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                    <h3 class="text-lg font-bold text-slate-800 mb-4">Daftar Inventaris Aset Terbaru</h3>
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b text-sm text-slate-500">
                                <th class="py-3">Kode Aset</th>
                                <th class="py-3">Nama Aset</th>
                                <th class="py-3">Type/Merk</th>
                                <th class="py-3">Lokasi</th>
                                <th class="py-3">Jumlah</th>
                                <th class="py-3">Status</th>
                                <th class="py-3 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                        @forelse($assets as $item)
                            <tr>
                                <!-- Kolom Kode & Nama Barang (Diubah ke asset_code) -->
                                <td class="py-2.5">
                                    <span class="font-bold text-slate-700 block">{{ $item->name }}</span>
                                    <span class="font-mono text-xs text-slate-400 block">Kode: {{ $item->asset_code ?? '-' }}</span>
                                </td>

                                <!-- Merk / Tipe -->
                                <td class="py-2.5 text-slate-600">
                                    {{ $item->brand ?? '-' }}
                                </td>

                                <!-- Lokasi / Ruangan -->
                                <td class="py-2.5 text-slate-600">
                                    {{ $item->location->name ?? '-' }} 
                                    <span class="block text-[11px] text-slate-400">({{ $item->room->name ?? '-' }})</span>
                                </td>

                                <!-- Jumlah -->
                                <td class="py-2.5 text-slate-600">
                                    {{ $item->quantity ?? 1 }} Pcs
                                </td>

                                <!-- Status -->
                                <td class="py-2.5">
                                    <span class="px-2 py-0.5 rounded text-xs font-medium {{ $item->status == 'Baik' ? 'bg-emerald-100 text-emerald-700' : 'bg-amber-100 text-amber-700' }}">
                                        {{ $item->status }}
                                    </span>
                                </td>

                                <!-- Aksi -->
                                <td class="py-2.5 text-right whitespace-nowrap">
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
                                <td colspan="7" class="py-4 text-center text-slate-400">Belum ada data inventaris aset.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
@endsection