<?php

namespace App\Http\Controllers\admin;

use App\Models\Article;
use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Repositories\AdsRepository;
use App\Repositories\CommentsRepository;
use App\Repositories\UserRepository;
use App\Seo\SeometaFacade;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Tag;
class DashboardController extends Controller
{
    //Dashboard
    public function dashboard(
        AdsRepository $adsRepository,
        UserRepository $userRepository,
        CommentsRepository $commentsRepository
    ){

        SeometaFacade::setStaticTag('title', 'Админ панель');
        $todayAds = $adsRepository->getTodayAds();
        $todayUsers = $userRepository->getTodayUsers();
        $todayComments = $commentsRepository->getTodayComments();
        return view('admin.dashboard', [

            'today_articles' => $todayAds,
            'today_users' => $todayUsers,
            'today_comments' => $todayComments,

            'today_articles_count' => ($todayAds) ? $todayAds->count() : 0,
            'today_users_count' => ($todayUsers) ? $todayUsers->count() : 0,
            'today_comments_count' => ($todayComments) ? $todayComments->count() : 0,

            'articles' => Article::LastArticles(10),
            'count_categories' => Category::count(),
            'count_articles' => Article::count(),
            'count_users' => User::count()
        ]);
    }
}
