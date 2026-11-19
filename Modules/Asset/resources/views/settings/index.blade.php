@extends('asset::layouts.app')

@section('title', 'Pengaturan & Hak Akses')
@section('header-title', 'Pengaturan & Hak Akses (Settings & Users)')

@section('content')

                <!-- Bagian 1: Pengaturan Umum -->
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-6">
                    <h3 class="text-lg font-bold text-slate-800 mb-4">1. Pengaturan Umum (General Settings)</h3>
                    <form action="{{ route('settings.update') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-1">Nama Fakultas</label>
                            <input type="text" name="company_name" value="Hukum" class="w-full border border-slate-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-600 mb-1">Unit</label>
                            <input type="text" name="asset_code_format" value="Rumah Tangga" class="w-full border border-slate-300 rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500 outline-none">
                            <span class="text-xs text-slate-400 mt-1 block">Contoh: Rumah Tangga</span>
                        </div>
                        <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded-lg text-sm font-medium hover:bg-blue-700 transition">Simpan Perubahan</button>
                    </form>
                </div>

                <!-- Bagian 2: Manajemen Pengguna (Users & Roles) -->
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                    <h3 class="text-lg font-bold text-slate-800 mb-4">2. Manajemen Pengguna & Hak Akses Modul</h3>

                    @if($errors->any())
                        <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm">
                            <ul class="list-disc pl-4">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                   <!-- Form Tambah / Edit Pengguna -->
                    <form action="{{ isset($user) ? route('settings.users.update', $user->id) : route('settings.users.store') }}" method="POST" class="bg-slate-50 p-5 rounded-xl border border-slate-200 mb-8 space-y-5">
                        @csrf
                        @if(isset($user))
                            @method('PUT')
                            <div class="flex justify-between items-center border-b pb-3">
                                <h4 class="text-sm font-bold text-slate-700">Edit Pengguna: {{ $user->name }}</h4>
                                <a href="{{ route('settings.index') }}" class="text-xs text-red-600 font-medium hover:underline">Batal Edit</a>
                            </div>
                        @else
                            <h4 class="text-sm font-bold text-slate-700 border-b pb-3">Tambah Pengguna Baru & Hak Akses</h4>
                        @endif
                        
                        <!-- Grid Input Utama -->
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <!-- Nama -->
                            <div>
                                <label class="block text-xs font-medium text-slate-600 mb-1">Nama Lengkap</label>
                                <input type="text" name="name" value="{{ isset($user) ? $user->name : old('name') }}" placeholder="Contoh: Budi Staff" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm bg-white focus:ring-2 focus:ring-blue-500 outline-none" required>
                            </div>

                            <!-- Email -->
                            <div>
                                <label class="block text-xs font-medium text-slate-600 mb-1">Email</label>
                                <input type="email" name="email" value="{{ isset($user) ? $user->email : old('email') }}" placeholder="budi@example.com" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm bg-white focus:ring-2 focus:ring-blue-500 outline-none" required>
                            </div>

                            <!-- Role / Tingkatan -->
                            <div>
                                <label class="block text-xs font-medium text-slate-600 mb-1">Role / Tingkatan</label>
                                <select name="role" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm bg-white focus:ring-2 focus:ring-blue-500 outline-none" required>
                                    <option value="Super Admin" {{ (isset($user) && $user->role == 'Super Admin') ? 'selected' : '' }}>Super Admin</option>
                                    <option value="Staff Gudang" {{ (isset($user) && $user->role == 'Operator') ? 'selected' : '' }}>Operator</option>
                                    <option value="Viewer/Auditor" {{ (isset($user) && $user->role == 'Guest') ? 'selected' : '' }}>Guest</option>
                                </select>
                            </div>

                            <!-- Password -->
                            <div>
                                <label class="block text-xs font-medium text-slate-600 mb-1">Password {{ isset($user) ? '(Opsional)' : '' }}</label>
                                <input type="password" name="password" placeholder="{{ isset($user) ? 'Kosongkan jika tetap' : 'Minimal 6 karakter' }}" class="w-full border border-slate-300 rounded-lg px-3 py-2 text-sm bg-white focus:ring-2 focus:ring-blue-500 outline-none" {{ isset($user) ? '' : 'required' }}>
                            </div>
                        </div>

                        <!-- Bagian Checkbox Hak Akses Modul (Sinkron dengan Route Middleware) -->
                        <div class="pt-2 border-t border-slate-200">
                            <div class="flex justify-between items-center mb-2">
                                <div>
                                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Hak Akses Modul Sistem</label>
                                    <p class="text-xs text-slate-500">Pilih modul rute yang diizinkan untuk diakses oleh pengguna ini:</p>
                                </div>
                                <button type="button" onclick="toggleAllModules(event)" class="text-xs text-blue-600 hover:text-blue-800 font-semibold bg-blue-50 px-2.5 py-1 rounded-md border border-blue-100 transition">Pilih Semua</button>
                            </div>
                            
                            @php
                                $userModules = isset($user) && is_array($user->modules) ? $user->modules : [];
                            @endphp

                            <div class="grid grid-cols-2 md:grid-cols-3 gap-3 mt-3">
                                <!-- 1. Modul Dashboard & Utama -->
                                <label class="flex items-center space-x-2.5 bg-white p-3 rounded-lg border border-slate-200 cursor-pointer hover:border-blue-300 transition">
                                    <input type="checkbox" name="modules[]" value="dashboard" {{ in_array('dashboard', $userModules) ? 'checked' : '' }} class="module-checkbox rounded border-slate-300 text-blue-600 focus:ring-blue-500 w-4 h-4">
                                    <span class="text-sm font-medium text-slate-700">Dashboard Utama</span>
                                </label>

                                <!-- 2. Modul Pengaturan (module:settings) -->
                                <label class="flex items-center space-x-2.5 bg-white p-3 rounded-lg border border-slate-200 cursor-pointer hover:border-blue-300 transition">
                                    <input type="checkbox" name="modules[]" value="settings" {{ in_array('settings', $userModules) ? 'checked' : '' }} class="module-checkbox rounded border-slate-300 text-blue-600 focus:ring-blue-500 w-4 h-4">
                                    <span class="text-sm font-medium text-slate-700">Pengaturan & Users</span>
                                </label>

                                <!-- 3. Modul Data Aset (module:assets) -->
                                <label class="flex items-center space-x-2.5 bg-white p-3 rounded-lg border border-slate-200 cursor-pointer hover:border-blue-300 transition">
                                    <input type="checkbox" name="modules[]" value="assets" {{ in_array('assets', $userModules) ? 'checked' : '' }} class="module-checkbox rounded border-slate-300 text-blue-600 focus:ring-blue-500 w-4 h-4">
                                    <span class="text-sm font-medium text-slate-700">Data Aset / Inventaris</span>
                                </label>

                                <!-- 4. Modul Transaksi (module:transactions) -->
                                <label class="flex items-center space-x-2.5 bg-white p-3 rounded-lg border border-slate-200 cursor-pointer hover:border-blue-300 transition">
                                    <input type="checkbox" name="modules[]" value="transactions" {{ in_array('transactions', $userModules) ? 'checked' : '' }} class="module-checkbox rounded border-slate-300 text-blue-600 focus:ring-blue-500 w-4 h-4">
                                    <span class="text-sm font-medium text-slate-700">Transaksi (Mutasi/Pinjam/Maint)</span>
                                </label>

                                <!-- 5. Modul Audit / Stock Opname (module:stock_opname) -->
                                <label class="flex items-center space-x-2.5 bg-white p-3 rounded-lg border border-slate-200 cursor-pointer hover:border-blue-300 transition">
                                    <input type="checkbox" name="modules[]" value="stock_opname" {{ in_array('stock_opname', $userModules) ? 'checked' : '' }} class="module-checkbox rounded border-slate-300 text-blue-600 focus:ring-blue-500 w-4 h-4">
                                    <span class="text-sm font-medium text-slate-700">Audit & Stock Opname</span>
                                </label>

                                <!-- 6. Modul Laporan (module:reports) -->
                                <label class="flex items-center space-x-2.5 bg-white p-3 rounded-lg border border-slate-200 cursor-pointer hover:border-blue-300 transition">
                                    <input type="checkbox" name="modules[]" value="reports" {{ in_array('reports', $userModules) ? 'checked' : '' }} class="module-checkbox rounded border-slate-300 text-blue-600 focus:ring-blue-500 w-4 h-4">
                                    <span class="text-sm font-medium text-slate-700">Laporan & Cetak</span>
                                </label>
                            </div>
                        </div>

                        <button type="submit" class="bg-blue-600 text-white text-xs px-5 py-2.5 rounded-lg font-semibold hover:bg-blue-700 transition shadow-sm">
                            {{ isset($user) ? 'Perbarui Pengguna & Hak Akses' : '+ Simpan Pengguna Baru' }}
                        </button>
                    </form>

                    <!-- Tabel Daftar Pengguna -->
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b text-sm text-slate-500">
                                    <th class="py-3">Nama</th>
                                    <th class="py-3">Email</th>
                                    <th class="py-3">Role / Tingkatan</th>
                                    <th class="py-3">Modul yang Diizinkan</th>
                                    <th class="py-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm divide-y">
                                @forelse($users as $u)
                                <tr>
                                    <td class="py-3 font-medium text-slate-700">{{ $u->name }}</td>
                                    <td class="py-3 text-slate-600">{{ $u->email }}</td>
                                    <td class="py-3">
                                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold 
                                            {{ $u->role == 'Super Admin' ? 'bg-purple-100 text-purple-700' : ($u->role == 'Staff Gudang' ? 'bg-blue-100 text-blue-700' : 'bg-emerald-100 text-emerald-700') }}">
                                            {{ $u->role }}
                                        </span>
                                    </td>
                                    <td class="py-3 text-slate-600">
                                        @if(is_array($u->modules) && count($u->modules) > 0)
                                            <div class="flex flex-wrap gap-1">
                                                @foreach($u->modules as $mod)
                                                    <span class="bg-slate-100 text-slate-600 text-[10px] px-2 py-0.5 rounded uppercase font-medium">{{ $mod }}</span>
                                                @endforeach
                                            </div>
                                        @else
                                            <span class="text-xs text-slate-400 italic">Tidak ada modul khusus</span>
                                        @endif
                                    </td>
                                    <td class="py-3 text-slate-500">
                                        <div class="flex items-center space-x-3">
                                            <!-- Cek apakah email user BUKAN tedy@gmail.com -->
                                            @if($u->email !== 'tedy@gmail.com')
                                                <!-- Tombol Edit -->
                                                <a href="{{ route('settings.users.edit', $u->id) }}" class="text-blue-600 hover:underline font-medium">Edit</a>

                                                <!-- Tombol Hapus -->
                                                <form action="{{ route('settings.users.destroy', $u->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pengguna ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:underline font-medium bg-transparent border-0 cursor-pointer p-0">Hapus</button>
                                                </form>
                                            @else
                                                <!-- Teks khusus untuk menandai akun utama/protected -->
                                                <span class="text-xs text-slate-400 italic bg-slate-100 px-2.5 py-1 rounded">Protected Admin</span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="py-4 text-center text-slate-400">Belum ada data pengguna.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

    <!-- Script JavaScript Pendukung (Pilih Semua Checkbox) -->
    <script>
        function toggleAllModules(event) {
            const checkboxes = document.querySelectorAll('.module-checkbox');
            const allChecked = Array.from(checkboxes).every(cb => cb.checked);
            
            checkboxes.forEach(cb => {
                cb.checked = !allChecked;
            });
            
            event.target.textContent = !allChecked ? 'Batalkan Semua' : 'Pilih Semua';
        }
    </script>

@endsection