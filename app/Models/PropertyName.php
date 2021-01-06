<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyName extends Model
{
    public $timestamps = false;
    protected $fillable = ['title', 'type', 'require'];

    //protected $guarded =[];

    public function propertyValues()
    {
        return $this->hasMany('App\Models\PropertyValue');
    }
}
