<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class alertLog extends Model
{
    use HasFactory;

    protected $table = "alert_logs";

    protected $fillable = [
        'type',
        'request_id',
        'client_id',
    ];

    public function client() {
        return $this->belongsTo(Client::class, 'client_id');
    }
    public function request() {
        return $this->belongsTo(ProductRequests::class, 'request_id');
    }
}
