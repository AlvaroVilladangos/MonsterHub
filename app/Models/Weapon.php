<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Cazador;
use Illuminate\Support\Str;

class Weapon extends Model
{
    use HasFactory;

    public $timestamps = false;


    public function monster()
    {

        return $this->belongsTo(Monster::class);
    }

    public function hunters()
    {
        return $this->hasMany(Hunter::class);
    }

    public function name()
    {
        return $this->name;
    }

    public function getImageUrlAttribute()
    {

        if (Str::startsWith($this->img, 'img/imgWeapons/default')) {
            return asset($this->img);
        } else {
            return URL('storage/' . $this->img);
        }
    }
}
