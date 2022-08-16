<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $table = "messages";

    protected $fillable = [
        'message',
        'file',
        'type',
        'client_id',
        'user_id',
        'user_readed',
        'buyer_readed',
        'providers_readed',
        'sender_readed',
        'group_id'
    ];



    public function client() {
        return $this->belongsTo(Client::class, 'client_id');
    }
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function group() {
        return $this->belongsTo(chatGroup::class, 'group_id');
    }
}
