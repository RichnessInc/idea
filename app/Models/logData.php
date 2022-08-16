<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class logData extends Model
{
    use HasFactory;

    protected $table = "log_data";

    protected $fillable = [
        'registered',
        'data',
        'client_id',
        'user_id',
        'oldData',
        'ip',
        'agent',
    ];

    public function client() {
        return $this->belongsTo(Client::class, 'client_id');
    }
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
