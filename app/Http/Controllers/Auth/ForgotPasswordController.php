<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

//    public function forgot(){
//        return view('forms.form_forgot');
//    }

//    public function password(Request $request){
//        $user = User::whereEmail($request->email)->first();
//        if(!$user) {
//            return back()->withErrors(['error' => 'Пользователь не найден'])->withInput();
//        }
//    }


//    public function sendResetLinkEmail(Request $request)
//    {
//        $this->validateEmail($request);
//
//        // We will send the password reset link to this user. Once we have attempted
//        // to send the link, we will examine the response then see the message we
//        // need to show to the user. Finally, we'll send out a proper response.
//        $response = $this->broker()->sendResetLink(
//            $this->credentials($request)
//        );
//
//        $response == Password::RESET_LINK_SENT
//            ? $this->sendResetLinkResponse($request, $response)
//            : $this->sendResetLinkFailedResponse($request, $response);
//
//
//        if ($response == Password::INVALID_USER) {
//            return redirect()->back()->withErrors(['email' => 'Пользователь не найден']);
//        }
//        return $response;
//
//    }
}
