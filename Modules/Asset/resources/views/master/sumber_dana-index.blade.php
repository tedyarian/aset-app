@extends('asset::layouts.app')

@section('title', 'Manajemen Sumber Dana')
@section('header-title', 'Pengaturan Sumber Dana Aset')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    @if(session('success'))
        <div class="bg-emerald-100 border border-emerald-400 text-emerald-700 px-4 py-3 rounded-xl text-xs">
            {{ session('success') }}
        </div>
    @endif

    <!-- Form Input Sumber Dana -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
        <h3 class="text-xs font-bold text-slate-700 uppercase tracking-wider mb-4">Tambah Sumber Dana Baru</h3>
        <form action="{{ route('master.sumber-dana.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-medium text-slate-600 mb-1">Nama Sumber Dana</label>
                <input type="text" name="nama_sumber_dana" placeholder="Contoh: BOPTN, Hibah Penelitian" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-xs outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            <div>
                <label class="block text-xs font-medium text-slate-600 mb-1">Keterangan (Opsional)</label>
                <input type="text" name="keterangan" placeholder="Keterangan tambahan..." class="w-full border border-slate-300 rounded-lg px-3 py-2 text-xs outline-none focus:ring-2 focus:ring-blue-500">
            </div>
            <button type="submit" class="bg-blue-600 text-white text-xs px-5 py-2.5 rounded-lg font-semibold hover:bg-blue-700 transition">+ Simpan Sumber Dana</button>
        </form>
    </div>

    <!-- Tabel Daftar Sumber Dana -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
        <h3 class="text-xs font-bold text-slate-700 uppercase tracking-wider mb-4">Daftar Sumber Dana Tersedia</h3>
        <table class="w-full text-left text-xs">
            <thead>
                <tr class="border-b text-slate-400">
                    <th class="py-2">No</th>
                    <th class="py-2">Nama Sumber Dana</th>
                    <th class="py-2">Keterangan</th>
                    <th class="py-2 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($sumberDana as $index => $item)
                <tr>
                    <td class="py-3 text-slate-500">{{ $index + 1 }}</td>
                    <td class="py-3 font-semibold text-slate-700">{{ $item->nama_sumber_dana }}</td>
                    <td class="py-3 text-slate-600">{{ $item->keterangan ?? '-' }}</td>
                    <td class="py-3 text-right">
                        <form action="{{ route('master.sumber-dana.delete', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline font-medium">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="py-4 text-center text-slate-400">Belum ada data sumber dana.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection