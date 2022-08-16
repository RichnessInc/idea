<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $table = "packages";

    protected $fillable = [
        'name',
        'description',
        'price',
        'soft_deleted',
    ];
    public function buyers() {
        return $this->hasMany(PackageBuyer::class, 'package_id');
    }
}
