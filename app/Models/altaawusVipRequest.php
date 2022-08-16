<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class altaawusVipRequest extends Model
{
    use HasFactory;

    protected $table = "altaawus_vip_requests";

    protected $fillable = [
        'country_id',
        'government_id',
        'street',
        'build_no',
        'sector',
        'floor',
        'unit_no',
        'details',
        'client_id',
        'shipping_method_id',
        'email',
        'whatsapp_phone',
        'status',
        'soft_deleted',
    ];



    public function shipping_method() {
        return $this->belongsTo(ShippingMethod::class, 'shipping_method_id');
    }

    public function country() {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function government() {
        return $this->belongsTo(Government::class, 'government_id');
    }

    public function client() {
        return $this->belongsTo(Client::class, 'client_id');
    }
}
