<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ads extends Model
{
    use HasFactory;

    protected $table = "ads";

    protected $fillable = [
        'script',
        'image',
        'link',

        'script2',
        'image2',
        'link2',
        
        'script3',
        'image3',
        'link3',
        
        'status',
    ];
}
