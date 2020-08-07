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
        Route::resource('/article', 'ArticleController', ['as'=> 'admin']);
        Route::resource('/tags', 'TagController', ['as'=> 'admin']);

        //Route::resource('/seo', 'SeoController', ['as'=> 'admin']);

        Route::group(['prefix' => 'seo', 'namespace' => 'Seo'], function () {
            Route::group(['prefix' => '/category'], function () {
                Route::get('/', 'SeoCategoryController@get')->name('seo.category.index');
               // Route::get('/add', 'SeoController@categoryAdd')->name('seo.category.add');
                Route::post('/update', 'SeoCategoryController@updateCategory')->name('seo.category.update');
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
//        Route::get('/search', "ArticleController@search")->name('admin_search');
//        Route::get('/autocomplete', "ArticleController@autocomplete")->name('admin_autocomplete');

    });




Route::get('/home', 'HomeController@index')->name('home')->middleware('verified');
Route::get('/', 'BlogController@front')->name('front');
Route::get('/blog/category/{slug?}', 'BlogController@category')->name('category');
