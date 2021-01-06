<?php

namespace App\Models;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{


    // Mutators
    public function setSlugAttribute($value)
    {

        if(isset($_REQUEST['slug__change']) && !empty($value)){
            $this->attributes['slug'] = Str::slug($value);
        }else{
            $this->attributes['slug'] = Str::slug($_REQUEST['title']);
        }
    }


    protected $fillable = ['title', 'slug', 'sort', 'up_post', 'description_short', 'description','image','image_show', 'meta_title', 'meta_description', 'viewed' ,'published', 'created_by', 'modifierd_by', 'on_front'];
    //plymorphe
    public function categories(){
        return $this->morphToMany('App\Models\Category', 'categoryable');
    }

    public function scopeLastArticles($query, $count){
        return $query->orderBy('created_at', 'desc')->take($count)->get();
    }

    public function tags(){
        return $this->belongsToMany('\App\Models\Tag');
    }

    //plymorphe
    public function filterGroups(){
        // Первым парметром передаём модель, с которой связь, вторым приставку полей
        return $this->morphToMany('App\Models\PropertyName', 'groupefiltersable');
    }
    //plymorphe
    public function filterValues(){
        return $this->morphToMany('App\Models\PropertyValue', 'valuefiltersable');
    }

    // Связь с картинками
    public function images()
    {
        return $this->hasMany('App\Models\PostImage');
    }
}
