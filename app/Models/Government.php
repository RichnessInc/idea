<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Government extends Model
{
    use HasFactory;

    protected $table = "governments";

    protected $fillable = [
        'name', 'country_id',
        'soft_deleted',
    ];

    public function country() {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function address() {
        return $this->hasMany(Address::class, 'government_id');
    }
    public function clients() {
        return $this->hasMany(Client::class, 'government_id');
    }
}
