<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductsCategory extends Model
{
    use HasFactory;

    protected $table = "product_categories";

    protected $fillable = [
        'soft_deleted',
        'name'
    ];

    public function products() {
        return $this->hasMany(Product::class, 'category_id');
    }
}
