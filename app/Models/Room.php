<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;


    public function monster(){
        return $this->hasOne(Monster::class);
    }

    public function hunters(){
        return $this->hasMany(Hunter::class);
    }
}
