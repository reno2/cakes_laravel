<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ProfileNotificationsController extends Controller
{
    public function index()
    {
        $notifications = auth()->user()->unreadNotifications;
        return view('profile.notifications.index', compact('notifications'));
    }
    public function personal($id){

        if(!$id) return response()->json(array('success' => false), 400 );

        $notifications = User::find($id)->unreadNotifications->count();
        return response()->json(array('success' => true, 'notifications' => $notifications), 200);
    }
    public function read(Request $request){
        auth()->user()
            ->unreadNotifications
            ->when($request->input('id'), function ($query) use ($request) {
                return $query->where('id', $request->input('id'));
            })
            ->markAsRead();

        return response(true, 200);
    }
}