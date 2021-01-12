<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes(['verify' => true]);

Route::get('/', function () {
    return view('welcome');
});


Route::get('/blog/article/{slug?}', 'BlogController@article')->name('article');
Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth', 'verified']],
    function(){

       Route::get('/', 'DashboardController@dashboard')->name('admin.index');
        Route::resource('/category', 'CategoryController', ['as'=> 'admin']);
        Route::resource('/tags', 'TagController', ['as'=> 'admin']);
        Route::resource('/features', 'Features\FeaturesTypeController', ['as'=> 'admin']);


        // Пост
        Route::resource('/article', 'ArticleController', ['as'=> 'admin']);
        Route::post('/article/update/', 'ArticleController@postUp')->name('admin.article.up');
        //Route::resource('/seo', 'SeoController', ['as'=> 'admin']);

        Route::group(['prefix' => 'seo', 'namespace' => 'Seo'], function () {
            Route::group(['prefix' => '/category'], function () {
                Route::get('/', 'SeoCategoryController@get')->name('seo.category.index');
                Route::post('/update', 'SeoCategoryController@updateCategory')->name('seo.category.update');
            });
            Route::group(['prefix' => '/post'], function () {
                Route::get('/', 'SeoPostController@get')->name('seo.post.index');
                Route::post('/update', 'SeoPostController@updatePost')->name('seo.post.update');
            });

        });
//
//
//        Route::group(['prefix' => 'user_managment', 'namespace' => 'UserManagment'], function(){
//            Route::resource('/user', 'UserController', ['as'=> 'user_managment']);
//        });
//
//
//
        Route::post('/upload/fileUpload', 'ImageController@upload')->name('ckeditor.upload');

        Route::post('/upload/image', 'ImageController@add')->name('img_add');
//

//
       //Route::get('/search', "ArticleController@search")->name('admin_search');
    });


Route::group(['prefix' => 'profile', 'namespace' => 'Profile', 'middleware' => ['auth', 'verified']],
    function(){
        Route::get('/', 'ProfileController@index')->name('profile.index');
        Route::get('/edit', 'ProfileController@edit')->name('profile.edit');
        Route::get('/secure', 'ProfileController@secure')->name('profile.secure');
        Route::put('/secureUpdate/{user}', 'ProfileController@secureUpdate')->name('profile.secure.update');
        Route::put('/update/{profile}', 'ProfileController@update')->name('profile.update');
        Route::get('/articles', 'ProfileController@edit')->name('profile.articles');
});

Route::get('/autocomplete', "SearchController@autocomplete")->name('admin_autocomplete');



Route::get('/home', 'HomeController@index')->name('home')->middleware('verified');
Route::get('/', 'BlogController@front')->name('front');
Route::get('/blog/category/{slug?}', 'BlogController@category')->name('category');
Route::get('/blog/post/{slug?}/', 'BlogController@post')->name('post');
