<?php

namespace Modules\Asset\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Asset\Models\Room;

class AssetMutation extends Model
{
    use HasFactory;

    protected $table = 'asset_mutations';
    protected $guarded = ['id'];

    public function asset()
    {
        return $this->belongsTo(AssetItem::class, 'asset_item_id');
    }

    public function fromRoom()
    {
        return $this->belongsTo(\Modules\Asset\Models\Room::class, 'from_room_id');
    }

    public function toRoom()
    {
        return $this->belongsTo(\Modules\Asset\Models\Room::class, 'to_room_id');
    }
}