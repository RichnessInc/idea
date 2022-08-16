<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;

    protected $table = "cards";

    protected $fillable = [
        'sound',
        'image',
        'slug',
        'text',
        'from',
        'to',
        'client_id',
        'sound_id',
        'background_id',
        'video_id',
    ];

    public function client(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function sound(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(CardsSound::class, 'sound_id');
    }

    public function background(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(CardsBackground::class, 'background_id');
    }

    public function video(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(CardsVideo::class, 'video_id');
    }
}
