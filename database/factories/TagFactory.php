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


$factory->define(App\Models\Tag::class, function (Faker $faker) {
    $users = [1, 1, 1];
    $filePath = '/storage/images/defaults/';
    $title = $faker->word();
    $slug = Str::slug($title);
    return [
        'title' => $title,
        'published' => 1,
        'slug' => $slug
        //'image' => $faker->image('public/storage/images/tags',640,480, null, false),
    ];
});
