<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $table = "chat";

    protected $fillable = [
        'send_from_client',
        'send_from_admin',
        'message',
        'readed',
        'room_id',
    ];
    public function client() {
        return $this->belongsTo(Client::class, 'send_from_client');
    }
    public function user() {
        return $this->belongsTo(User::class, 'send_from_admin');
    }
    public function room() {
        return $this->belongsTo(Room::class, 'room_id');
    }
}
