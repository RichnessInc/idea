<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class singleRoomMessage extends Model
{
    use HasFactory;

    protected $table = "single_room_messages";

    protected $fillable = ['client_id','room_id','admin_id','message','file','readed', 'from'];

    public function client() {
        return $this->belongsTo(Client::class, 'client_id');
    }
    public function room() {
        return $this->belongsTo(singleRoom::class, 'room_id');
    }
    public function user() {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
