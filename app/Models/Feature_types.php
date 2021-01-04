<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feature_types extends Model
{
    protected $table = 'feature_types';
    protected $guarded = [];
    public function featureValues(){
        return $this->belongsToMany('App\Models\Feature_values', 'feature_types_feature_values', 'feature_types_id', 'feature_values_id');
    }
}
