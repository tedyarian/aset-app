<?php

namespace Modules\Asset\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Department extends Model
{
    use HasFactory;

    // Tambahkan baris ini agar kolom 'name' dan 'description' diizinkan diisi mass-assignment
    protected $fillable = [
        'name',
        'description',
    ];
}