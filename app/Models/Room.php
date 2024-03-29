<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
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


    public function roomCount()
    {
        return $this->hunters()->count();
    }
}
