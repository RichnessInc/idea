<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GiftTicket extends Model
{
    use HasFactory;

    protected $table = "gift_tickets";

    protected $fillable = [
        'value',
        'paid',
        'password',
        'client_id',
        'status',
        'reference_number',
        'used_by',
        'soft_deleted',

    ];

    public function client() {
        return $this->belongsTo(Client::class, 'client_id');
    }
}
