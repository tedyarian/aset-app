@extends('asset::layouts.app')

@section('title', 'Master Data')
@section('header-title', 'Master Data (Referensi)')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
    <!-- 1. KELOLA DEPARTEMEN -->
    <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200 flex flex-col justify-between">
        <div>
            <h3 class="text-sm font-bold text-slate-800 mb-3">Daftar Departemen / Divisi</h3>
            
            <form action="{{ route('master.department.store') }}" method="POST" class="flex gap-2 mb-4">
                @csrf
                <input type="text" name="name" placeholder="Nama Departemen (Contoh: IT)" class="flex-1 border border-slate-300 rounded-lg px-3 py-1.5 text-xs outline-none focus:ring-2 focus:ring-blue-500" required>
                <button type="submit" class="bg-slate-800 text-white text-xs px-3 py-1.5 rounded-lg font-medium hover:bg-slate-700 whitespace-nowrap">+ Tambah</button>
            </form>

            <div class="border-t border-slate-100 pt-2 overflow-x-auto max-h-60 overflow-y-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="border-b text-slate-400">
                            <th class="py-2 font-medium">Nama</th>
                            <th class="py-2 text-right font-medium">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($departments as $dept)
                            <tr>
                                <td class="py-2 text-slate-700 font-medium">{{ $dept->name }}</td>
                                <td class="py-2 text-right">
                                    <form action="{{ route('master.department.delete', $dept->id) }}" method="POST" onsubmit="return confirm('Hapus departemen ini?');" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:underline">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="2" class="py-4 text-center text-slate-400">Belum ada data departemen.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- 2. KELOLA LOKASI -->
    <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200 flex flex-col justify-between">
        <div>
            <h3 class="text-sm font-bold text-slate-800 mb-3">Daftar Lokasi Penyimpanan Aset</h3>
            
            <form action="{{ route('master.location.store') }}" method="POST" class="flex gap-2 mb-4">
                @csrf
                <input type="text" name="name" placeholder="Nama Lokasi (Contoh: Gedung A)" class="flex-1 border border-slate-300 rounded-lg px-3 py-1.5 text-xs outline-none focus:ring-2 focus:ring-blue-500" required>
                <button type="submit" class="bg-slate-800 text-white text-xs px-3 py-1.5 rounded-lg font-medium hover:bg-slate-700 whitespace-nowrap">+ Tambah</button>
            </form>

            <div class="border-t border-slate-100 pt-2 overflow-x-auto max-h-60 overflow-y-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="border-b text-slate-400">
                            <th class="py-2 font-medium">Lokasi</th>
                            <th class="py-2 text-right font-medium">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($locations as $loc)
                            <tr>
                                <td class="py-2 text-slate-700 font-medium">{{ $loc->name }}</td>
                                <td class="py-2 text-right">
                                    <form action="{{ route('master.location.delete', $loc->id) }}" method="POST" onsubmit="return confirm('Hapus lokasi ini?');" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:underline">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="2" class="py-4 text-center text-slate-400">Belum ada data lokasi.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- 3. KELOLA RUANGAN (DIPERLUAS DENGAN DETAIL LENGKAP) -->
    <div class="bg-white p-5 rounded-xl shadow-sm border border-slate-200 md:col-span-2">
        <h3 class="text-sm font-bold text-slate-800 mb-3">Daftar Ruangan & Detail Penandatangan</h3>
        
        <!-- Form Tambah Ruangan Lengkap -->
        <form action="{{ route('master.room.store') }}" method="POST" class="space-y-4 bg-slate-50 p-4 rounded-lg border border-slate-200 mb-4">
            @csrf
            
            <!-- Informasi Ruangan -->
            <div class="space-y-2">
                <h4 class="text-xs font-bold text-slate-700 uppercase tracking-wider">Informasi Ruangan</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-medium text-slate-600 mb-1">Nama Ruang :</label>
                        <input type="text" name="name" placeholder="Contoh: Ruang Server" class="w-full border border-slate-300 rounded-lg px-3 py-1.5 text-xs outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-slate-600 mb-1">Tempat / Gedung :</label>
                        <input type="text" name="location" placeholder="Contoh: Gedung A / Lantai 2" class="w-full border border-slate-300 rounded-lg px-3 py-1.5 text-xs outline-none focus:ring-2 focus:ring-blue-500">
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
                        <th class="py-2 font-medium">Tempat</th>
                        <th class="py-2 font-medium">Penanggung Jawab</th>
                        <th class="py-2 font-medium">Pimpinan</th>
                        <th class="py-2 text-right font-medium">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($rooms as $room)
                        <tr>
                            <td class="py-2 text-slate-700 font-bold">{{ $room->name }}</td>
                            <td class="py-2 text-slate-600">{{ $room->location ?? '-' }}</td>
                            <td class="py-2 text-slate-600">
                                {{ $room->pic_name ?? '-' }}<br>
                                <span class="text-[10px] text-slate-400">{{ $room->pic_jabatan }}</span>
                            </td>
                            <td class="py-2 text-slate-600">
                                {{ $room->leader_name ?? '-' }}<br>
                                <span class="text-[10px] text-slate-400">{{ $room->leader_jabatan }}</span>
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

    <!-- Form Master Template KOP Surat -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200 md:col-span-2 mt-2">
        <h3 class="text-lg font-bold text-slate-800 mb-4">Master Template KOP Surat Laporan</h3>
        
        @php
            $kop = \Modules\Asset\Models\InstitutionKop::first();
        @endphp

        <form action="{{ route('master.kop.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                <!-- Upload Logo -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Logo Instansi</label>
                    @if($kop && $kop->logo)
                        <div class="mb-2">
                            <img src="{{ asset('storage/' . $kop->logo) }}" alt="Logo" class="h-16 w-auto object-contain border p-1 rounded">
                        </div>
                    @endif
                    <input type="file" name="logo" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                </div>

                <!-- Pilih Jenis Font Global -->
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Jenis Font (Font Family)</label>
                    <select name="font_family" class="w-full border-slate-300 rounded-md shadow-sm text-sm">
                        <option value="Times New Roman, serif" {{ ($kop->font_family ?? '') == 'Times New Roman, serif' ? 'selected' : '' }}>Times New Roman</option>
                        <option value="Arial, sans-serif" {{ ($kop->font_family ?? '') == 'Arial, sans-serif' ? 'selected' : '' }}>Arial</option>
                        <option value="Courier New, monospace" {{ ($kop->font_family ?? '') == 'Courier New, monospace' ? 'selected' : '' }}>Courier New</option>
                    </select>
                </div>
            </div>

            <hr class="my-4 border-slate-200">

            <!-- Pengaturan 5 Baris Teks dan Ukurannya -->
            <div class="space-y-4">
                <!-- Baris 1 -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-center">
                    <div class="md:col-span-3">
                        <label class="block text-xs font-semibold text-slate-500 uppercase">Baris 1 (Kementerian / Lembaga)</label>
                        <input type="text" name="line_1" value="{{ $kop->line_1 ?? '' }}" placeholder="Contoh: KEMENTERIAN PENDIDIKAN TINGGI, SAIN, DAN TEKNOLOGI" class="w-full border-slate-300 rounded-md text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 uppercase">Ukuran Font</label>
                        <input type="text" name="size_1" value="{{ $kop->size_1 ?? '14px' }}" class="w-full border-slate-300 rounded-md text-sm">
                    </div>
                </div>

                <!-- Baris 2 -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-center">
                    <div class="md:col-span-3">
                        <label class="block text-xs font-semibold text-slate-500 uppercase">Baris 2 (Nama Universitas / Instansi Utama)</label>
                        <input type="text" name="line_2" value="{{ $kop->line_2 ?? '' }}" placeholder="Contoh: UNIVERSITAS BENGKULU" class="w-full border-slate-300 rounded-md text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 uppercase">Ukuran Font</label>
                        <input type="text" name="size_2" value="{{ $kop->size_2 ?? '16px' }}" class="w-full border-slate-300 rounded-md text-sm">
                    </div>
                </div>

                <!-- Baris 3 -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-center">
                    <div class="md:col-span-3">
                        <label class="block text-xs font-semibold text-slate-500 uppercase">Baris 3 (Fakultas / Unit Kerja)</label>
                        <input type="text" name="line_3" value="{{ $kop->line_3 ?? '' }}" placeholder="Contoh: UPA TEKNOLOGI INFORMASI DAN KOMUNIKASI" class="w-full border-slate-300 rounded-md text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 uppercase">Ukuran Font</label>
                        <input type="text" name="size_3" value="{{ $kop->size_3 ?? '13px' }}" class="w-full border-slate-300 rounded-md text-sm">
                    </div>
                </div>

                <!-- Baris 4 -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-center">
                    <div class="md:col-span-3">
                        <label class="block text-xs font-semibold text-slate-500 uppercase">Baris 4 (Alamat)</label>
                        <input type="text" name="line_4" value="{{ $kop->line_4 ?? '' }}" placeholder="Contoh: Jl. WR. Supratman, Kandang Limun Bengkulu" class="w-full border-slate-300 rounded-md text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 uppercase">Ukuran Font</label>
                        <input type="text" name="size_4" value="{{ $kop->size_4 ?? '11px' }}" class="w-full border-slate-300 rounded-md text-sm">
                    </div>
                </div>

                <!-- Baris 5 -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-center">
                    <div class="md:col-span-3">
                        <label class="block text-xs font-semibold text-slate-500 uppercase">Baris 5 (Telepon, Faksimile, Website, Email)</label>
                        <input type="text" name="line_5" value="{{ $kop->line_5 ?? '' }}" placeholder="Contoh: Telp: (0736) 21170 Laman: www.unib.ac.id" class="w-full border-slate-300 rounded-md text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-500 uppercase">Ukuran Font</label>
                        <input type="text" name="size_5" value="{{ $kop->size_5 ?? '11px' }}" class="w-full border-slate-300 rounded-md text-sm">
                    </div>
                </div>
            </div>

            <div class="mt-6 text-right">
                <button type="submit" class="px-5 py-2 bg-indigo-600 text-white font-semibold rounded-md shadow hover:bg-indigo-700 text-sm">Simpan Template KOP</button>
            </div>
        </form>
    </div>

</div>    
@endsection