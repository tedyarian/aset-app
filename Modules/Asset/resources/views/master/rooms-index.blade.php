@extends('asset::layouts.app')

@section('title', 'Master Ruangan')
@section('header-title', 'Daftar Ruangan & Detail Penandatangan')

@section('content')
<div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200 max-w-7xl">
    <!-- 3. KELOLA RUANGAN (DIPERLUAS DENGAN DETAIL LENGKAP) -->
    <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200 md:col-span-2">
        <h3 class="text-sm font-bold text-slate-800 mb-3">Daftar Ruangan & Detail Penandatangan</h3>
        
        <!-- Form Tambah Ruangan Lengkap -->
        <form action="{{ route('master.room.store') }}" method="POST" class="space-y-4 bg-slate-50 p-4 rounded-lg border border-slate-200 mb-4">
            @csrf
            
           <!-- Informasi Ruangan -->
            <div class="space-y-2">
                <h4 class="text-xs font-bold text-slate-700 uppercase tracking-wider">Informasi Ruangan & Penandatanganan</h4>
                <div class="grid grid-cols-1 md:grid-cols-4 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-slate-600 mb-1">Nama Ruang :</label>
                        <input type="text" name="name" placeholder="Contoh: Ruang Server" class="w-full border border-slate-300 rounded-lg px-3 py-1.5 text-xs outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-600 mb-1">Gedung / Lokasi :</label>
                        <input type="text" name="location" placeholder="Contoh: Gedung A" class="w-full border border-slate-300 rounded-lg px-3 py-1.5 text-xs outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-600 mb-1">Tempat Penandatanganan :</label>
                        <input type="text" name="sign_tempat" placeholder="Contoh: Bengkulu" class="w-full border border-slate-300 rounded-lg px-3 py-1.5 text-xs outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-600 mb-1">Tanggal Penandatanganan :</label>
                        <input type="date" name="sign_date" class="w-full border border-slate-300 rounded-lg px-3 py-1.5 text-xs outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
            </div>

            <hr class="border-slate-200">

            <!-- Penanggung Jawab Ruangan -->
            <div class="space-y-2">
                <h4 class="text-xs font-bold text-slate-700 uppercase tracking-wider">Penanggung Jawab</h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-slate-600 mb-1">Jabatan :</label>
                        <input type="text" name="pic_jabatan" placeholder="Contoh: Petugas / Pengurus Aset" class="w-full border border-slate-300 rounded-lg px-3 py-1.5 text-xs outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-600 mb-1">Nama :</label>
                        <input type="text" name="pic_name" placeholder="Nama Lengkap & Gelar" class="w-full border border-slate-300 rounded-lg px-3 py-1.5 text-xs outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-600 mb-1">NIP :</label>
                        <input type="text" name="pic_nip" placeholder="Nomor Induk Pegawai" class="w-full border border-slate-300 rounded-lg px-3 py-1.5 text-xs outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
            </div>

            <hr class="border-slate-200">

            <!-- Dekan / Ketua / Kepala -->
            <div class="space-y-2">
                <h4 class="text-xs font-bold text-slate-700 uppercase tracking-wider">Dekan / Ketua / Kepala</h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-slate-600 mb-1">Jabatan :</label>
                        <input type="text" name="leader_jabatan" placeholder="Contoh: Kepala Unit / Dekan" class="w-full border border-slate-300 rounded-lg px-3 py-1.5 text-xs outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-600 mb-1">Nama :</label>
                        <input type="text" name="leader_name" placeholder="Nama Pimpinan" class="w-full border border-slate-300 rounded-lg px-3 py-1.5 text-xs outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-600 mb-1">NIP :</label>
                        <input type="text" name="leader_nip" placeholder="NIP Pimpinan" class="w-full border border-slate-300 rounded-lg px-3 py-1.5 text-xs outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </div>
            </div>

            <div class="flex justify-end pt-2">
                <button type="submit" class="bg-slate-800 text-white text-xs px-4 py-2 rounded-lg font-medium hover:bg-slate-700">+ Tambah Ruangan</button>
            </div>
        </form>

        <!-- Tabel Daftar Ruangan -->
        <div class="border-t border-slate-100 pt-2 overflow-x-auto max-h-80 overflow-y-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="border-b text-slate-400">
                        <th class="py-2 font-medium">Nama Ruangan</th>
                        <th class="py-2 font-medium">Tempat Penandatangan</th>
                        <th class="py-2 font-medium">Tanggal Penandatangan</th>
                        <th class="py-2 font-medium">Penanggung Jawab</th>
                        <th class="py-2 font-medium">Nip</th>
                        <th class="py-2 font-medium">Pimpinan</th>
                        <th class="py-2 font-medium">Nip</th>
                        <th class="py-2 text-right font-medium">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($rooms as $room)
                        <tr>
                            <td class="py-2 text-slate-700 font-bold">{{ $room->name }}</td>
                            <td class="py-2 text-slate-600">{{ $room->sign_tempat }}</td>
                            <td class="py-2 text-slate-600">{{ $room->location ?? '-' }} <br>
                                <span class="text-[10px] text-slate-400">{{ $room->sign_date ?? '-' }}</span>
                            </td>
                            <td class="py-2 text-slate-600">
                                {{ $room->pic_name ?? '-' }}<br>
                                <span class="text-[10px] text-slate-400">{{ $room->pic_jabatan }}</span>
                            </td>
                             <td class="py-2 text-slate-600">
                                {{ $room->pic_nip ?? '-' }}<br>
                                <span class="text-[10px] text-slate-400">{{ $room->pic_nip }}</span>
                            </td>
                            <td class="py-2 text-slate-600">
                                {{ $room->leader_name ?? '-' }}<br>
                                <span class="text-[10px] text-slate-400">{{ $room->leader_jabatan }}</span>
                            </td>
                            <td class="py-2 text-slate-600">
                                {{ $room->leader_nip ?? '-' }}<br>
                                <span class="text-[10px] text-slate-400">{{ $room->leader_nip }}</span>
                            </td>
                            <td class="py-2 text-right">
                                <form action="{{ route('master.room.delete', $room->id) }}" method="POST" onsubmit="return confirm('Hapus ruangan ini?');" class="inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="py-4 text-center text-slate-400">Belum ada data ruangan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection