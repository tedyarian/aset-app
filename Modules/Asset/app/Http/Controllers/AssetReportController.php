<?php

namespace Modules\Asset\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Asset\Models\AssetItem;
use Modules\Asset\Models\AssetMaintenance;
use Modules\Asset\Models\Room;

class AssetReportController extends Controller
{
    // Halaman Utama Menu Laporan
    public function index()
    {
        return view('asset::reports.index');
    }

    // 1. Laporan Posisi Aset (berdasarkan lokasi/kategori)
    public function position(Request $request)
    {
        // Contoh pada method position() di AssetReportController
        $query = AssetItem::with(['department', 'location', 'room']); // Hapus 'category' jika tidak dipakai
        
        
        if ($request->filled('location_id')) {
            $query->where('room_id', $request->location_id);
        }

        $assets = $query->latest()->get();
        return view('asset::reports.position', compact('assets'));
    }

    public function roomReport(Request $request)
    {
        $locations = \Modules\Asset\Models\Location::all();
        $rooms = collect(); // Kosongkan dulu sebelum gedung dipilih

        $selectedLocationId = $request->get('location_id');
        $selectedRoomId = $request->get('room_id');

        $assets = collect();
        $selectedRoom = null;

        // Jika gedung dipilih, ambil ruangan yang ada di gedung tersebut atau semua ruangan
        if ($selectedLocationId) {
            // Jika tabel rooms Anda punya kolom location_id, gunakan:
            $rooms = \Modules\Asset\Models\Room::where('location_id', $selectedLocationId)->get();
            // Atau jika rooms mengambil relasi dari assets, bisa disesuaikan.
        } else {
            $rooms = \Modules\Asset\Models\Room::all();
        }

        // Jika ruangan dipilih, ambil data aset berdasarkan location_id dan room_id
        if ($selectedRoomId) {
            $selectedRoom = \Modules\Asset\Models\Room::with('department')->find($selectedRoomId);
            
            $query = AssetItem::with(['location', 'room']);
            
            if ($selectedLocationId) {
                $query->where('location_id', $selectedLocationId);
            }
            
            $query->where('room_id', $selectedRoomId);
            
            $assets = $query->get();
        }

        return view('asset::reports.room', compact('locations', 'rooms', 'assets', 'selectedRoom', 'selectedLocationId', 'selectedRoomId'));
    }

    // 2. Laporan Keuangan & Penyusutan (Depreciation)
    public function depreciation()
    {
        $assets = AssetItem::all();
        // Contoh perhitungan penyusutan garis lurus sederhana per tahun
        $reportData = $assets->map(function ($item) {
            $purchasePrice = $item->purchase_price ?? 0;
            $usefulLife = $item->useful_life ?? 5; // Estimasi umur ekonomis (tahun)
            $depreciationPerYear = $usefulLife > 0 ? $purchasePrice / $usefulLife : 0;
            
            $item->depreciation_per_year = $depreciationPerYear;
            $item->book_value = max(0, $purchasePrice - ($depreciationPerYear * 2)); // Contoh akumulasi 2 tahun
            return $item;
        });

        return view('asset::reports.depreciation', compact('reportData'));
    }

    // 3. Laporan Perawatan (Maintenance & Repair)
    public function maintenance(Request $request)
    {
        $maintenances = AssetMaintenance::with('asset')->latest()->get();
        $totalCost = $maintenances->sum('cost');

        return view('asset::reports.maintenance', compact('maintenances', 'totalCost'));
    }

    // 4. Laporan Penghapusan Aset (Disposal)
    public function disposal()
    {
        // Aset dengan status rusak total atau dihapus/dijual
        $disposedAssets = AssetItem::whereIn('status', ['Rusak Total', 'Disposed', 'Dihapuskan'])->get();

        return view('asset::reports.disposal', compact('disposedAssets'));
    }
}