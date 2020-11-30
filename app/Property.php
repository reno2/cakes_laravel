<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Value;

class Property extends Model
{
    protected $fillable = ['title', 'type', 'require'];
    //protected $guarded =[];

    public function values(){
        return $this->hasMany('App\Value');
    }
}
