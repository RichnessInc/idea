<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CardsBackground extends Model
{
    use HasFactory;

    protected $table = "cards_backgrounds";

    protected $fillable = [
        'background_name',

    ];

    public function cards(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Card::class, 'background_id');
    }
}
