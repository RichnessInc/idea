<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageBuyer extends Model
{
    use HasFactory;
    protected $table = "package_buyers";

    protected $fillable = [
        'status',
        'client_id',
        'package_id',
        'soft_deleted',
    ];
    public function package() {
        return $this->belongsTo(Package::class, 'package_id');
    }
    public function client() {
        return $this->belongsTo(Client::class, 'client_id');
    }
}
