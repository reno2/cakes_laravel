<?php

// Home
Breadcrumbs::for('home', function ($trail) {
    $trail->push('Главная', '/');
});

// Home > Blog > [Category] > [Post]
Breadcrumbs::for('category', function ($breadcrumbs, $category) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push($category->title, route('category', ['slug' => $category->slug ]));
});

Breadcrumbs::for('tag', function ($breadcrumbs, $tag) {
    $breadcrumbs->parent('home');
    $breadcrumbs->push($tag->title, route('tag', ['slug' => $tag->title ]));
});

Breadcrumbs::register('article', function ($trail, $category, $article) {
    $trail->parent('category', $category);
    $trail->push($article->title, route('article', ['slug' => $article->slug ]));
});

