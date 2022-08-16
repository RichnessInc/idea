<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentSetting extends Model
{
    use HasFactory;

    protected $table = "payment_settings";

    protected $fillable = [
        'pro_max_dept',
        'comission',
        'sender_max_dept',
        'cashback_commission',
        'handmade_commission',
        'sender_commission',
        'text',
        'handmade_max_dept',
        'marketing_commission',
        'provider_commission'
    ];
}
