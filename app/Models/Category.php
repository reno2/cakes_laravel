<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;


class Category extends Model
{
    protected $fillable = ['sort', 'title', 'slug', 'image', 'parent_id', 'published', 'created_by', 'modifierd_by', 'h1', 'meta_keywords', 'meta_description', 'description'];

    // Mutators
    public function setSlugAttribute($value)
    {

        // Проверка для сидов
        if(!$_REQUEST) return $this->attributes['slug'] = $value;

        if(isset($_REQUEST['slug_change']) && !empty($value)){
            $this->attributes['slug'] = Str::slug($value);
        }else{
            if($_REQUEST)
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
        return $this->morphedByMany('App\Models\Article', 'categoryable');
    }

    public function scopeLastCategories($query, $count)
    {
        return $query->orderBy('created_at', 'desc')->take($count)->get();
    }

    public function attachments(){
        return $this->morphMany(Attachment::class, 'attachable');
    }

}
