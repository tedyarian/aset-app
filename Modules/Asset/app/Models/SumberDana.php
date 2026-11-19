<?php

namespace Modules\Asset\Models;

use Illuminate\Database\Eloquent\Model;

class SumberDana extends Model
{
    /**
     * The attributes that are mass assignable.
     */
    protected $table = 'sumber_dana'; // <-- Tambahkan baris ini

    protected $fillable = ['nama_sumber_dana', 'keterangan'];
}
