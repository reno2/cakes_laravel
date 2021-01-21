<?php

namespace App\Http\Controllers\Profile;

use App\Http\Requests\FileValidate;
use App\Http\Requests\ProfileValidate;
use App\Http\Requests\UserEditValidate;
use App\Models\Profile;
use App\Models\User;
use App\Repositories\ProfileRepository;
use App\Repositories\UserRepository;
use App\Repositories\CoreRepository;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;
use Mockery\Exception;


class ProfileController extends Controller
{
//    public function __construct()
//    {
//        $this->middleware('auth');
//    }

    public function index(UserRepository $userRepository)
    {
        $user = Auth::user();

        return view('profile.index', [
            'user'    => $user,
            'profile' => $userRepository->getUserProfileEdit($user->id),
        ]);
    }

    public function edit(UserRepository $userRepository, ProfileRepository $profileRepository)
    {
        $user    = Auth::user();
        $profile = $userRepository->getUserProfileEdit($user->id);


        return view('profile.edit', [
            'check' => $profileRepository->checkIfCanAddAds($user),
            'user'         => $user,
            'profile'      => $profile,
            'profileTypes' => $profileRepository->getTypes()
        ]);
    }

    public function secure(UserRepository $userRepository, ProfileRepository $profileRepository)
    {
        $user    = Auth::user();
        $profile = $userRepository->getUserProfileEdit($user->id);

        return view('profile.secure', [
            'user'    => $user,
            'profile' => $profile
        ]);
    }

    public function secureUpdate(
        User $user,
        UserEditValidate $request
    ) {
        $validated = $request->validated();
        if (Hash::check($request->input('password'), $user->password)) {
            if (!Hash::check($request->input('new_password'), $user->password)) {
                try {
                    // Создаём пустой массив
                    $newUser = [];
                    // Проверяем если почта изменена, то добавляем в изменения
                    if ($request->input('email') !== $user->email) {
                        $newUser['email'] = $request->input('email');
                    }
                    // Создаём новый хеш
                    $newUser['password'] = Hash::make($request->input('new_password'));
                    $user->update($newUser);
                    // Сообщаем что всё гуд
                    return redirect()
                        ->route('profile.secure', ['user' => $user,])
                        ->with(['message' => 'Данные пользователя изменены']);

                } catch (Exception $exception) {
                    session()->flash('message', $exception->getMessage());
                    return redirect()->route('profile.secure');
                }
            } else {
                return redirect()->back()->withInput()->withErrors(['password' => "Пароль не может бытьь равен текущему"]);
            }
        } else {
            return redirect()->back()->withInput()->withErrors(['password' => "Пароль не совпадает с текущим"]);
        }
    }

    public function update(
        Profile $profile,
        ProfileValidate $request,
        UserRepository $userRepository,
        ProfileRepository $profileRepository
    ) {

        // Валидируем поля
        $validated   = $request->validated();
        $inputsArray = $request->all();

        // Добавление файла на диск ресайз, и создание ссылки
        if ($request->hasFile('image')) {
            $uploadedImage = $request->file('image');
            $path          = 'public/images/avatar/' . $profile->user_id . '.' . $uploadedImage->getClientOriginalExtension();
            $newImage      = Image::make($uploadedImage)->fit(200, 200, function ($constraint) {
                $constraint->upsize();
            }, 'center');
            Storage::put($path, (string)$newImage->encode());
            $url                  = Storage::url($path);
            $inputsArray['image'] = $url;
        }

        try {
            $update = $profile->update($inputsArray);

            //return back()->withInput();
            return redirect()->route('profile.edit')->with([
                'user'         => $profileRepository->getUserEdit($profile),
                'profile'      => $profile,
                'profileTypes' => $profileRepository->getTypes()
            ]);
        } catch (Exception $exception) {
            session()->flash('message', $exception->getMessage());
            //$response->header("Cache-Control", "no-store,no-cache, must-revalidate, post-check=0, pre-check=0");
            return redirect()->route('profile.index')
                ->header('Cache-Control', 'no-store, no-cache, must-revalidate');
        }

    }
}
