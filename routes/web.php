<?php

use App\Mail\UserRegisteredMail;
use App\Models\User;
use App\Notifications\NewUserNotification;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Notification;
use App\Notifications\PostCreatedNotification;

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

// Route::get('/t', function () {
//    $rr = \App\Models\Room::find(1);
//    $rr->users()->attach([1,2]);
//    dd($rr);
// });


Route::get('/blog/article/{slug?}', 'BlogController@article')->name('article');
Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth', 'verified', 'is_admin']],
    function () {
        Route::get('/', 'DashboardController@dashboard')->name('admin.index');
        Route::resource('/category', 'CategoryController', ['as' => 'admin']);
        Route::resource('/tags', 'TagController', ['as' => 'admin']);
        Route::resource('/features', 'Features\FeaturesTypeController', ['as' => 'admin']);
        Route::resource('/settings', 'SettingsController', ['as' => 'admin']);
        Route::resource('/users', 'UserController', ['as' => 'admin']);
        // Пост
        Route::resource('/article', 'ArticleController', ['as' => 'admin']);
        Route::post('/article/update/', 'ArticleController@postUp')->name('admin.article.up');
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
        //        Route::group(['prefix' => 'user_managment', 'namespace' => 'UserManagment'], function(){
        //            Route::resource('/user', 'UserController', ['as'=> 'user_managment']);
        //        });
        Route::post('/upload/fileUpload', 'ImageController@upload')->name('ckeditor.upload');
        Route::post('/upload/image', 'ImageController@add')->name('img_add');
        //Route::get('/search', "ArticleController@search")->name('admin_search');
    });

// ===== PROFILE ===============================
Route::group(['prefix' => 'profile', 'namespace' => 'Profile', 'middleware' => ['auth', 'verified']],
    function () {
        Route::get('/', 'ProfileController@index')->name('profile.index');
        Route::get('/edit', 'ProfileController@edit')->name('profile.edit');
        Route::get('/secure', 'ProfileController@secure')->name('profile.secure');
        Route::post('/favorites', 'ProfileController@favorites')->name('profile.favorites');
        Route::delete('/avatar/remove/{profile_id}', 'ProfileController@removeAva')->name('profile.avatar.remove');

        // Уведомления для пользователя
        Route::get('/notifications/', 'ProfileNotificationsController@index')->name('profile.notice.index');
        Route::get('/notifications/personal/{user_id}', 'ProfileNotificationsController@personal')->name('profile.notice.personal');
        Route::post('/notifications/read', 'ProfileNotificationsController@read')->name('profile.notice.read');
       
       
        // Comments
        Route::post('/comments/', 'CommentController@store')->name('comments.store');
        Route::post('/comments/{comment_id}', 'CommentController@answer')->name('comments.answer');
        Route::put('/comments/{comment_id}', 'CommentController@update')->name('comments.update');
        Route::delete('/comments/{comment_id}', 'CommentController@destroy')->name('comments.destroy');



        Route::get('/comments', 'CommentController@index')->name('comments.index');
        //Route::get('/comments/{article_id}', 'CommentController@article')->name('comments.article');
        Route::get('/comments/{room}', 'CommentController@comment')->name('comments.comment')->middleware('room_access');

        Route::get('/favorites', 'ProfileController@favoritesList')->name('profile.favorites_list');
        Route::put('/secureUpdate/{user}', 'ProfileController@secureUpdate')->name('profile.secure.update');
        Route::put('/update/{profile}', 'ProfileController@update')->name('profile.update');
        Route::group(['namespace' => 'Ads', 'middleware' => ['profile']], function () {
            Route::resource('/ads', 'AdsController', ['as' => 'profile']);
        });
    });

Route::get('/autocomplete', "SearchController@autocomplete")->name('admin_autocomplete');



Route::get('/home', 'HomeController@index')->name('home')->middleware('verified');
Route::get('/', 'BlogController@front')->name('front');
Route::get('/category/{slug?}', 'BlogController@category')->name('category');
Route::get('/ads/{slug?}/', 'BlogController@ads')->name('ads');
Route::get('/tag/{slug?}', 'BlogController@tag')->name('tag');

Route::get('/', 'BlogController@front')->name('main');
Route::post('/favorites', 'BlogController@favorites')->name('favorites');
Route::get('/favorites', 'BlogController@favoritesList')->name('favorites_list');

Route::get('/test-mail', function () {


    //return  (new PostCreatedNotification(['name'=> 'efef']))->toMail('chedia@mail.ru');
    return (new NewUserNotification(['name' => 'efef']))->toMail('chedia@mail.ru');


});

Route::get('login/{driver}', 'Auth\SocialController@redirect')
     ->name('login.driver')
     ->where('driver', implode('|', config('auth.socialite.drivers')));

Route::get('login/{driver}/callback', 'Auth\SocialController@callback')
     ->name('login.callback')
     ->where('driver', implode('|', config('auth.socialite.drivers')));


Route::get('queue', function () {
    $ads = \App\Models\Article::find(1);
    $moderate = \App\Models\Moderate::create([
        "rules" => "32",
        "message" => "derewrwr",
    ]);
    $ads->moderateComments()->save($moderate);
    //dd($ads);
    //    $userTo = User::find(1);
    //    $data = [
    //        'name' => "lkilili"
    //    ];
    //    Notification::send($userTo, new \App\Notifications\TestNotification($data));
});