<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pointsCommissionRequest extends Model
{
    use HasFactory;

    protected $table = "points_commissions_requests";
    protected $fillable = ['type_id','status','client_id' ,'soft_deleted',];

    public function type() {
        return $this->belongsTo(pointsCommission::class, 'type_id');
    }
    public function client() {
        return $this->belongsTo(Client::class, 'client_id');
    }
}
