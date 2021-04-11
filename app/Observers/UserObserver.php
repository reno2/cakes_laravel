<?php

namespace App\Observers;

use App\Models\User;
use App\Notifications\NewUserNotification;
use App\Notifications\PostCreatedNotification;
use App\Repositories\ProfileRepository;
use Illuminate\Support\Facades\Notification;

class UserObserver
{
    /**
     * Handle the user "created" event.
     *
     * @param User $user
     * @return void
     */
    public function created(User $user)
    {

//        $user->profiles()->create();
//        (new ProfileRepository())->setProfileNameAfterRegister($user->id);

        $userTo = User::find(1);
        if($userTo) {
            $data = [
                'name' => $user->name
            ];
            Notification::send($userTo, new NewUserNotification($data));
        }

    }

    /**
     * Handle the user "updated" event.
     *
     * @param  User  $user
     * @return void
     */
    public function updated(User $user)
    {
        //
    }

    /**
     * Handle the user "deleted" event.
     *
     * @param  User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        //
    }

    /**
     * Handle the user "restored" event.
     *
     * @param  User  $user
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the user "force deleted" event.
     *
     * @param  User  $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        //
    }
}
