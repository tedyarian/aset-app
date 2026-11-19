<?php

namespace Modules\Asset\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssetHistory extends Model
{
    use HasFactory;

    protected $table = 'asset_histories';
    protected $guarded = [];

    public function asset()
    {
        return $this->belongsTo(AssetItem::class, 'asset_id');
    }
}