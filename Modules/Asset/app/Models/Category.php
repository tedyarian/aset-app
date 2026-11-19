<?php

namespace Modules\Asset\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories'; // Sesuaikan nama tabel kategori Anda
    protected $guarded = ['id'];
}