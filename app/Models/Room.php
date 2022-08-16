<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $table = "rooms";

    protected $fillable = [
        'buyer_id',
        'provieder_id',
        'sender_id',
        'request_id',
        'status',
        'admin_id',
        'collection_request_id'
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
    public function user() {
        return $this->belongsTo(User::class, 'admin_id');
    }
    public function request() {
        return $this->belongsTo(ProductRequests::class, 'request_id');
    }
    public function messages() {
        return $this->hasMany(Chat::class, 'room_id');
    }
}
