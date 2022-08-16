<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class singleRoom extends Model
{
    use HasFactory;

    protected $table = "single_rooms";

    protected $fillable = ['client_id'];

    public function client() {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function messages() {
        return $this->hasMany(singleRoomMessage::class, 'room_id');
    }
    
}
