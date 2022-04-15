<?php

namespace App\Http\Controllers;


use App\Http\Requests\CategoryRequest;
use App\Models\User;
use App\Notifications\PostCreatedNotification;
use App\Repositories\AdsRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\CommentsRepository;
use App\Repositories\ProfileRepository;
use App\Repositories\TagRepository;
use App\Seo\SeometaFacade;
use CyrildeWit\EloquentViewable\Support\Period;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Article;
use App\Models\Tag;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class BlogController extends Controller
{

    /**
     * Метод формирования данных для главной страницы
     * @param Request $request
     * @param TagRepository $tagRepository
     * @param CategoryRepository $categoryRepository
     * @param AdsRepository $adsRepository
     * @return Factory|View
     */
    public function front (Request $request, TagRepository $tagRepository, CategoryRepository $categoryRepository, AdsRepository $adsRepository) {

        // Устанавливаем метатеги
        SeometaFacade::setData('front', config('seo'));
        // Доступные для вывода на главной объявления
        $ads = $adsRepository->forFrontPage();
        // Доступные коллекции на главной
        $collections = $tagRepository->forFrontPage();
        // Доступные категории на главной
        $categories = $categoryRepository->forFrontPage();

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
            $article = Article::findOrFail($id);
            views($article)->record();

            SeometaFacade::setData('post', $article->toArray());

            return view('blog.ads', compact('article'));

        } catch (\Exception $e) {
            return abort(404);
        }
    }



    public function tag ($slug) {

        try {
            $tag = Tag::where('slug', $slug)->firstOrFail();

            // Передаём настройки для сео
            SeometaFacade::setData('tag', $tag->toArray());

            $articles = $tag->articles()
                            ->where('published', 1)
                            ->where('moderate', 1)
                            ->paginate(12);

            return view('blog.collections', [
                'ads' => $articles,
                'tag' => $tag,
            ]);
        } catch (\Exception $e) {
            return abort(404);
        }
    }
}
