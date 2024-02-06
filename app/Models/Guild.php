<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guild extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function leader()
    {
        return $this->belongsTo(Hunter::class, 'leader_id');
    }

    public function hunters()
    {
        return $this->hasMany(Hunter::class);
    }


    public function memberCount()
    {
        return $this->hunters()->count();
    }

    public function getImageUrlAttribute()
    {
        if ($this->img == 'imgGuildProfile/defaultGuildProfile.jpg') {
            return asset($this->img);
        } else {
            return URL('storage/' . $this->img);
        }
    }

}
