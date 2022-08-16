<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favourite extends Model
{
    use HasFactory;

    protected $table = "favourites";

    protected $fillable = [
        'product_id',
        'client_id',
        'soft_deleted',
    ];

    public function product() {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function client() {
        return $this->belongsTo(Client::class, 'client_id');
    }
}
