<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Support\Facades\DB;


class Hunter extends Model
{
    use HasFactory;

    public function user()
    {

        return $this->belongsTo(User::class);
    }

    public function isLeader($guild)
    {
        return $this->id == $guild->leader_id;
    }


    public function guild()
    {

        return $this->belongsTo(Guild::class);
    }

    public function weapon()
    {

        return $this->belongsTo(Weapon::class);
    }

    public function armor()
    {

        return $this->belongsTo(Armor::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }


    public function isInRelation($id)
    {
        $currentUserId = $this->id;


        $relationExists = DB::table('friends')
            ->where(function ($query) use ($currentUserId, $id) {
                $query->where('hunter_1', $currentUserId)
                    ->where('hunter_2', $id);
            })
            ->orWhere(function ($query) use ($currentUserId, $id) {
                $query->where('hunter_2', $currentUserId)
                    ->where('hunter_1', $id);
            })
            ->exists();

        return $relationExists;
    }


    public function friendsOfThisUser()
    {
        return $this->belongsToMany(Hunter::class, 'friends', 'hunter_1', 'hunter_2')
            ->withPivot('status', 'requester_id')
            ->wherePivot('status', 'accepted');
    }

    public function thisUserIsFriendOf()
    {
        return $this->belongsToMany(Hunter::class, 'friends', 'hunter_2', 'hunter_1')
            ->withPivot('status', 'requester_id')
            ->wherePivot('status', 'accepted');
    }

    public function sentComments()
    {
        return $this->hasMany(Comment::class, 'from_id');
    }
    
    public function comments()
    {
        return $this->hasMany(Comment::class, 'to_id',);
    }


    public function hasPendingRequest()
    {
        $currentUserId = $this->id;
    
        $hasPendingRequest = DB::table('friends')
            ->where(function ($query) use ($currentUserId) {
                $query->where('hunter_1', $currentUserId)
                      ->orWhere('hunter_2', $currentUserId);
            })
            ->where('status', 'pending')
            ->where('requester_id', '!=', $currentUserId)
            ->exists();
    
        return $hasPendingRequest;
    }
    
    
}
