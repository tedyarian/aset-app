<?php

namespace Modules\Asset\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $table = 'locations';
    protected $guarded = ['id'];

    public function rooms()
    {
        return $this->hasMany(Room::class, 'location_id');
    }
}