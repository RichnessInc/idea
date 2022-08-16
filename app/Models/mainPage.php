<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mainPage extends Model
{
    use HasFactory;

    protected $table = "main_pages";

    protected $fillable = [
        'name', 'slug', 'content'
    ];
}
