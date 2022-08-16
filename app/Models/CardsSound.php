<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CardsSound extends Model
{
    use HasFactory;

    protected $table = "cards_sounds";

    protected $fillable = [
        'sound_name',
        'name'

    ];

    public function cards(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Card::class, 'sound_id');
    }
}
