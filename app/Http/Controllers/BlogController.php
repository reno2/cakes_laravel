<?php

namespace App\Http\Controllers;

use App\Repositories\ProfileRepository;
use App\Seo\SeometaFacade;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Article;
use App\Models\Tag;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    //

    public function front(Request $request)
    {
        $ads               = Article::orderBy('sort', 'desc')->orderBy('created_at', 'desc')->paginate(9);
        $favorites_profile = null;
        $profileRepository = new ProfileRepository();
        if ($user = Auth::user()) {
            $profile           = $profileRepository->getFirstProfileByUser(Auth::id());
            $favorites_profile = $profileRepository->getFavoritesArray($profile->id);
        }
        $rr = json_decode(Cookie::get('favorites'));
        return view('front', [
            'ads' => $ads,
            'favorites_cookies' => json_decode(Cookie::get('favorites')),
            'favorites_profile' => $favorites_profile
        ]);

    }

    public function favorites(Request $request, ProfileRepository $profileRepository)
    {
        $adsId  = $request->get('id');
        $action = '';

        if (Auth::id()) {
            if ($profileRepository->checkIfFavoritesIsSet($adsId)) {
                $profileRepository->getFirstProfileByUser(Auth::id())->favoritePosts()->detach($adsId);
                $action = 'del';
            } else {
                $profileRepository->getFirstProfileByUser(Auth::id())->favoritePosts()->attach($adsId);
                $action = 'add';
            }

            return response($action, 200);
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
            $rrr = json_encode(array_values($cookies), JSON_OBJECT_AS_ARRAY);
            $v = '';
            $cookies = cookie('favorites', json_encode(array_values($cookies), JSON_OBJECT_AS_ARRAY));

            return response($action, 200)->cookie(
                $cookies
            );
        }

    }





    public function category($slug)
    {


        $category = Category::where('slug', $slug)->first();
        if (!$category) {
            abort(404);
        }
        SeometaFacade::setTags('category', $category->toArray());

        return view('blog.category', [
            'category' => $category,
            'articles' => $category->articles()->where('published', 1)->paginate(12)
        ]);
    }

    public function post($slug)
    {

        $article = Article::where('slug', $slug)->first();
        SeometaFacade::setTags('article', $article->toArray());

        //MetaTag::setTags(['title'=> $article->title]);
        //dd($category->articles()->where('published', 0)->paginate(12));
        return view('blog.post', [
            'article' => $article,
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
