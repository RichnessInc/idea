<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reesh extends Model
{
    use HasFactory;

    protected $table = "reesh";

    protected $fillable = [
        'price',
        'image',
        'status',
        'type',
        'receipt_days',
        'soft_deleted',

    ];
}
