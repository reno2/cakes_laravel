<?php

namespace App\Services;

use App\Models\PostImage;
use App\Models\User;
use App\Repositories\AdsRepository;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Traits\UploadTrait;

class ProfileService
{
    /*
     * @params Request $request
     * Принимае реквест, проверяет раветсво пароля
     * @return $user
     */
    public function changePassword($request, $user)
    {
        $this->fail('Пароль не совпадает с текущим"');
        if (Hash::check($request->input('password'), $user->password)) {
            if (!Hash::check($request->input('new_password'), $user->password)) {
                // Создаём пустой массив
                $newUser = [];
                // Проверяем если почта изменена, то добавляем в изменения
                if ($request->input('email') !== $user->email) {
                    $newUser['email'] = $request->input('email');
                }
                // Создаём новый хеш
                $newUser['password'] = Hash::make($request->input('new_password'));
                if ($user->update($newUser)) {
                    return $user;
                } else $this->fail('Ошибка при изменении пользователя"');

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
