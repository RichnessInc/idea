<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class homepageSetting extends Model
{
    use HasFactory;

    protected $table = "homepage_settings";

    protected $fillable = [
        'slider_1',
        'slider_2',
        'slider_3',
        'slider_4',

        'uper_ads',
        'down_ads',
    ];
}
