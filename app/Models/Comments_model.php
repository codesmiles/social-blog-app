<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Comments_model extends Model
{
    use HasFactory;
    protected $table ="comments";

    protected $fillable = [
        "comment",
        "user_id",
        "post_id"
    ];

    public function post() {
        return $this->belongsTo(Posts_model::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
