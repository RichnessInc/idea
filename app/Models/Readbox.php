<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Readbox extends Model
{
    use HasFactory;
    protected $table = "readbox";

    protected $fillable = [
        'readbox_cost',
        'dues',

    ];
    public $timestamps = false;
}
