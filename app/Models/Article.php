<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\File;
use Illuminate\Database\Eloquent\SoftDeletes;


use CyrildeWit\EloquentViewable\InteractsWithViews;
use CyrildeWit\EloquentViewable\Contracts\Viewable;

class Article extends Model implements HasMedia, Viewable
{
    use HasMediaTrait, Notifiable, InteractsWithViews;



    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        if (isset($_REQUEST['slug__change']) && !empty($value)) {
            $this->attributes['slug'] = Str::slug($value);
        } else {
            $this->attributes['slug'] = Str::slug($_REQUEST['title']);
        }

    }

    protected $fillable = [
        'title',
        'slug',
        'sort',
        'up_post',
        'description_short',
        'description',
        'image',
        'image_show',
        'meta_title',
        'meta_description',
        'moderate',
        'published',
        'created_by',
        'modifierd_by',
        'on_front',
        'service',
        'product_type',
        'price',
        'weight',
        'deal_address',
        'delivery_self',
        'user_id'
    ];

    //plymorphe
    public function categories()
    {
        return $this->morphToMany('App\Models\Category', 'categoryable');
    }

    public function scopeLastArticles($query, $count)
    {
        return $query->orderBy('created_at', 'desc')->take($count)->get();
    }

    public function tags()
    {
        return $this->belongsToMany('\App\Models\Tag');
    }

    //plymorphe
    public function filterGroups()
    {
        // Первым парметром передаём модель, с которой связь, вторым приставку полей
        return $this->morphToMany('App\Models\PropertyName', 'propertyable');
    }

    //plymorphe
    public function filterValues()
    {
        return $this->morphToMany('App\Models\PropertyValue', 'propertyvalueable');
    }

    // Связь с картинками
    public function images()
    {
        return $this->hasMany('App\Models\PostImage');
    }

    // Связь с пользователем
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    /**
     * Get all of the user's images.
     */
    public function media()
    {
        return $this->morphMany(Media::class, 'model');
    }
    public function registerMediaCollections()
    {
        $this
            ->addMediaCollection('cover')
            ->registerMediaConversions(function (Media $media) {
                $this
                    ->addMediaConversion('thumb')
                    ->fit('fill', 265, 265);
            });
        $this
            ->addMediaCollection('cover')
            ->registerMediaConversions(function (Media $media) {
                $this
                    ->addMediaConversion('detail')
                    ->fit('fill', 677, 520);
            });
    }

    public function favoritesProfiles()
    {
        return $this->belongsToMany('App\Models\Profile', 'favorites');
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    //plimorphe
    public function moderateComments(){
        // Первым параметром передаём модель, с которой связь, вторым приставку полей
        return $this->morphToMany('App\Models\Moderate', 'moderatesable');
    }
}
