<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $guarded = [];

    public function tags(){
        return $this->morphTo();
    }

    public function categories(){
        return $this->morphTo();
    }
}
