<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class chatGroup extends Model
{
    use HasFactory;

    protected $table = "chat_groups";

    protected $fillable = [
        'buyer_id',
        'provieder_id',
        'sender_id',
        'request_id',
        'collection_request_id'
    ];



    public function buyer() {
        return $this->belongsTo(Client::class, 'buyer_id');
    }
    public function provieder() {
        return $this->belongsTo(Client::class, 'provieder_id');
    }
    public function sender() {
        return $this->belongsTo(Client::class, 'sender_id');
    }
    public function request() {
        return $this->belongsTo(ProductRequests::class, 'request_id');
    }
    public function collection_request() {
        return $this->belongsTo(productRequestsCollection::class, 'collection_request_id');
    }

    public function messages() {
        return $this->hasMany(Message::class, 'group_id');
    }


}
