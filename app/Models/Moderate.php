<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Moderate extends Model
{
    //protected $table = "moderate";
    protected $guarded = [];
    public static $rulesTo = [
        1,2,5,7,8
    ];
    //plimorphe
    public function moderateArticle(){
        // Первым параметром передаём модель, с которой связь, вторым приставку полей
        return $this->morphToMany('App\Models\Article', 'moderatesable');
    }

    public function settings(){
        return $this->belongsToMany(
            Settings::class,
            'moderate_settings',
            'moderate_id',
            'settings_id'
        );
    }

}
