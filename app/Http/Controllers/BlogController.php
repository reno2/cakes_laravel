<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\PostCreatedNotification;
use App\Repositories\CommentsRepository;
use App\Repositories\ProfileRepository;
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
    //

    public function front(Request $request)
    {
        SeometaFacade::setData('front', config('seo'));
        $ads = Article::where('published', 1)
                      ->where('moderate', 1)
                      ->orderBy('sort', 'desc')->orderBy('created_at', 'desc')->paginate(9);
        return view('blog.front', [
            'ads' => $ads,
        ]);
    }

    public function favorites(Request $request, ProfileRepository $profileRepository)
    {
        $adsId  = $request->get('id');
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
            $count =  count($profileRepository->getFavoritesArray($profile->id));
            return response(['action'=>$action, 'count' => $count], 200);
        } else {

            if (!json_decode(Cookie::get('favorites'))) {
                $cookies[] = $adsId;
                $action    = 'add';
            } else {
                $cookies = json_decode(Cookie::get('favorites'));
                if (!in_array($adsId, $cookies)) {
                    $cookies[] = $adsId;
                    $action    = 'add';
                } else {
                    $key = array_search($adsId, $cookies);
                    unset($cookies[$key]);
                    $action = 'del';
                }
            }
            $count = count($cookies);
            $cookies = cookie('favorites', json_encode(array_values($cookies), JSON_OBJECT_AS_ARRAY));
            return response(['action'=>$action, 'count' => $count], 200)->cookie(
                $cookies
            );
        }

    }


    public function favoritesList(){

        if (Auth::check()) {
            $ads = (new ProfileRepository)->favoritesListAuth();
        }else{
            $ads = (new ProfileRepository)->favoritesListNotAuth();
        }
        return view('blog.favorites', [
            'ads' => $ads,
            'favorites' => (new ProfileRepository)->getFavoritesIds()
        ]);
    }


    public function category($slug)
    {
        $category = Category::where('slug', $slug)->first();
        $ads = $category->articles()->where('published', 0)->paginate(12);
        if (!$category) {
            abort(404);
        }
        SeometaFacade::setData('category', $category->toArray());

        return view('blog.category', [
            'category' => $category,
            'ads' => $category->articles()->where('published', 1)->paginate(12)
        ]);
    }

    public function ads($slug)
    {

        $article = Article::where('slug', $slug)->first();
        views($article)->record();

        SeometaFacade::setData('post', $article->toArray());
//        SeometaFacade::setTags('article', $article->toArray());


//        $rr = views($article)
//            ->period(Period::pastDays(1))
//            ->count();
//        dd($rr);
        //MetaTag::setTags(['title'=> $article->title]);
        //dd($category->articles()->where('published', 0)->paginate(12));
        return view('blog.ads', [
            'ad' => $article,
            //'articles' => $category->articles()->where('published', 1)->paginate(12)
        ]);
    }


    public function tag($slug)
    {

        MetaTag::setTags(['title' => $slug]);

        $tag      = Tag::where('name', $slug)->first();
        $articles = $tag->articles()->where('published', 1)->paginate(12);

        //dd($category->articles()->where('published', 0)->paginate(12));
        return view('blog.category', [
            'articles' => $articles,
            'tag'      => $tag
            //'articles' => $category->articles()->where('published', 1)->paginate(12)
        ]);
    }
}
