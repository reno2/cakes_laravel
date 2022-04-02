<?php

use Illuminate\Database\Seeder;

class TagTableSeed extends Seeder
{
    /**
     * php artisan db:seed --class=TagTableSeed
     * Создаст теги категории и объявления
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\Tag::class,  1)->create()->each(function($tag){
            $category = factory(\App\Models\Category::class)->create();

            factory(App\Models\Article::class, 3)->create()->each(function($article) use ($category, $tag){
                $article->categories()->attach($category);
                $tag->articles()->save($article);
            });



        });
    }
}
