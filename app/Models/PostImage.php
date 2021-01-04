<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostImage extends Model
{
    public function article()
    {
        return $this->belongsTo('App\Article');
    }
}
