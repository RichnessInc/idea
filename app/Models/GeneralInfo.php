<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralInfo extends Model
{
    use HasFactory;

    protected $table = "general_info";

    protected $fillable = [
        'facebook',
        'instgram',
        'twitter',
        'snapchat',
        'whatsapp',
        'telgram',
        'currency',
        'tel_fax',
        'hot_line',
        'email',
        'address',
        'senders_status',
        'profits_section_password'
    ];
}
