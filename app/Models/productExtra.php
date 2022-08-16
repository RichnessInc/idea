<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class productExtra extends Model
{
    use HasFactory;

    protected $table = "product_extras";

    protected $fillable = [
        'name',
        'price',
        'main_image',
        'product_id',
        'soft_deleted',
    ];

    public function product() {
        return $this->belongsTo(Product::class, 'product_id');
    }

}
