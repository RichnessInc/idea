<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    use HasFactory;

    protected $table = "receipts";

    protected $fillable = [
        'bills_data',
        'total_price',
        'total_shipping',
        'payment_data',
        'client_id',
        'paymentmethod',
        'paymentmethod_id',
        'status',
        'reference_number',
        'sender_commission',
        'cashback_commission',
        'marketing_commission',
        'provider_commission',
        'handmade_commission',
        'qr_code'
    ];

    public function client() {
        return $this->belongsTo(Client::class, 'client_id');
    }
    public function paymentmethod() {
        return $this->belongsTo(paymentMethod::class, 'paymentmethod_id');
    }
}
