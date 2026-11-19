@extends('asset::layouts.app')

@section('title', 'Tambah Aset')
@section('header-title', 'Form Tambah Aset Baru')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Notifikasi Sukses -->
    {{-- @if(session('success'))
        <div class="bg-emerald-100 border border-emerald-400 text-emerald-700 px-4 py-3 rounded-xl text-xs flex justify-between items-center">
            <span>{{ session('success') }}</span>
            <span class="font-bold cursor-pointer" onclick="this.parentElement.style.display='none'">&times;</span>
        </div>
    @endif --}}

    <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
        <form action="{{ route('inventory.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- BAGIAN ATAS: LOKASI & PENEMPATAN -->
            <div class="bg-slate-50 p-4 rounded-xl border border-slate-200 space-y-4">
                <div class="flex items-center justify-between border-b border-slate-200 pb-2">
                    <h3 class="text-xs font-bold text-slate-700 uppercase tracking-wider">1. Informasi Lokasi & Penempatan Aset</h3>
                    <span class="text-[11px] text-blue-600 font-medium">Nilai otomatis tersimpan untuk input massal</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-medium text-slate-600 mb-1">Departemen / Divisi</label>
                        <select name="department_id" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-xs bg-white outline-none focus:ring-2 focus:ring-blue-500" required>
                            <option value="">-- Pilih Departemen --</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->id }}" {{ (old('department_id', $selectedDept ?? '') == $dept->id) ? 'selected' : '' }}>
                                    {{ $dept->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-slate-600 mb-1">Lokasi Gedung</label>
                        <select name="location_id" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-xs bg-white outline-none focus:ring-2 focus:ring-blue-500" required>
                            <option value="">-- Pilih Lokasi Gedung --</option>
                            @foreach($locations as $loc)
                                <option value="{{ $loc->id }}" {{ (old('location_id', $selectedLoc ?? '') == $loc->id) ? 'selected' : '' }}>
                                    {{ $loc->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-slate-600 mb-1">Ruangan</label>
                        <select name="room_id" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-xs bg-white outline-none focus:ring-2 focus:ring-blue-500" required>
                            <option value="">-- Pilih Ruangan --</option>
                            @foreach($rooms as $room)
                                <option value="{{ $room->id }}" {{ (old('room_id', $selectedRoom ?? '') == $room->id) ? 'selected' : '' }}>
                                    {{ $room->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- BAGIAN BAWAH: DETAIL SPESIFIK ASET -->
            <div class="space-y-4">
                <div class="border-b border-slate-200 pb-2">
                    <h3 class="text-xs font-bold text-slate-700 uppercase tracking-wider">2. Detail Spesifik Barang & Kondisi</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                    <!-- KOLOM NAMA BARANG (Mengambil 2 Kolom) -->
                    <div class="relative md:col-span-2">
                        <label class="block text-xs font-medium text-slate-600 mb-1">Nama Barang (Ketik untuk Mencari BMN)</label>

                        <!-- Input Pencarian -->
                        <input type="text"
                            id="searchBmnInput"
                            placeholder="Ketik nama barang (cth: Komputer, Meja, Laptop)..."
                            class="w-full border border-slate-300 rounded-lg px-3 py-2 text-xs bg-white outline-none focus:ring-2 focus:ring-blue-500"
                            autocomplete="off" required>

                        <!-- Hidden Input untuk Database -->
                        <input type="hidden" name="name" id="selectedBmnName" required>

                        <!-- Dropdown Hasil Pencarian -->
                        <div id="bmnDropdownList"
                            class="absolute left-0 right-0 top-full mt-1 bg-white border border-slate-200 rounded-lg shadow-xl max-h-60 overflow-y-auto text-xs z-50 hidden">
                        </div>
                    </div>

                    <!-- KOLOM KODE BMN OTOMATIS (Mengambil 1 Kolom) -->
                    <div class="md:col-span-1">
                        <label class="block text-xs font-medium text-slate-600 mb-1">Kode BMN / Barcode ID</label>
                        <input type="text"
                            name="code"
                            id="selectedBmnCode"
                            class="w-full border border-slate-300 rounded-lg px-3 py-2 text-xs bg-slate-100 font-mono outline-none"
                            placeholder="Otomatis terisi"
                            readonly
                            required>
                    </div>

                    <!-- TIPE / MERK (2 Kolom) -->
                    <div class="md:col-span-2">
                        <label class="block text-xs font-medium text-slate-600 mb-1">Tipe / Merk</label>
                        <input type="text" name="brand" placeholder="Contoh: Lenovo Thinkpad" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-xs outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>

                    <!-- STATUS FISIK ASET (1 Kolom) - Diambil dari tabel status_barang -->
                    <div class="md:col-span-1">
                        <label class="block text-xs font-medium text-slate-600 mb-1">Status Fisik Aset</label>
                        <select name="status" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-xs bg-white outline-none focus:ring-2 focus:ring-blue-500" required>
                            <option value="">-- Pilih Status Fisik --</option>
                            @foreach($statusBarang ?? [] as $status)
                                <option value="{{ $status->kondisi }}" {{ old('status') == $status->kondisi ? 'selected' : '' }}>
                                    {{ $status->kondisi }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- JUMLAH & SATUAN (1 Kolom) -->
                    <div class="md:col-span-1">
                        <label class="block text-xs font-medium text-slate-600 mb-1">Jumlah & Satuan</label>
                        <div class="flex gap-2">
                            <input type="number" name="quantity" value="1" min="1" class="w-20 border border-slate-300 rounded-lg px-3 py-2 text-xs outline-none focus:ring-2 focus:ring-blue-500" required>
                            <input type="text" name="unit" value="Pcs" class="flex-1 border border-slate-300 rounded-lg px-3 py-2 text-xs outline-none focus:ring-2 focus:ring-blue-500" required>
                        </div>
                    </div>

                    <!-- HARGA ASET (1 Kolom) -->
                    <div class="md:col-span-1">
                        <label class="block text-xs font-medium text-slate-600 mb-1">Harga Aset (Rp)</label>
                        <input type="number" name="price" step="0.01" value="{{ old('price') }}" placeholder="Contoh: 5000000" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-xs outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                    <!-- Tahun Perolehan -->
                    <div>
                        <label class="block text-xs font-medium text-slate-700 mb-1">Tahun Perolehan</label>
                        <input type="number" name="acquisition_year" min="2000" max="{{ date('Y') }}" value="{{ date('Y') }}" placeholder="Contoh: 2026" class="w-full border border-slate-300 rounded-lg px-3 py-1.5 text-xs outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>

                    <!-- Sumber Dana - Diambil dari tabel sumber_dana -->
                     <div>
                        <label class="block text-xs font-medium text-slate-700 mb-1">Sumber Dana</label>
                        <select name="sumber_dana" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-xs bg-white outline-none focus:ring-2 focus:ring-blue-500" required>
                            <option value="">-- Pilih Sumber Dana --</option>
                            @foreach($sumberDana ?? [] as $dana)
                                <option value="{{ $dana->nama_sumber_dana }}" {{ old('sumber_dana') == $dana->nama_sumber_dana ? 'selected' : '' }}>
                                    {{ $dana->nama_sumber_dana }}
                                </option>
                            @endforeach
                        </select>                        
                    </div>

                    <!-- PENANGGUNG JAWAB (PIC) (2 Kolom) -->
                    <div class="md:col-span-2">
                        <label class="block text-xs font-medium text-slate-600 mb-1">Penanggung Jawab (PIC)</label>
                        <input type="text" name="pic" placeholder="Nama Pegawai / Staff" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-xs outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <!-- CATATAN (3 Kolom penuh) -->
                    <div class="md:col-span-3">
                        <label class="block text-xs font-medium text-slate-600 mb-1">Catatan</label>
                        <input type="text" name="notes" placeholder="Catatan tambahan jika ada..." class="w-full border border-slate-300 rounded-lg px-3 py-2 text-xs outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <!-- UNGGAH FOTO FISIK BARANG (3 Kolom penuh) -->
                    <div class="md:col-span-3">
                        <label class="block text-xs font-medium text-slate-600 mb-1">Unggah Foto Fisik Barang</label>
                        <input type="file" name="image" accept="image/*" class="w-full border border-slate-300 rounded-lg px-3 py-1.5 text-xs bg-white outline-none file:mr-4 file:py-1 file:px-3 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    </div>

                </div>
            </div>
            <!-- BUTTONS -->
            <div class="flex justify-between items-center pt-4 border-t">
                <a href="{{ route('inventory.index') }}" class="bg-slate-200 text-slate-700 text-xs px-4 py-2 rounded-lg font-medium hover:bg-slate-300 transition">Selesai & Kembali ke Daftar</a>

                <div class="space-x-2">
                    <button type="submit" name="action" value="save_and_add" class="bg-blue-600 text-white text-xs px-5 py-2 rounded-lg font-medium hover:bg-blue-700 transition">+ Simpan & Tambah Aset Lagi</button>
                </div>
            </div>
        </form>
    </div>

    <!-- TABEL ASET TERBARU -->
    <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200 space-y-4">
        <h3 class="text-xs font-bold text-slate-700 uppercase tracking-wider">Aset Terbaru di Ruangan Ini</h3>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="border-b text-slate-400">
                        <th class="py-2">Kode / Nama Barang</th>
                        <th class="py-2">Merk / Tipe</th>
                        <th class="py-2">Jumlah</th>
                        <th class="py-2">Status</th>
                        <th class="py-2 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($recentAssets ?? [] as $item)
                        <tr>
                            <td class="py-2.5">
                                <span class="font-bold text-slate-700 block">{{ $item->name }}</span>
                                <span class="text-slate-400 text-[11px] font-mono">{{ $item->code }}</span>
                            </td>
                            <td class="py-2.5 text-slate-600">{{ $item->brand ?? '-' }}</td>
                            <td class="py-2.5 font-semibold text-slate-700">{{ $item->quantity }} {{ $item->unit }}</td>
                            <td class="py-2.5">
                                <span class="px-2 py-0.5 rounded text-[10px] font-medium bg-emerald-100 text-emerald-700">
                                    {{ $item->status }}
                                </span>
                            </td>
                            <td class="py-2.5 text-right">
                                <a href="{{ route('inventory.show', $item->id) }}" class="text-blue-600 hover:underline">Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="py-4 text-center text-slate-400">Belum ada aset yang diinput pada sesi ruangan ini.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>



<!-- Script JavaScript Murni untuk Pencarian & Auto-Fill -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Ambil data BMN secara aman melalui atribut JSON yang di-encode PHP
        const bmnItems = JSON.parse('{!! addslashes(json_encode($bmnItems ?? [])) !!}');

        console.log("Total BMN dimuat:", bmnItems.length);

        const searchInput = document.getElementById('searchBmnInput');
        const hiddenName = document.getElementById('selectedBmnName');
        const hiddenCode = document.getElementById('selectedBmnCode');
        const dropdown = document.getElementById('bmnDropdownList');

        if (!searchInput) return;

        searchInput.addEventListener('input', function () {
            const keyword = this.value.toLowerCase().trim();
            
            if (keyword.length === 0) {
                dropdown.innerHTML = '';
                dropdown.classList.add('hidden');
                return;
            }

            const filtered = bmnItems.filter(item => 
                item.name && item.name.toLowerCase().includes(keyword)
            ).slice(0, 40);

            if (filtered.length > 0) {
                let html = '';
                filtered.forEach(item => {
                    html += `<div class="p-2.5 hover:bg-blue-50 cursor-pointer border-b border-slate-100 last:border-b-0" data-name="${item.name.replace(/"/g, '&quot;')}" data-code="${item.code}">
                        <span class="font-medium text-slate-800 block">${item.name}</span>
                        <span class="text-slate-400 font-mono text-[10px]">Kode BMN: ${item.code}</span>
                    </div>`;
                });
                dropdown.innerHTML = html;
                dropdown.classList.remove('hidden');
            } else {
                dropdown.innerHTML = '<div class="p-3 text-slate-400 text-center">Barang tidak ditemukan</div>';
                dropdown.classList.remove('hidden');
            }
        });

        // Event klik pada hasil pencarian
        dropdown.addEventListener('click', function (e) {
            const target = e.target.closest('div[data-name]');
            if (target) {
                const name = target.getAttribute('data-name');
                const code = target.getAttribute('data-code');

                searchInput.value = name;
                hiddenName.value = name;
                hiddenCode.value = code;
                dropdown.innerHTML = '';
                dropdown.classList.add('hidden');
            }
        });

        // Tutup dropdown jika klik di luar
        document.addEventListener('click', function (e) {
            if (!searchInput.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.add('hidden');
            }
        });
    });
</script>
@endsection
