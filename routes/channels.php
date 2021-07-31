<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('room.{room_id}', function ($user, $room_id) {

    $auth = \App\Models\Room::where('id', $room_id)->where(function($query) use ($user){
        $query->where('owner_id', $user->id)->orWhere('asked_id', $user->id);
    })->first();

    return ($auth->exists) ? $user->id : false;
    //return true;
    //return (int) $user->id === (int) $id;
});
