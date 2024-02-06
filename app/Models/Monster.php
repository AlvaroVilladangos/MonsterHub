<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Monster extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function weapon(){

        return $this->hasOne(Weapon::class);
    }

    public function armor(){

        return $this->hasOne(Armor::class);
    }

    public function rooms(){
        return $this->hasMany(Room::class);
    }


    public static function getIdByName($name)
    {
        $monster = self::where('name', $name)->first();
        return $monster ? $monster->id : null;
    }


    public function getImageUrlAttribute()
    {

        if (Str::startsWith($this->img, 'img/imgMonsters/default')) {
            return asset($this->img);
        } else {
            return URL('storage/' . $this->img);
        }
    }
}
