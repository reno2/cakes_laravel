<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Property;
class Value extends Model
{
    protected $guarded =[];

    public function property() {
        return $this->belongsTo('App\Property', 'property_id', 'id');
    }
}
