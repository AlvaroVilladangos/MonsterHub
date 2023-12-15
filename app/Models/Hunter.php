<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;


class Hunter extends Model
{
    use HasFactory;

    public function user() {

        return $this->belongsTo(User::class);
    }

    public function isLeader()
    {
        return $this->guild && $this->guild->leader_id == $this->id;
    }

    public function isInAGuild(){

        return $this->belongsTo(Guild::class);
    }

    public function weapon(){

        return $this->hasOne(Weapon::class);
    }

    public function armor(){

        return $this->hasOne(Armor::class);
    }

    public function room(){
        return $this->hasOne(Room::class);
    }

    public function friends(){
        return $this->belongsToMany(Hunter::class, 'friends', 'hunter_id1', 'friend_id');
    }

    public function comments(){
        return $this->hasMany(Comment::class, 'to_id',);
    }

}
