@extends('asset::layouts.app')
@section('title', 'Master Departemen')
@section('header-title', 'Daftar Departemen / Divisi')

@section('content')
<div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200 max-w-3xl">
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