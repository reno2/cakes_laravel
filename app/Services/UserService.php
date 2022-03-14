<?php

namespace App\Services;


use App\Media\LocalMedia;
use App\Models\Attachment;
use App\Models\Tag;
use App\Repositories\AdsRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserService
{
    public function getAllForAdmin () {
        $users = (new UserRepository())->getSortedPagination();
        foreach ($users as $user) {
            if ($user->profiles()->exists()) {
                $profile = $user->profiles()->first();
                $user->name = $profile['name'];
                $user->image = $profile['image'];
            }
        }
        return $users;

    }


    public function updateUser ($user, $request) {
        $inputsArray = $request->all();
        list('password' => $curPass, 'new_password' => $newPass, 'confirm_password' => $confirmPass)
            = $inputsArray;


        if($newPass && $curPass && $confirmPass){
            if($confirmPass !== $newPass)
                $this->fail('Новыцй пароль не совпадает с полем подтверждение');

            $inputsArray['password'] =  $this->changePassword($request, $user);
        }
        else{
            $inputsArray['password'] = $user->password;
        }

        if( $user->fill($inputsArray)->save()){
            if(!$user->active){
                try {
                    (new AdsRepository())->disableUserAds($user->id);
                }catch  (\Exception $exception) {
                    $this->fail($exception->getMessage());
                }
            }
        }else{
            $this->fail('Ошибка при изменении пользователя"');
        }

    }


    /*
     * @params Request $request
     * Принимае реквест, проверяет раветсво пароля
     * @return $user
     */
    public function changePassword($request, $user)
    {
        //->fail('Пароль не совпадает с текущим"');
        if (Hash::check($request->input('password'), $user->password)) {
            if (!Hash::check($request->input('new_password'), $user->password)) {
                // Создаём новый хеш
             return Hash::make($request->input('new_password'));
            }
        } else {
            $this->fail('Пароль не совпадает с текущим"');
        }
    }


    public function fail($msg = 'Ошибка изменения профиля')
    {
        throw new \Exception($msg);
    }
}