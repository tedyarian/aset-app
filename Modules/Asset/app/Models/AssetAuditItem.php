<?php

namespace Modules\Asset\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssetAuditItem extends Model
{
    use HasFactory;

    protected $table = 'asset_audit_items';
    protected $guarded = ['id'];

    public function session()
    {
        return $this->belongsTo(AssetAuditSession::class, 'audit_session_id');
    }

    public function asset()
    {
        return $this->belongsTo(AssetItem::class, 'asset_item_id');
    }
}