<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Nodes extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'sort',
        'description',
        'meta_title',
        'meta_description',
        'published',
        'created_by',
        'modifierd_by',
        'user_id'
    ];
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        if (isset($_REQUEST['slug__change']) && !empty($value)) {
            $this->attributes['slug'] = Str::slug($value);
        } else {
            $this->attributes['slug'] = Str::slug($_REQUEST['title']);
        }

    }

    public function settings(){
        return $this->hasMany('App\Models\Settings');
    }
}
