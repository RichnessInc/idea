<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class paymentMethod extends Model
{
    use HasFactory;


    protected $table = "payment_methods";

    protected $fillable = [
        'name',
        'status',
    ];
    
    public function receipts() {
        return $this->hasMany(Receipt::class, 'paymentmethod_id');
    }
    
}
