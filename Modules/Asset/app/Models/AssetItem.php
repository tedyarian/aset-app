<?php

namespace Modules\Asset\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AssetItem extends Model
{
    use HasFactory;

    protected $table = 'assets';

    protected $guarded = [];

    public function department()
    {
        return $this->belongsTo(\Modules\Asset\Models\Department::class, 'department_id');
    }

    public function location()
    {
        return $this->belongsTo(\Modules\Asset\Models\Location::class, 'location_id');
    }

    public function room()
    {
        return $this->belongsTo(\Modules\Asset\Models\Room::class, 'room_id');
    }

    public function histories()
    {
        return $this->hasMany(AssetHistory::class, 'asset_id');
    }
    
}