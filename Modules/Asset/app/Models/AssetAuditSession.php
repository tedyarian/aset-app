<?php

namespace Modules\Asset\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssetAuditSession extends Model
{
    use HasFactory;

    protected $table = 'asset_audit_sessions';
    protected $guarded = ['id'];

    public function auditItems()
    {
        return $this->hasMany(AssetAuditItem::class, 'audit_session_id');
    }
}