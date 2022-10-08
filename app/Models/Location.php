<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'address',
        'user_id',
        'business_id',
    ];

    public function business(){
        return $this->belongsTo(Business::class);
    }
}
