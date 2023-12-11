<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Monster extends Model
{
    use HasFactory;


    public function weapon(){

        return $this->hasOne(Weapon::class);
    }

    public function armor(){

        return $this->hasOne(Armor::class);
    }

    public function rooms(){
        return $this->hasMany(Room::class);
    }
}
