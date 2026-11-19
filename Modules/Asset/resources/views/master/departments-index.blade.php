@extends('asset::layouts.app')
@section('title', 'Master Departemen')
@section('header-title', 'Daftar Departemen / Divisi')

@section('content')
<div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200 max-w-3xl">
    <form action="{{ route('master.department.store') }}" method="POST" class="flex gap-2 mb-6">
        @csrf
        <input type="text" name="name" placeholder="Nama Departemen (Contoh: IT)" class="flex-1 border border-slate-300 rounded-lg px-3 py-2 text-xs outline-none focus:ring-2 focus:ring-blue-500" required>
        <button type="submit" class="bg-slate-800 text-white text-xs px-4 py-2 rounded-lg font-medium hover:bg-slate-700 whitespace-nowrap">+ Tambah Departemen</button>
    </form>

    <div class="border-t border-slate-100 pt-2 overflow-x-auto">
        <table class="w-full text-left text-xs">
            <thead>
                <tr class="border-b text-slate-400">
                    <th class="py-2 font-medium">Nama Departemen</th>
                    <th class="py-2 text-right font-medium">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($departments as $dept)
                    <tr>
                        <td class="py-2.5 text-slate-700 font-medium">{{ $dept->name }}</td>
                        <td class="py-2.5 text-right">
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
@endsection