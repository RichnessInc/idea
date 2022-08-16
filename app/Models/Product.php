<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = "products";

    protected $fillable = [
        'name',
        'category_id',
        'desc',
        'wight',
        'width',
        'height',
        'price',
        'aval_count',
        'main_image',
        'images',
        'tags',
        'status',
        'receipt_days',
        'client_id',
        'slug',
        'branches',
        'soft_deleted',
    ];

    public function category() {
        return $this->belongsTo(ProductsCategory::class, 'category_id');
    }

    public function requests() {
        return $this->hasMany(ProductRequests::class, 'product_id');
    }

    public function favourites() {
        return $this->hasMany(Favourite::class, 'product_id');
    }

    public function client() {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function extras() {
        return $this->hasMany(productExtra::class, 'product_id');
    }

}
