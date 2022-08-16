<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $table = "countries";

    protected $fillable = [
        'name',
        'soft_deleted',
    ];

    public function governments() {
        return $this->hasMany(Government::class, 'country_id');
    }

    public function address() {
        return $this->hasMany(Address::class, 'country_id');
    }
    public function clients() {
        return $this->hasMany(Client::class, 'country_id');
    }
}
