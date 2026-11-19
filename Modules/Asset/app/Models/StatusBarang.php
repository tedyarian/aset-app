<?php

namespace Modules\Asset\Models;

use Illuminate\Database\Eloquent\Model;

class StatusBarang extends Model
{
    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'status_barang'; // <-- Tambahkan baris ini

    protected $fillable = ['kondisi', 'keterangan'];
}
