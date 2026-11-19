
@extends('asset::layouts.app')

@section('title', 'Buat Sesi Audit')
@section('header-title', 'Buat Sesi Stock Opname Baru')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
    <form action="{{ route('audits.store') }}" method="POST" class="space-y-4">
        @csrf

        <!-- Nama Sesi Audit -->
        <div>
            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Nama Sesi Audit / Stok Opname</label>
            <input type="text" name="session_name" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-xs outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Contoh: Stok Opname Gedung A - Q3 2026" required>
        </div>

        <!-- Tanggal Mulai & Selesai -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Tanggal Mulai</label>
                <input type="date" name="start_date" value="{{ date('Y-m-d') }}" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-xs outline-none focus:ring-2 focus:ring-indigo-500" required>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Tanggal Selesai</label>
                <input type="date" name="end_date" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-xs outline-none focus:ring-2 focus:ring-indigo-500" required>
            </div>
        </div>

        <!-- Catatan / Keterangan -->
        <div>
            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Catatan Sesi (Opsional)</label>
            <textarea name="notes" rows="3" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-xs outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Keterangan tambahan terkait pelaksanaan audit..."></textarea>
        </div>

        <!-- Tombol Aksi -->
        <div class="flex justify-end space-x-2 pt-2">
            <a href="{{ route('audits.index') }}" class="px-4 py-2 bg-slate-100 text-slate-600 rounded-lg text-xs font-medium hover:bg-slate-200 transition">Batal</a>
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-xs font-medium hover:bg-indigo-700 transition">Simpan & Mulai Sesi</button>
        </div>
    </form>
</div>
@endsection