<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\Models\Media;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Profile extends Model implements HasMedia
{
    use HasMediaTrait;
    protected $fillable = ['contact2', 'contact1', 'published', 'address', 'filled', 'type', 'image', 'favorites', 'name', 'created_by', 'modifierd_by', 'image', 'address', 'rating', 'user_id', 'filled'];
    //protected $guarded = [];
    /*
     * @var array
     */
    public  $types = [
        'person' => 'Частное лицо',
        'company'=>'Компания'
    ];

    public function user(){
        return $this->hasOne('App\Models\User');
    }

    public function favoritePosts()
    {
        return $this->belongsToMany('App\Models\Article', 'favorites');
    }
    public function media()
    {
        return $this->morphMany(Media::class, 'model');
    }
}
