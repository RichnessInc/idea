<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Client extends Authenticatable
{
    use HasFactory;


    protected $table = "clients";

    protected $fillable = [
        'email',
        'password',
        'country_id',
        'government_id',
        'name',
        'whatsapp_phone',
        'files',
        'type',
        'wallet',
        'points',
        'address_id',
        'debt',
        'shift_from',
        'serv_aval_in',
        'shift_to',
        'ref',
        'parent_ref',
        'spasial_com',
        'spare_phone',
        'email_verified_at',
        'status',
        'verify_email_token',
        'verified',
        'soft_deleted',
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function country() {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function government() {
        return $this->belongsTo(Government::class, 'government_id');
    }
    public function address() {
        return $this->hasMany(Address::class, 'client_id');
    }
    public function buyingRequests() {
        return $this->hasMany(ProductRequests::class, 'buyer_id');
    }
    public function providingRequests() {
        return $this->hasMany(ProductRequests::class, 'provieder_id');
    }
    public function sendingRequests() {
        return $this->hasMany(ProductRequests::class, 'sender_id');
    }

    public function buyingRooms() {
        return $this->hasMany(Room::class, 'buyer_id');
    }
    public function providingRooms() {
        return $this->hasMany(Room::class, 'provieder_id');
    }
    public function sendingRooms() {
        return $this->hasMany(Room::class, 'sender_id');
    }
    public function messages() {
        return $this->hasMany(Chat::class, 'send_from_client');
    }
    public function notifications() {
        return $this->hasMany(Notification::class, 'client_id');
    }
    public function logs() {
        return $this->hasMany(logData::class, 'client_id');
    }
    public function gift_tickets() {
        return $this->hasMany(GiftTicket::class, 'client_id');
    }

    public function bills() {
        return $this->hasMany(Bill::class, 'client_id');
    }

    public function singleRoom() {
        return $this->hasOne(singleRoom::class, 'client_id');
    }

    public function singleRoomMessage() {
        return $this->hasOne(singleRoomMessage::class, 'client_id');
    }

    public function favourites() {
        return $this->hasMany(Favourite::class, 'client_id');
    }

    public function products() {
        return $this->hasMany(Product::class, 'client_id');
    }

    public function testimonial() {
        return $this->hasOne(Product::class, 'client_id');
    }
    public function requests() {
        return $this->hasMany(Client::class, 'client_id');
    }

    public function cards(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Card::class, 'client_id');
    }
}
