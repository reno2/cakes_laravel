<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
   // protected $fillable = ['published', 'type', 'image', 'favorites', 'name', 'created_by', 'modifierd_by', 'image', 'address', 'rating', 'user_id'];
    protected $guarded = [];
    /*
     * @var array
     */
    public  $types = [
        'person' => 'Частное лицо',
        'company'=>'Компания'
    ];

    public function user(){
        return $this->hasOne('App\Models\User');
    }
}
