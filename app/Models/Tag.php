<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Tag extends Model
{
    protected $guarded = [];
    // Mutators
    public function setSlugAttribute($value)
    {
        $ett = '';
        if(isset($_REQUEST['slug__change']) && !empty($value)){
            $this->attributes['slug'] = Str::slug($value);
        }else{
            $this->attributes['slug'] = Str::slug($_REQUEST['name']);
        }
        $tt = '';

    }
    public function articles(){
        return $this->belongsToMany('\App\Models\Article');
    }
}
