<?php

namespace App\Http\Controllers;


use App\Http\Requests\CategoryRequest;
use App\Models\User;
use App\Notifications\PostCreatedNotification;
use App\Repositories\CategoryRepository;
use App\Repositories\CommentsRepository;
use App\Repositories\ProfileRepository;
use App\Repositories\TagRepository;
use App\Seo\SeometaFacade;
use CyrildeWit\EloquentViewable\Support\Period;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Article;
use App\Models\Tag;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{


    public function front (Request $request, TagRepository $tagRepository, CategoryRepository $categoryRepository) {
        SeometaFacade::setData('front', config('seo'));
        $ads = Article::where('published', 1)
                      ->where('moderate', 1)
                      ->where('on_front', 1)
                      ->orderBy('sort', 'asc')->orderBy('id', 'asc')->take(20)->get();
        $collections = $tagRepository->allWithAds();
        $categories = $categoryRepository->getAllActiveItems();
        return view('blog.front', [
            'ads' => $ads,
            'collections' => $collections,
            'categories' => $categories,
        ]);
    }

    public function favorites (Request $request, ProfileRepository $profileRepository) {
        $adsId = $request->get('id');
        $action = '';

        if (Auth::id()) {
            $profile = $profileRepository->getFirstProfileByUser(Auth::id());
            if ($profileRepository->checkIfFavoritesIsSet($adsId, Auth::id())) {
                $profile->favoritePosts()->detach($adsId);
                $action = 'del';
            } else {
                $profile->favoritePosts()->attach($adsId);
                $action = 'add';
            }
            $count = count($profileRepository->getFavoritesArray($profile->id));
            return response(['action' => $action, 'count' => $count], 200);
        } else {

            if (!json_decode(Cookie::get('favorites'))) {
                $cookies[] = $adsId;
                $action = 'add';
            } else {
                $cookies = json_decode(Cookie::get('favorites'));
                if (!in_array($adsId, $cookies)) {
                    $cookies[] = $adsId;
                    $action = 'add';
                } else {
                    $key = array_search($adsId, $cookies);
                    unset($cookies[$key]);
                    $action = 'del';
                }
            }
            $count = count($cookies);
            $cookies = cookie('favorites', json_encode(array_values($cookies), JSON_OBJECT_AS_ARRAY));
            return response(['action' => $action, 'count' => $count], 200)->cookie(
                $cookies
            );
        }

    }


    public function favoritesList () {

        if (Auth::check()) {
            $ads = (new ProfileRepository)->favoritesListAuth();
        } else {
            $ads = (new ProfileRepository)->favoritesListNotAuth();
        }
        return view('blog.favorites', [
            'ads' => $ads,
            'favorites' => (new ProfileRepository)->getFavoritesIds(),
        ]);
    }


    public function category ($slug) {
        $category = Category::where('slug', $slug)->first();
        if (!$category) {
            abort(404);
        }

        $ads = $category->articles()
                        ->where('published', 1)
                        ->where('moderate', 1)
                        ->paginate(12);

        SeometaFacade::setData('category', $category->toArray());

        return view('blog.category', [
            'category' => $category,
            'ads' => $category->articles()->where('published', 1)->where('moderate', 1)->paginate(12),
        ]);
    }

    public function ads ($id) {
        try {
            $article = Article::find($id)->firstOrFail();
            views($article)->record();

            SeometaFacade::setData('post', $article->toArray());

            return view('blog.ads', [
                'ad' => $article,
            ]);

        } catch (\Exception $e) {
            return abort(404);
        }
    }



    public function tag ($slug) {

        try {
            $tag = Tag::where('slug', $slug)->firstOrFail();

            // Передаём настройки для сео
            SeometaFacade::setData('tag', $tag->toArray());

            $articles = $tag->articles()->where('published', 12)->paginate(12);

            return view('blog.collections', [
                'ads' => $articles,
                'tag' => $tag,
            ]);
        } catch (\Exception $e) {
            return abort(404);
        }
    }
}
