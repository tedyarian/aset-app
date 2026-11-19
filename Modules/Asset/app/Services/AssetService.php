<?php

namespace Modules\Asset\Services;

use Modules\Asset\Repositories\AssetRepositoryInterface;
use Modules\Asset\Models\AssetItem;

class AssetService
{
    protected $assetRepository;

    public function __construct(AssetRepositoryInterface $assetRepository)
    {
        $this->assetRepository = $assetRepository;
    }

    public function getDashboardData()
    {
        $totalAssets = AssetItem::count();
        
        $recentAssets = AssetItem::with(['department', 'location', 'room'])
                ->latest()
                ->take(5)
                ->get();

        $metrics = [
            'total'        => $totalAssets,
            'total_assets' => $totalAssets,
            'active'       => AssetItem::where('status', 'Baik')->count(),
            // Mendukung status 'Dalam Servis' maupun 'Perbaikan'
            'repair'       => AssetItem::whereIn('status', ['Dalam Servis', 'Perbaikan'])->count(),
            'maintenance'  => AssetItem::whereIn('status', ['Dalam Servis', 'Perbaikan'])->count(),
        ];

        return [
            'total_assets' => $totalAssets,
            'totalAssets'  => $totalAssets,
            'recentAssets' => $recentAssets,
            'assets'       => $recentAssets,
            'metrics'      => $metrics,
        ];
    }

    public function storeAsset(array $data)
    {
        return $this->assetRepository->create($data);
    }

    public function updateAsset($id, array $data)
    {
        $asset = AssetItem::findOrFail($id);
        
        $original = $asset->getAttributes();
        $changesDescription = [];

        $reason = $data['reason'] ?? null;
        unset($data['reason']); // Hapus reason agar tidak masuk ke tabel assets

        // Daftar kolom yang ingin dipantau perubahannya
        $monitoredColumns = ['name', 'brand', 'status', 'department_id', 'location_id', 'room_id'];

        foreach ($monitoredColumns as $key) {
            if (isset($data[$key]) && isset($original[$key]) && $original[$key] != $data[$key]) {
                $changesDescription[] = "{$key}: '{$original[$key]}' menjadi '{$data[$key]}'";
            }
        }

        // Jika tidak ada kolom spesifik yang masuk daftar pantau tapi ada input lain yang berubah
        if (empty($changesDescription)) {
            foreach ($data as $key => $value) {
                if (isset($original[$key]) && $original[$key] != $value) {
                    $changesDescription[] = "{$key} diubah";
                }
            }
        }

        // Update data aset
        $asset->update($data);

        // Paksa simpan ke riwayat jika alasan diisi (meskipun teks ringkasan manual)
        if (!empty($reason)) {
            \Modules\Asset\Models\AssetHistory::create([
                'asset_id' => $asset->id,
                'changed_by' => auth()->user()->name ?? 'System',
                'changes_summary' => !empty($changesDescription) ? implode(', ', $changesDescription) : 'Pembaruan data atribut aset',
                'reason' => $reason,
            ]);
        }

        return $asset;
    }
}