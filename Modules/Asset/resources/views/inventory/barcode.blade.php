@extends('asset::layouts.app')

@section('title', 'Cetak Barcode')
@section('header-title', 'Cetak Barcode / QR Code Aset')

@section('content')
<div class="bg-white p-8 rounded-xl shadow-sm border border-slate-200 max-w-md mx-auto text-center space-y-6">
    <div>
        <h3 class="text-lg font-bold text-slate-800">{{ $asset->name }}</h3>
        <p class="text-xs text-slate-500 font-mono mt-1">{{ $asset->code }}</p>
    </div>

    <!-- Simulasi Label Barcode -->
    <div class="border-2 border-dashed border-slate-300 p-6 rounded-xl bg-slate-50 inline-block w-full space-y-3">
        <div class="font-mono text-2xl font-bold tracking-widest text-slate-800">*{{ $asset->code }}*</div>
        <div class="text-[11px] text-slate-600">Lokasi: {{ $asset->location->name ?? '-' }} ({{ $asset->room->name ?? '-' }})</div>
    </div>

    <div class="flex justify-center space-x-3">
        <button onclick="window.print()" class="bg-blue-600 text-white text-xs px-4 py-2 rounded-lg font-medium hover:bg-blue-700">Cetak Label</button>
        <a href="{{ route('inventory.index') }}" class="bg-slate-200 text-slate-700 text-xs px-4 py-2 rounded-lg font-medium">Kembali</a>
    </div>
</div>
@endsection