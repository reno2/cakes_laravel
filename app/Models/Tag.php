<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Tag extends Model
{
    //protected $guarded = [];
    protected $fillable = ['slug', 'name', 'description', 'image', 'published', 'meta_title'];
    // Mutators
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        if(isset($_REQUEST['slug__change']) && !empty($value)){
            $this->attributes['slug'] = Str::slug($value);
        }else{
            $this->attributes['slug'] = Str::slug($_REQUEST['name']);
        }
    }
    public function articles(){
        return $this->belongsToMany('\App\Models\Article');
    }
}
