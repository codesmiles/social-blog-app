<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Posts_model extends Model
{
    use HasFactory;

    protected $table = "posts";
    protected $fillable = [
        'user_id',
        'title',
        'details',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // JUST IN CASE I WANT TO RUN THE COMMENT ENDPOINT
    // public function comments()
    // {
    //     return $this->hasMany(Comments_model::class);
    // }

    
}
