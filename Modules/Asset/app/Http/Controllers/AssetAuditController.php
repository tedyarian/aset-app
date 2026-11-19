<?php

namespace Modules\Asset\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Asset\Models\AssetItem;
use Modules\Asset\Models\AssetAuditSession;
use Modules\Asset\Models\AssetAuditItem;

class AssetAuditController extends Controller
{
    public function index()
    {
        $sessions = AssetAuditSession::latest()->get();
        return view('asset::audits.index', compact('sessions'));
    }

    public function createSession()
    {
        return view('asset::audits.create_session');
    }

    public function storeSession(Request $request)
    {
        $validated = $request->validate([
            'session_name' => 'required|string|max:255',
            'start_date'   => 'required|date',
            'end_date'     => 'required|date|after_or_equal:start_date',
            'notes'        => 'nullable|string',
        ]);

        $session = AssetAuditSession::create($validated);

        // Inisialisasi seluruh aset ke sesi audit dengan status awal (opsional)
        $assets = AssetItem::all();
        foreach ($assets as $asset) {
            AssetAuditItem::create([
                'audit_session_id' => $session->id,
                'asset_item_id'    => $asset->id,
                'audit_status'     => 'Hilang', // Default dianggap belum ketemu sebelum di-scan
            ]);
        }

        return redirect()->route('audits.index')->with('success', 'Sesi stock opname berhasil dibuat!');
    }

    public function scanPage($id)
    {
        $session = AssetAuditSession::findOrFail($id);
        $scannedItems = AssetAuditItem::with('asset')->where('audit_session_id', $id)->latest()->get();
        
        return view('asset::audits.scan', compact('session', 'scannedItems'));
    }

    public function processScan(Request $request, $id)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        $asset = AssetItem::where('code', $request->code)->first();

        if (!$asset) {
            return back()->with('error', 'Kode BMN / Barcode tidak ditemukan di sistem!');
        }

        $auditItem = AssetAuditItem::where('audit_session_id', $id)
            ->where('asset_item_id', $asset->id)
            ->first();

        if ($auditItem) {
            $auditItem->update([
                'audit_status' => 'Ditemukan',
                'scanned_at'   => now(),
                'scanned_by'   => auth()->user()->name ?? 'Administrator',
            ]);
        }

        return back()->with('success', "Aset {$asset->code} - {$asset->name} berhasil tercatat ditemukan!");
    }

    public function discrepancyReport($id)
    {
        $session = AssetAuditSession::findOrFail($id);
        // Aset yang belum ditemukan (status masih 'Hilang')
        $discrepancies = AssetAuditItem::with('asset')
            ->where('audit_session_id', $id)
            ->where('audit_status', 'Hilang')
            ->get();

        return view('asset::audits.report', compact('session', 'discrepancies'));
    }
}