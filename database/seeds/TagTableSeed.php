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
        factory(App\Models\Tag::class,  2)->create()->each(function($tag){
            $category = factory(\App\Models\Category::class)->create();
            $article = factory(App\Models\Article::class)->create();
            $article->categories()->attach($category);
            $tag->articles()->save($article);
        });

    }
}
