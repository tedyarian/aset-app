<?php

namespace Modules\Asset\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssetLoan extends Model
{
    use HasFactory;

    protected $table = 'asset_loans';
    protected $guarded = ['id'];

    public function asset()
    {
        return $this->belongsTo(AssetItem::class, 'asset_item_id');
    }
}