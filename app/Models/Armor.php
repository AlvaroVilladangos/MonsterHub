<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Armor extends Model
{
    use HasFactory;

    public $timestamps = false;


    public function monster() {

        return $this->belongsTo(Monster::class);
    }

    public function hunters(){
        return $this->hasMany(Hunter::class);
    }

    public function getImageUrlAttribute()
    {
        if (Str::startsWith($this->img, 'img/imgArmors/default')) {
            return asset($this->img);
        } else {
            return URL('storage/' . $this->img);
        }
    }
}
