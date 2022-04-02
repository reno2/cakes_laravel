<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Tag extends Model
{

    //protected $guarded = [];
    protected $fillable = ['slug', 'title', 'sort', 'slug', 'description', 'image', 'published', 'meta_title'];

    // Mutators
    public function setSlugAttribute($value)
    {

        // Проверка для сидов
        if(!$_REQUEST) return $this->attributes['slug'] = $value;
        if(isset($_REQUEST['slug_change']) && !empty($value)){
            $this->attributes['slug'] = Str::slug($value);
        }else{
            $this->attributes['slug'] = Str::slug($_REQUEST['title']);
        }
    }
    public function articles(){
        return $this->belongsToMany('\App\Models\Article');
    }
    public function attachments(){
            return $this->morphMany(Attachment::class, 'attachable');
    }
}
