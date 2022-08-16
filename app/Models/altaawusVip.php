<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class altaawusVip extends Model
{
    use HasFactory;

    protected $table = "altaawus_vip";

    protected $fillable = [
        'text',
    ];
}
