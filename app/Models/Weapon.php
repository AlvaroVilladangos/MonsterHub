<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Cazador;

class Weapon extends Model
{
    use HasFactory;

    public function monster() {

        return $this->belongsTo(Monster::class);
    }

    public function hunters(){
        return $this->hasMany(Hunter::class);
    }
}
