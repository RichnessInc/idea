<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class billsCollection extends Model
{
    use HasFactory;
    protected $table = "bills_collections";

    protected $fillable = [
        'item_data',
        'item_price',
        'shipping',
        'total_price',
        'client_id',
        'status',
        'reference_number',
        'shipping_data',
        'product_id',
        'product_request_id',
        'address_id',
        'shipping_method_data',
        'soft_deleted',
    ];


    public function product() {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function product_request() {
        return $this->belongsTo(productRequestsCollection::class, 'product_request_id');
    }

    public function client() {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function address() {
        return $this->belongsTo(Address::class, 'address_id');
    }
}
