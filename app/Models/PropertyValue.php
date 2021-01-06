<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyValue extends Model
{
    public $timestamps = false;
    protected $fillable = ['value', 'key', 'property_name_id'];

    public function propertyNames() {
        return $this->belongsTo('App\Models\PropertyName', 'property_name_id', 'id');
    }
}
