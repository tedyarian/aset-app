@extends('asset::layouts.app')

@section('title', 'Input Mutasi Aset')
@section('header-title', 'Form Mutasi / Perpindahan Aset')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded-xl border border-slate-200 shadow-sm">
    <form action="{{ route('transactions.mutation.store') }}" method="POST" class="space-y-4">
        @csrf

        <!-- Pilih Aset -->
        <div>
            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Pilih Aset</label>
            <select name="asset_item_id" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-xs bg-white outline-none focus:ring-2 focus:ring-blue-500" required>
                <option value="">-- Pilih Aset yang Akan Dimutasi --</option>
                @foreach($assets as $asset)
                    <option value="{{ $asset->id }}">{{ $asset->code }} - {{ $asset->name }} (Lokasi Saat Ini: {{ $asset->room->name ?? '-' }})</option>
                @endforeach
            </select>
        </div>

        <!-- Ruangan Tujuan -->
        <div>
            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Pindah ke Ruangan Tujuan</label>
            <select name="to_room_id" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-xs bg-white outline-none focus:ring-2 focus:ring-blue-500" required>
                <option value="">-- Pilih Ruangan Tujuan --</option>
                @foreach($rooms as $room)
                    <option value="{{ $room->id }}">{{ $room->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Penanggung Jawab Baru (PIC) -->
        <div>
            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Penanggung Jawab Baru (PIC)</label>
            <input type="text" name="to_pic" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-xs outline-none focus:ring-2 focus:ring-blue-500" placeholder="Nama Pegawai / Staff Penerima">
        </div>

        <!-- Tanggal Mutasi -->
        <div>
            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Tanggal Mutasi</label>
            <input type="date" name="mutation_date" value="{{ date('Y-m-d') }}" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-xs outline-none focus:ring-2 focus:ring-blue-500" required>
        </div>

        <!-- Alasan / Keterangan -->
        <div>
            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Alasan Mutasi / Keterangan</label>
            <textarea name="reason" rows="3" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-xs outline-none focus:ring-2 focus:ring-blue-500" placeholder="Contoh: Perpindahan divisi, perbaikan tata letak ruangan, dll."></textarea>
        </div>

        <!-- Tombol Aksi -->
        <div class="flex justify-end space-x-2 pt-2">
            <a href="{{ route('transactions.index') }}" class="px-4 py-2 bg-slate-100 text-slate-600 rounded-lg text-xs font-medium hover:bg-slate-200 transition">Batal</a>
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg text-xs font-medium hover:bg-blue-700 transition">Simpan Mutasi</button>
        </div>
    </form>
</div>
@endsection