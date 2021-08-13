<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'title', 'type', 'value', 'number'
    ];

    public static $types = [
        'moderate_rules' => 'Правила размещения',
        'regist_rules' => 'Правила регистрации',
        'other' => 'Остальные',
        'settings' => 'Настройки',

    ];
    public function nodes(){
        return $this->morphToMany('App\Models\Nodes', 'moderatesable');
    }

    public function moderates()
    {
        return $this->belongsToMany(
            Moderate::class,
            'moderate_settings',
            'settings_id',
            'moderate_id'
        );
    }
}
