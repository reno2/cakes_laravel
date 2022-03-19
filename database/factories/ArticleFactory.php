<?php



use App\Models\Article;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Str;
/** @var Factory $factory */
/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/


$factory->define(App\Models\Article::class, function (Faker $faker) {
    $users = [4, 3, 5];
    $filePath = '/storage/images/defaults/';
    return [
        'title' => $faker->unique(true)->name,
        'description' => $faker->paragraph,
        'deal_address' => $faker->title,
        'price'=> $faker->numberBetween(10, 200),
        'weight'=> $faker->numberBetween(10, 200),
        'user_id' => $faker->randomElement($users),
        'sort' => 100,
        'moderate' => 0,
        'published' => 1
        //'image' => $faker->imageUrl(400,300)
//        'tags' => 7,
//        'categories' => 1
           // $faker->randomElement(['seller', 'buyer'])
    ];
});
