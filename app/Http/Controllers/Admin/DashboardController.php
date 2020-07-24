<?php

namespace App\Http\Controllers\admin;

use App\Article;
use App\Category;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //Dashboard
    public function dashboard(){
        MetaTag::setTags(['title'=> 'Админ панель']);
        return view('admin.dashboard', [
//            'categories' => Category::LastCategories(5),
//            'articles' => Article::LastArticles(5),
//            'count_categories' => Category::count(),
//            'count_articles' => Article::count(),
//            'count_users' => User::count()
        ]);
    }
}
