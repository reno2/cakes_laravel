<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feature_values extends Model
{
    protected $table = 'feature_values';
    protected $guarded = [];
    public function featureTypes(){
        return $this->belongsToMany('App\Feature_types', 'feature_types_feature_values', 'feature_types_id', 'feature_values_id');
    }
}
