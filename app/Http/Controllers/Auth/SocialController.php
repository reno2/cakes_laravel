<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Repositories\ProfileRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;


class SocialController extends Controller
{
    public function redirect($driver)
    {
        return Socialite::driver($driver)->redirect();
    }
    public function callback($driver)
    {

        try {
            $user = Socialite::driver($driver)->user();
           // dd($user);
        } catch (\Exception $e) {
            return redirect()->route('login');
        }

        $existingUser = User::where('email', $user->getEmail())->first();

        if ($existingUser) {
            auth()->login($existingUser, true);
        } else {
            $newUser                    = new User;
            $newUser->provider           = $driver;
            $newUser->provider_id       = $user->getId();
            $newUser->name              = $user->getName();
            $newUser->email             = $user->getEmail();
            $newUser->email_verified_at = now();
            $newUser->save();

            $image = null;
            if($user->getAvatar()) $image  = $user->getAvatar();
            $newUser->profiles()->create(['image'=>$image]);
            (new ProfileRepository())->setProfileNameAfterRegister($newUser->id);
            auth()->login($newUser, true);
        }
        return redirect('/profile');
    }
}
