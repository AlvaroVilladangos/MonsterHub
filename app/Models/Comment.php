<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function hunter()
    {
        return $this->belongsTo(Hunter::class, 'from_id');
    }


    public function receiver()
    {
        return $this->belongsTo(Hunter::class, 'to_id');
    }
}
