<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Property;
class Value extends Model
{
    protected $guarded =[];

    public function property() {
        return $this->belongsTo('App\Models\Property', 'property_id', 'id');
    }
}
