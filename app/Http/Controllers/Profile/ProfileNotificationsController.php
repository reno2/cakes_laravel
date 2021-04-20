<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ProfileNotificationsController extends Controller
{
    public function index()
    {
        $notifications = auth()->user()->unreadNotifications;
        return view('profile.notifications.index', compact('notifications'));
    }
    public function read(Request $request){
        //dd( $request);
        auth()->user()
            ->unreadNotifications
            ->when($request->input('id'), function ($query) use ($request) {

                return $query->where('id', $request->input('id'));
            })
            ->markAsRead();

        return response(true, 200);
    }
}