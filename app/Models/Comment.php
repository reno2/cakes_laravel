<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $guarded = [];

    public function users(){
        return $this->belongsTo("App\Models\User", 'user_id', 'id');
    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function articles(){
        return $this->belongsTo(Article::class, 'article_id', 'id');
    }

}
