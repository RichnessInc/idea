<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class receiptCollection extends Model
{
    use HasFactory;
    protected $table = "receipt_collections";

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
        'qr_code',
        'reqsIDs',
        'provieder_id',
        'shipping_method_data'
    ];

    public function client() {
        return $this->belongsTo(Client::class, 'client_id');
    }
    public function provieder() {
        return $this->belongsTo(Client::class, 'provieder_id');
    }

    public function paymentmethod() {
        return $this->belongsTo(paymentMethod::class, 'paymentmethod_id');
    }
    public function requests(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(productRequestsCollection::class, 'receipt_id');
    }
}
