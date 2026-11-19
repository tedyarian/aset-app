@extends('asset::layouts.app')

@section('title', 'Input Peminjaman Aset')
@section('header-title', 'Form Peminjaman & Check-out Aset')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
    <form action="{{ route('transactions.loan.store') }}" method="POST" class="space-y-4">
        @csrf

        <!-- Pilih Aset Portabel -->
        <div>
            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Pilih Aset (Laptop / Proyektor / dll)</label>
            <select name="asset_item_id" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-xs bg-white outline-none focus:ring-2 focus:ring-emerald-500" required>
                <option value="">-- Pilih Aset yang Akan Dipinjam --</option>
                @foreach($assets as $asset)
                    <option value="{{ $asset->id }}">{{ $asset->code }} - {{ $asset->name }} (Merk: {{ $asset->brand ?? '-' }})</option>
                @endforeach
            </select>
        </div>

        <!-- Nama Peminjam -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Nama Peminjam (Karyawan)</label>
                <input type="text" name="borrower_name" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-xs outline-none focus:ring-2 focus:ring-emerald-500" placeholder="Nama lengkap peminjam" required>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Departemen / Divisi Peminjam</label>
                <input type="text" name="borrower_dept" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-xs outline-none focus:ring-2 focus:ring-emerald-500" placeholder="Contoh: IT / Operasional">
            </div>
        </div>

        <!-- Tanggal Pinjam & Batas Kembali -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Tanggal Pinjam</label>
                <input type="date" name="loan_date" value="{{ date('Y-m-d') }}" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-xs outline-none focus:ring-2 focus:ring-emerald-500" required>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Batas Pengembalian (Due Date)</label>
                <input type="date" name="due_date" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-xs outline-none focus:ring-2 focus:ring-emerald-500" required>
            </div>
        </div>

        <!-- Kondisi Fisik Saat Dipinjam -->
        <div>
            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Kondisi Fisik Saat Dipinjam</label>
            <input type="text" name="condition_before" value="Baik & Berfungsi Normal" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-xs outline-none focus:ring-2 focus:ring-emerald-500" required>
        </div>

        <!-- Catatan Tambahan -->
        <div>
            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Catatan / Kelengkapan (Opsional)</label>
            <textarea name="notes" rows="2" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-xs outline-none focus:ring-2 focus:ring-emerald-500" placeholder="Contoh: Termasuk tas charger dan mouse."></textarea>
        </div>

        <!-- Tombol Aksi -->
        <div class="flex justify-end space-x-2 pt-2">
            <a href="{{ route('transactions.index') }}" class="px-4 py-2 bg-slate-100 text-slate-600 rounded-lg text-xs font-medium hover:bg-slate-200 transition">Batal</a>
            <button type="submit" class="px-4 py-2 bg-emerald-600 text-white rounded-lg text-xs font-medium hover:bg-emerald-700 transition">Simpan Peminjaman</button>
        </div>
    </form>
</div>
@endsection