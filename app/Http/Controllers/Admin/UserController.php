<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Mockery\Exception;

class UserController extends Controller{


    public $userService;

    public function __construct()
    {
        $this->userService = new UserService();
        $this->middleware('auth');
    }



    public function index(Request $request){

        $users = $this->userService->getAllForAdmin($request);

//        if ($request->get('sort')) {
//            $sort     = $request->get('sort');
//            $users = User::orderBy('created_at', $sort)->paginate(10);
//        } else {
//            $users = User::orderBy('created_at', 'desc')->paginate(10);
//        }
        return view('admin.users.index',
            compact('users')
        );
    }
    public function store(){

    }
    public function create(){

    }

    /**
     * Show the form for creating a new resource.
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(User $user) {
        return view('admin.users.switch_user', [
            'user' => $user
        ]);
    }

    public function update(Request $request, User $user){




        try{
            $this->userService->updateUser($user, $request);
            session()->flash('message', "Пользователь  изменен " . $user->email);
            return redirect()->route('admin.users.index');
        }catch  (\Exception $exception) {
            return back()->withErrors($exception->getMessage())->withInput();
        }

    }
}