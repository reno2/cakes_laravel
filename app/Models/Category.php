<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;


class Category extends Model
{
    protected $fillable = ['title', 'slug', 'image', 'parent_id', 'published', 'created_by', 'modifierd_by', 'h1', 'meta_keywords', 'meta_description', 'description'];

    // Mutators
    public function setSlugAttribute($value)
    {

        if(isset($_REQUEST['slug__change']) && !empty($value)){
            $this->attributes['slug'] = Str::slug($value);
        }else{
            $this->attributes['slug'] = Str::slug($_REQUEST['title']);
        }

    }

    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }
    //plymorphe
    public function articles()
    {
        return $this->morphedByMany('App\Article', 'categoryable');
    }

    public function scopeLastCategories($query, $count)
    {
        return $query->orderBy('created_at', 'desc')->take($count)->get();
    }

}
