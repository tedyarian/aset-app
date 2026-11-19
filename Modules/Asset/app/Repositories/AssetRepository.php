<?php

namespace Modules\Asset\Repositories;

use Modules\Asset\Models\Asset;

class AssetRepository implements AssetRepositoryInterface
{
    public function getAll()
    {
        return Asset::latest()->paginate(10);
    }

    public function getMetrics()
    {
        return [
        'total_assets' => Asset::sum('quantity'), // Menghitung total jumlah seluruh item aset
        'active' => Asset::where('status', 'Baik')->count(),
        'maintenance' => Asset::where('status', 'Dalam Servis')->count(),
        'disposed' => Asset::where('status', 'Rusak Ringan')->count(),
        ];
    }

    public function create(array $data)
    {
        return Asset::create($data);
    }
}