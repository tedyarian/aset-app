<?php

namespace Modules\Asset\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InstitutionKop extends Model
{
    use HasFactory;

    protected $table = 'institution_kops';
    
    protected $fillable = [
        'logo', 'line_1', 'line_2', 'line_3', 'line_4', 'line_5',
        'font_family', 'size_1', 'size_2', 'size_3', 'size_4', 'size_5'
    ];
}