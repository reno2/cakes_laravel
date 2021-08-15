<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;

class ProfileNotificationsController extends Controller
{

    public function moderate()
    {
        $notifications = (new UserRepository)->getNotReadModerateNotice();
        return view('profile.notifications.moderate.index', compact('notifications'));
    }

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



    public function read(Request $request, $id = false){

        //dd($id);
        auth()->user()
            ->unreadNotifications
            ->when($id, function ($query) use ($id) {
                return $query->where('id', $id);
            })
            ->markAsRead();
//

        $notifications = (new UserRepository)->getNotReadModerateNotice();
        $notifications->setPath('');
        return view('chunks.notice_moderate', compact('notifications'))->render();
    }
}