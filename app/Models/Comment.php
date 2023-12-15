<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;


public function hunter(){
        return $this->belongsTo(Hunter::class, 'from_id');
    }
}


