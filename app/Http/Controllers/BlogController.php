<?php

namespace App\Http\Controllers;

use App\Seo\SeometaFacade;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Article;
use App\Models\Tag;

use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    //

		public function front(Request $request){
				$articles = Article::where('on_front', 1)->orderBy('sort', 'desc')->orderBy('created_at', 'desc')->take(10)->get();

				return view('blog.home', compact('articles'));
				//
		}

		public function category($slug){


				$category = Category::where('slug', $slug)->first();
                if(!$category)  abort(404);
                SeometaFacade::setTags('category', $category->toArray());
				return view('blog.category', [
						'category' => $category,
						'articles' => $category->articles()->where('published', 1)->paginate(12)
				]);
		}

		public function post($slug){

				$article = Article::where('slug', $slug)->first();
                SeometaFacade::setTags('article', $article->toArray());

				//MetaTag::setTags(['title'=> $article->title]);
				//dd($category->articles()->where('published', 0)->paginate(12));
				return view('blog.post', [
						'article' => $article,
						//'articles' => $category->articles()->where('published', 1)->paginate(12)
				]);
		}


		public function tag($slug){

				MetaTag::setTags(['title'=> $slug]);

				$tag = Tag::where('name', $slug)->first();
				$articles = $tag->articles()->where('published', 1)->paginate(12);
				//dd($category->articles()->where('published', 0)->paginate(12));
				return view('blog.category', [
						'articles' => $articles,
						'tag' => $tag
						//'articles' => $category->articles()->where('published', 1)->paginate(12)
				]);
		}
}
