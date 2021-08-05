<?php

namespace App\Http\Controllers\admin;

use App\Models\Article;
use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Seo\SeometaFacade;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Tag;
class DashboardController extends Controller
{
    //Dashboard
    public function dashboard(){
        SeometaFacade::setStaticTag('title', 'Админ панель');
        return view('admin.dashboard', [
            'categories' => Category::LastCategories(5),
            //'articles' => Article::LastArticles(5),
            'count_categories' => Category::count(),
            'count_articles' => Article::count(),
            'count_users' => User::count()
        ]);
    }
}
