@extends('asset::layouts.app')

@section('title', 'Manajemen Aset')
@section('header-title', 'Perubahan Aset (Asset Inventory)')

@section('content')
    <div class="py-12 max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white p-6 shadow-sm sm:rounded-lg">
            <h2 class="text-xl font-bold mb-4">Edit Data Aset</h2>
            
            <form action="{{ route('inventory.update', $asset->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Field Nama Barang -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Nama Barang</label>
                    <input type="text" name="name" value="{{ old('name', $asset->name) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                </div>

                <!-- Field Merk / Tipe -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Merk / Tipe</label>
                    <input type="text" name="brand" value="{{ old('brand', $asset->brand) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                </div>

                <!-- Kolom Wajib: Alasan Perubahan Data -->
                <div class="mb-4 bg-yellow-50 p-4 rounded-lg border border-yellow-200">
                    <label class="block text-sm font-bold text-yellow-800 mb-1">Alasan Perubahan Data <span class="text-red-500">*</span></label>
                    <textarea name="reason" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="Contoh: Koreksi penulisan merk atau pemindahan lokasi fisik ruangan..." required></textarea>
                </div>

                <div class="flex justify-end gap-2">
                    <a href="{{ route('inventory.index') }}" class="px-4 py-2 bg-gray-300 rounded-md">Batal</a>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
@endsection