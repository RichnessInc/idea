<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $table = "notifications";

    protected $fillable = [
        'content',
        'type',
        'client_id',
        'user_id',
    ];

    public function client() {
        return $this->belongsTo(Client::class, 'client_id');
    }
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
