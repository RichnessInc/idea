<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pointsCommission extends Model
{
    use HasFactory;

    protected $table = "points_commissions";
    protected $fillable = ['name','points','type','soft_deleted',];
    public function requests() {
        return $this->hasMany(pointsCommissionRequest::class, 'type_id');
    }
}
