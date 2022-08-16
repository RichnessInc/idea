<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class productRequestsCollection extends Model
{
    use HasFactory;
    protected $table = "product_requests_collections";

    protected $fillable = [
        'buyer_id',
        'provieder_id',
        'sender_id',
        'product_id',
        'status',
        'receipt_time',
        'payment_status',
        'payment_method_id',
        'senderStatus',
        'shipping_method_id',
        'government_id',
        'branch_id',
        'qr_code',
        'branch_data_id',
        'soft_deleted',
        'receipt_id'

    ];

    public function product() {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function buyer() {
        return $this->belongsTo(Client::class, 'buyer_id');
    }
    public function provider() {
        return $this->belongsTo(Client::class, 'provieder_id');
    }
    public function sender() {
        return $this->belongsTo(Client::class, 'sender_id');
    }

    public function rooms() {
        return $this->hasMany(Room::class, 'collection_request_id');
    }
    public function bill() {
        return $this->hasOne(billsCollection::class, 'product_request_id');
    }

    public function shipping_method() {
        return $this->belongsTo(ShippingMethod::class, 'shipping_method_id');
    }

    public function payment_method() {
        return $this->belongsTo(paymentMethod::class, 'payment_method_id');
    }

    public function group() {
        return $this->hasOne(chatGroup::class, 'collection_request_id');
    }
    public function receipt() {
        return $this->belongsTo(receiptCollection::class, 'receipt_id');
    }
}
