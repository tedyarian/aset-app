<?php

namespace Modules\Asset\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Asset\Models\AssetItem;
use Modules\Asset\Models\AssetMutation;
use Modules\Asset\Models\AssetLoan;
use Modules\Asset\Models\AssetMaintenance;
use Modules\Asset\Models\Room; // Sesuaikan path model Room jika ada di App\Models atau Modules

class AssetTransactionController extends Controller
{
    public function index()
    {
        $mutations = AssetMutation::with(['asset', 'fromRoom', 'toRoom'])->latest()->take(10)->get();
        $loans = AssetLoan::with('asset')->latest()->take(10)->get();
        $maintenances = AssetMaintenance::with('asset')->latest()->take(10)->get();

        return view('asset::transactions.index', compact('mutations', 'loans', 'maintenances'));
    }

    // --- FORM & STORE MUTASI ---
    public function createMutation()
    {
        $assets = AssetItem::all();
        $rooms = \Modules\Asset\Models\Room::all();
        return view('asset::transactions.mutation_create', compact('assets', 'rooms'));
    }

    public function storeMutation(Request $request)
    {
        $validated = $request->validate([
            'asset_item_id' => 'required|exists:assets,id',
            'to_room_id'    => 'required|exists:rooms,id',
            'to_pic'        => 'nullable|string',
            'mutation_date' => 'required|date',
            'reason'        => 'nullable|string',
        ]);

        $asset = AssetItem::findOrFail($request->asset_item_id);
        
        AssetMutation::create([
            'asset_item_id' => $asset->id,
            'from_room_id'  => $asset->room_id,
            'to_room_id'    => $request->to_room_id,
            'from_pic'      => $asset->pic,
            'to_pic'        => $request->to_pic,
            'mutation_date' => $request->mutation_date,
            'reason'        => $request->reason,
        ]);

        $asset->update([
            'room_id' => $request->to_room_id,
            'pic'     => $request->to_pic,
        ]);

        return redirect()->route('transactions.index')->with('success', 'Mutasi aset berhasil dicatat!');
    }

    // --- FORM & STORE PEMINJAMAN ---
    public function createLoan()
    {
        $assets = AssetItem::where('status', '!=', 'Dipinjam')->get();
        return view('asset::transactions.loan_create', compact('assets'));
    }

    public function storeLoan(Request $request)
    {
        $validated = $request->validate([
            'asset_item_id'    => 'required|exists:assets,id',
            'borrower_name'    => 'required|string',
            'borrower_dept'    => 'nullable|string',
            'loan_date'        => 'required|date',
            'due_date'         => 'required|date',
            'condition_before' => 'required|string',
        ]);

        AssetLoan::create($validated);
        AssetItem::where('id', $request->asset_item_id)->update(['status' => 'Dipinjam']);

        return redirect()->route('transactions.index')->with('success', 'Peminjaman aset berhasil dicatat!');
    }

    // --- FORM & STORE PERAWATAN ---
    public function createMaintenance()
    {
        $assets = AssetItem::all();
        return view('asset::transactions.maintenance_create', compact('assets'));
    }

    public function storeMaintenance(Request $request)
    {
        $validated = $request->validate([
            'asset_item_id'        => 'required|exists:assets,id',
            'maintenance_date'     => 'required|date',
            'maintenance_type'     => 'required|string',
            'cost'                 => 'required|numeric',
            'vendor_or_technician' => 'required|string',
            'description'          => 'required|string',
        ]);

        AssetMaintenance::create($validated);
        AssetItem::where('id', $request->asset_item_id)->update(['status' => 'Dalam Servis']);

        return redirect()->route('transactions.index')->with('success', 'Perawatan aset berhasil dicatat!');
    }
}