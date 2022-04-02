<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * php artisan db:seed --class=UserSeeder
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\User::class,  2)->create()->each(function($user){
            if($user->id == 1) $user->update(['is_admin' => 1]);
            $profile = factory(\App\Models\Profile::class)->create();
            $user->profiles()->create([
                'user_id' => $user->id,
                'name' => 'test'
            ]);
        });
    }
}
