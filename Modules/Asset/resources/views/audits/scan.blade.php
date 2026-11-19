@extends('asset::layouts.app')

@section('title', 'Scan Barcode Audit')
@section('header-title', 'Scan Aset: ' . $session->session_name)

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    @if(session('success'))
        <div class="bg-emerald-100 border border-emerald-400 text-emerald-700 px-4 py-3 rounded-xl text-xs">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="bg-rose-100 border border-rose-400 text-rose-700 px-4 py-3 rounded-xl text-xs">{{ session('error') }}</div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        
        <!-- KOLOM 1: KAMERA SCANNER HP -->
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm space-y-3">
            <h3 class="text-xs font-bold text-slate-700 uppercase">Kamera Scanner (HP / Webcam)</h3>
            <div id="reader" class="w-full rounded-lg overflow-hidden border border-slate-200 bg-slate-50"></div>
            <p class="text-[11px] text-slate-400 text-center">Arahkan kamera ke barcode/QR code aset untuk memindai secara otomatis.</p>
        </div>

        <!-- KOLOM 2: INPUT MANUAL & FORM -->
        <div class="bg-white p-5 rounded-xl border border-slate-200 shadow-sm space-y-4 flex flex-col justify-between">
            <div class="space-y-4">
                <h3 class="text-xs font-bold text-slate-700 uppercase">Input Manual Kode BMN</h3>
                <form id="scanForm" action="{{ route('audits.process-scan', $session->id) }}" method="POST" class="space-y-3">
                    @csrf
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-500 mb-1">Kode BMN / Barcode</label>
                        <input type="text" id="code" name="code" placeholder="Scan atau ketik kode BMN..." class="w-full border border-slate-300 rounded-lg px-3 py-2 text-xs outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>
                    <button type="submit" class="w-full bg-blue-600 text-white text-xs px-4 py-2.5 rounded-lg font-medium hover:bg-blue-700 transition">Catat Ditemukan</button>
                </form>
            </div>

            <div class="pt-4 border-t border-slate-100">
                <a href="{{ route('audits.index') }}" class="block text-center w-full px-4 py-2 bg-slate-100 text-slate-600 rounded-lg text-xs font-medium hover:bg-slate-200 transition">Selesai & Kembali</a>
            </div>
        </div>

    </div>

    <!-- RIWAYAT HASIL SCAN DALAM SESI INI -->
    <div class="bg-white p-6 rounded-xl border border-slate-200 shadow-sm space-y-4">
        <h3 class="text-xs font-bold text-slate-700 uppercase">Riwayat Aset yang Telah Dipindai</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="border-b text-slate-400">
                        <th class="py-2">Kode BMN</th>
                        <th class="py-2">Nama Barang</th>
                        <th class="py-2">Waktu Scan</th>
                        <th class="py-2">Status Audit</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($scannedItems->where('audit_status', 'Ditemukan') as $item)
                        <tr>
                            <td class="py-2.5 font-bold text-slate-700">{{ $item->asset->code ?? '-' }}</td>
                            <td class="py-2.5 text-slate-600">{{ $item->asset->name ?? '-' }}</td>
                            <td class="py-2.5 text-slate-500">{{ $item->scanned_at }}</td>
                            <td class="py-2.5"><span class="px-2 py-0.5 rounded text-[10px] bg-emerald-100 text-emerald-700 font-semibold">Ditemukan</span></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- CDN HTML5 QRCODE SCANNER -->
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script>
    function onScanSuccess(decodedText, decodedResult) {
        // Masukkan hasil scan ke input form
        document.getElementById('code').value = decodedText;
        // Submit form secara otomatis
        document.getElementById('scanForm').submit();
    }

    let html5QrcodeScanner = new Html5QrcodeScanner(
        "reader", { fps: 10, qrbox: { width: 250, height: 150 } }, false);
    html5QrcodeScanner.render(onScanSuccess);
</script>
@endsection