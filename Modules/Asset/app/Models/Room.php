<?php

namespace Modules\Asset\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Room extends Model
{
    use HasFactory;

    protected $table = 'rooms';
    protected $fillable = [
        'name',                
        'sign_tempat',
        'sign_date',
        'pic_jabatan',
        'pic_name',
        'pic_nip',
        'leader_jabatan',
        'leader_name',
        'leader_nip',];
    protected $guarded = ['id'];

    public function department()
    {
        return $this->belongsTo(Department::class, 'departmen_id');
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'location_id');
    }
    
    // Jika ingin tetap menggunakan method location tapi mengambil dari kolom 'building'
    // Atau Anda bisa langsung memanggil $room->building di view.
}