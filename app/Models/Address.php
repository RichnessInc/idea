<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $table = "address";

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
        'status',
        'gps',
        'branch'
    ];



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
