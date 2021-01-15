<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable = ['contact2', 'contact1', 'published', 'address', 'filled', 'type', 'image', 'favorites', 'name', 'created_by', 'modifierd_by', 'image', 'address', 'rating', 'user_id', 'filled'];
    //protected $guarded = [];
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
