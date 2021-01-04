<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Value;

class Property extends Model
{
    protected $fillable = ['title', 'type', 'require'];
    //protected $guarded =[];

    public function values(){
        return $this->hasMany('App\Models\Value');
    }
}
