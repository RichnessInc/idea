<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingMethod extends Model
{
    use HasFactory;

    protected $table = "shipping_methods";

    protected $fillable = [
        'name',
        'status',
        'price',
        'premium',
        'soft_deleted',
    ];

    /**
     * Get all of the comments for the ShippingMethod
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function vip_requests()
    {
        return $this->hasMany(altaawusVipRequest::class, 'shipping_method_id');
    }

    public function product_requests() {
        return $this->hasMany(ProductRequests::class, 'shipping_method_id');
    }
}
