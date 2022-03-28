<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Article;
use App\Models\Profile;
use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

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

$factory->define(Profile::class, function (Faker $faker) {
    return [
        'published' => true,
        'filled' => true,
        'type' => 'person',
        'favorites' => null,
        'name' => $faker->word,
        'image' => null,
        'address' => $faker->word,
        'contact1' => $faker->word,
        'contact2' => $faker->word,
        'rating' => 1
    ];
});

