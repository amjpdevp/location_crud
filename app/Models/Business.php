<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'address',
        'user_id',
    ];

    public function locations(){
        return $this->hasMany(Location::class,'business_id');
    }

    public function User(){
        
        return $this->belongsTo(User::class,'id');
    }
}
