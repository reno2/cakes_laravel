<?php

namespace App\Models;

use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;


class Room extends Model
{
    protected $guarded = [];

    public function comments() {
       return $this->hasMany(Comment::class, 'room');
    }

    public function ads() {
       return $this->belongsTo(Article::class, 'article_id');
    }

    public function adsOwner() {
       return $this->belongsTo(User::class, 'owner_id');
    }
    public function adsAsked() {
       return $this->belongsTo(User::class, 'asked_id');
    }

}
