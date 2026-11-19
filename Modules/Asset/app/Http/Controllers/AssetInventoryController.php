<?php

namespace Modules\Asset\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Asset\Models\AssetItem;
use Modules\Asset\Models\Department;
use Modules\Asset\Models\Location;
use Modules\Asset\Models\Room;
use Modules\Asset\Services\AssetService; // Pastikan service di-import
use Modules\Asset\Models\StatusBarang;
use Modules\Asset\Models\SumberDana;

class AssetInventoryController extends Controller
{

    protected $assetService;

    // Inject AssetService melalui constructor
    public function __construct(AssetService $assetService)
    {
        $this->assetService = $assetService;
    }

    // 1. Daftar Semua Aset
    public function index()
    {
        $assets = AssetItem::with(['department', 'location', 'room'])->latest()->get();
        return view('asset::inventory.index', compact('assets'));
    }

    // 2. Form Tambah Aset
    public function create(Request $request)
    {
        $departments = Department::all();
        $locations = Location::all();
        $rooms = Room::all();
        $bmnItems = \Modules\Asset\Models\BmnItem::all(); // Ambil data BMN
        $statusBarang = StatusBarang::all();
        $sumberDana = SumberDana::all();

        // Ambil ID dari session terakhir atau request aktif untuk input massal
        $selectedDept = session('last_department_id') ?? $request->department_id;
        $selectedLoc = session('last_location_id') ?? $request->location_id;
        $selectedRoom = session('last_room_id') ?? $request->room_id;

        // Ambil daftar aset terbaru berdasarkan ruangan tersebut (misal 5 data terakhir)
        $recentAssets = [];
        if ($selectedRoom) {
            $recentAssets = AssetItem::where('room_id', $selectedRoom)
                ->latest()
                ->take(5)
                ->get();
        }

        return view('asset::inventory.create', compact(
            'departments', 'locations', 'rooms', 'bmnItems', 'recentAssets',
            'selectedDept', 'selectedLoc', 'selectedRoom', 'statusBarang', 'sumberDana'
        ));
    }

    // Simpan Aset Baru (Mendukung Input Satuan & Massal + Nomor Urut)
    public function store(Request $request)
    {
        // 1. Validasi input dasar
        $validated = $request->validate([
            'department_id' => 'required|exists:departments,id',
            'location_id'   => 'required|exists:locations,id',
            'room_id'       => 'required|exists:rooms,id',
            'name'          => 'required|string|max:255',
            'code'          => 'required|string|max:255', // Kode dasar BMN yang dipilih
            'brand'         => 'nullable|string|max:255',
            'status'        => 'required|string',
            'quantity'      => 'required|integer|min:1',
            'unit'          => 'required|string|max:50',
            'price'         => 'nullable|numeric',
            'acquisition_year' => 'required|digits:4|integer',
            'sumber_dana'   => 'required|string|max:50',
            'pic'           => 'nullable|string|max:255',
            'notes'         => 'nullable|string',
            'image'         => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
        ]);

        $location = \Modules\Asset\Models\Location::find($request->location_id);

        $qty = $request->input('quantity', 1);
        $baseCode = $request->input('code'); // Contoh: "3.10.01.02.001.00001" atau "3.10.01.02.001"

        // Handle Upload Gambar jika ada
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('assets', 'public');
        }

        // 2. Loop sebanyak jumlah (quantity) yang diinput untuk melanjutkan nomor urut
        for ($i = 0; $i < $qty; $i++) {
            
            // Cari aset terakhir di database yang memiliki pola kode yang sama
            // Untuk memastikan nomor urut terus berlanjut secara unik tanpa duplikasi
            $lastAsset = \Modules\Asset\Models\AssetItem::where('code', 'LIKE', "{$baseCode}%")
                ->orderBy('id', 'desc')
                ->first();

            $newCode = $baseCode;

            if ($lastAsset) {
                // Ambil bagian belakang kode (nomor urut) lalu dinaikkan 1 angka
                // Asumsi format kode berakhiran nomor urut 5 digit (misal: .00001)
                $parts = explode('.', $lastAsset->code);
                $lastNumber = (int) end($parts);
                $nextNumber = $lastNumber + 1;
                
                // Gabungkan kembali dengan format titik dan 5 digit angka (padding 0)
                array_pop($parts);
                $newCode = implode('.', $parts) . '.' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
            } else {
                // Jika belum ada sama sekali, pastikan format awalnya berakhiran .00001 jika belum ada
                if (!str_ends_with($baseCode, '.00001') && strlen($baseCode) < 22) {
                    $newCode = rtrim($baseCode, '.') . '.00001';
                }
            }

            // Siapkan data per item
            $itemData = $validated;
            $itemData['code'] = $newCode;
            if ($imagePath) {
                $itemData['image'] = $imagePath;
            }

            // Simpan ke database
            \Modules\Asset\Models\AssetItem::create($itemData);
        }

        // 3. Redirect berdasarkan tombol yang diklik
        if ($request->input('action') === 'save_and_add') {
            return redirect()->route('inventory.create')
                ->with('success', "Berhasil menyimpan {$qty} aset dengan penomoran otomatis yang dilanjutkan!");
        }

        return redirect()->route('inventory.index')
            ->with('success', "Berhasil menyimpan {$qty} aset baru.");
    }

    // 3. Detail Aset & Riwayat
    public function show($id)
    {
        $asset = AssetItem::with(['department', 'location', 'room','histories'])->findOrFail($id);
        return view('asset::inventory.show', compact('asset'));
    }

    // 4. Cetak Barcode / QR Code
    public function barcode($id)
    {
        $asset = AssetItem::findOrFail($id);
        return view('asset::inventory.barcode', compact('asset'));
    }

    public function edit($id)
    {
        $asset = AssetItem::findOrFail($id);
        $departments = \Modules\Asset\Models\Department::all();
        $locations = \Modules\Asset\Models\Location::all();
        $rooms = \Modules\Asset\Models\Room::all();

        return view('asset::inventory.edit', compact('asset', 'departments', 'locations', 'rooms'));
    }

        public function update(Request $request, $id) {
        $request->validate([
            'reason' => 'required|string|max:255', // Alasan wajib diisi saat edit
        ]);

        $this->assetService->updateAsset($id, $request->all());

        return redirect()->route('inventory.index')->with('success', 'Aset berhasil diperbarui dan riwayat perubahan dicatat.');
    }

    // Hapus Aset
    public function destroy($id)
    {
        AssetItem::findOrFail($id)->delete();
        return redirect()->route('inventory.index')->with('success', 'Aset berhasil dihapus dari sistem!');
    }

    public function searchBmnItems(Request $request)
    {
        $keyword = $request->get('q', '');

        $items = \Modules\Asset\Models\BmnItem::where('name', 'LIKE', "%{$keyword}%")
                    ->orWhere('code', 'LIKE', "%{$keyword}%")
                    ->limit(25)
                    ->get(['code', 'name']);

        return response()->json($items);
    }
}