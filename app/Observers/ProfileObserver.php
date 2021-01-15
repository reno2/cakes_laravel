<?php

namespace App\Observers;

use App\Models\Profile;

class ProfileObserver
{
    /**
     * Handle the profile "created" event.
     *
     * @param Profile $profile
     *
     * @return void
     */
    public function created(Profile $profile)
    {
        //dd($profile->toArray());
    }

    /**
     * Handle the post "saving" event.
     *
     * @param $profile
     * @return void
     */
    public function saving(Profile $profile)
    {
        $data = $profile->toArray();
        if (!empty($data['address']) && (!empty($data['contact1']) || !empty($data['contact2']))) {
            if (!$data['filled']) {
                $profile->filled = true;
            }
        } else {
            $profile->filled = false;
        }
    }


    /**
     * Handle the profile "updated" event.
     *
     * @param Profile $profile
     *
     * @return void
     */
    public function updated(Profile $profile)
    {
        //
    }

    /**
     * Handle the profile "deleted" event.
     *
     * @param Profile $profile
     *
     * @return void
     */
    public function deleted(Profile $profile)
    {
        //
    }

    /**
     * Handle the profile "restored" event.
     *
     * @param Profile $profile
     *
     * @return void
     */
    public function restored(Profile $profile)
    {
        //
    }

    /**
     * Handle the profile "force deleted" event.
     *
     * @param Profile $profile
     *
     * @return void
     */
    public function forceDeleted(Profile $profile)
    {
        //
    }
}
