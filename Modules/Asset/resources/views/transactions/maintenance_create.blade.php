@extends('asset::layouts.app')

@section('title', 'Catat Perawatan Aset')
@section('header-title', 'Form Perawatan & Perbaikan (Maintenance)')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
    <form action="{{ route('transactions.maintenance.store') }}" method="POST" class="space-y-4">
        @csrf

        <!-- Pilih Aset -->
        <div>
            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Pilih Aset yang Diservis / Diperbaiki</label>
            <select name="asset_item_id" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-xs bg-white outline-none focus:ring-2 focus:ring-amber-500" required>
                <option value="">-- Pilih Aset --</option>
                @foreach($assets as $asset)
                    <option value="{{ $asset->id }}">{{ $asset->code }} - {{ $asset->name }} (Status: {{ $asset->status }})</option>
                @endforeach
            </select>
        </div>

        <!-- Tanggal & Jenis Perawatan -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Tanggal Perawatan</label>
                <input type="date" name="maintenance_date" value="{{ date('Y-m-d') }}" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-xs outline-none focus:ring-2 focus:ring-amber-500" required>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Jenis Perawatan</label>
                <select name="maintenance_type" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-xs bg-white outline-none focus:ring-2 focus:ring-amber-500" required>
                    <option value="Servis Berkala">Servis Berkala</option>
                    <option value="Perbaikan Kerusakan">Perbaikan Kerusakan</option>
                    <option value="Upgrade / Penggantian Sparepart">Upgrade / Penggantian Sparepart</option>
                </select>
            </div>
        </div>

        <!-- Biaya & Vendor / Teknisi -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Biaya Perawatan (Rp)</label>
                <input type="number" name="cost" value="0" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-xs outline-none focus:ring-2 focus:ring-amber-500" required>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Vendor / Teknisi yang Menangani</label>
                <input type="text" name="vendor_or_technician" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-xs outline-none focus:ring-2 focus:ring-amber-500" placeholder="Nama Toko, Vendor, atau Teknisi" required>
            </div>
        </div>

        <!-- Deskripsi / Kerusakan -->
        <div>
            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Deskripsi / Catatan Kerusakan & Servis</label>
            <textarea name="description" rows="3" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-xs outline-none focus:ring-2 focus:ring-amber-500" placeholder="Jelaskan detail kerusakan atau tindakan servis yang dilakukan..." required></textarea>
        </div>

        <!-- Tombol Aksi -->
        <div class="flex justify-end space-x-2 pt-2">
            <a href="{{ route('transactions.index') }}" class="px-4 py-2 bg-slate-100 text-slate-600 rounded-lg text-xs font-medium hover:bg-slate-200 transition">Batal</a>
            <button type="submit" class="px-4 py-2 bg-amber-600 text-white rounded-lg text-xs font-medium hover:bg-amber-700 transition">Simpan Perawatan</button>
        </div>
    </form>
</div>
@endsection