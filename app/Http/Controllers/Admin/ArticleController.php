<?php

namespace App\Http\Controllers\Admin;

use App\Events\AdsModerate;
use App\Http\Requests\AdsRequest;
use App\Models\Article;
use App\Models\Category;
use App\Models\Moderate;
use App\Models\Settings;
use App\Models\User;
use App\Notifications\ModerateNotification;
use App\Notifications\PostCreatedNotification;
use App\Repositories\AdsRepository;
use App\Repositories\ProfileRepository;
use App\Services\AdsService;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Mockery\Exception;
use App\Http\Requests\FileValidate;
use App\Models\PostImage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\Models\Media;

class ArticleController extends Controller
{

    public $adsRepository;
    public $adsService;

    public function __construct (AdsService $adsService, AdsRepository $adsRepository) {
        $this->adsService = $adsService;
        $this->adsRepository = $adsRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return Factory|View
     */
    private $count = 5;

    public function index(Request $request)
    {
        $articles = $this->adsService->getAllForEdit($request);
        return view('admin.articles.index',
            compact('articles')
        );

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     */
    public function create()
    {
        $tags = \App\Models\Tag::where('published', 1)->get();

        //dd(Category::with('children')->where('parent_id', 0)->get());
        return view('admin.articles.switch_article', [
            'tags'       => $tags,
            'article'    => [],
            'categories' => Category::with('children')->where('parent_id', 0)->get(),
            'delimiter'  => ''
        ]);
    }


    public function store(AdsRequest $request){
        $validated = $request->validated();
        $inputs = $request->all();

        $extraData = [
            'user_id' => Auth::id(),
            'moderate' => isset($request['moderate']) ? 1 : 0,
            'sort' => $request['sort'] ?? 100
        ];
        $article = Article::create(
            array_merge(
                $request->except('image'),
                $extraData)
        );
        try{
            $this->adsService->chain($inputs, $article);
            session()->flash('notice', "Объявление создано");
        }catch (\Exception $e){
            return back()->withErrors( $e->getMessage())->withInput();
        }
        return redirect()->route('admin.article.index');
    }



    public function show(Article $article)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Article $article
     *
     * @return Factory|View
     * @return Factory|View
     */
    public function edit(Article $article)
    {
        $article = $this->adsRepository->getForEdit($article->id);
        $tags = \App\Models\Tag::all();
        $mediaItem =  Media::where('model_id', $article->id)->whereJsonContains('custom_properties->main', true)->first();

        $rule = $article->moderateComments->first();
        if($rule){
            $moderateRules['moderate_text'] = $rule['message'] ?? '';
            $moderateRules['rule'] = $rule->settings->pluck('id')->toArray();
            $moderateRules['id'] = $rule->id;
        }

        $allRules = \App\Models\Settings::where('type', 'moderate_rules')->get();

        return view('admin.articles.switch_article', [
            'main' => ($mediaItem->file_name) ?? '',
            'mediaFiles'=> $this->adsRepository->getAdsImages($article->id),
            'article'    => $article,
            'categories' => Category::with('children')->where('parent_id', 0)->get(),
            'tags'       => $tags,
            'filter'     => $article->filterValues->pluck('id')->toArray(),
            'delimiter'  => '',
            'profile' => $this->adsRepository->getUserProfileFirst($article),
            'rules' => $allRules,
            'selectedRules' => $moderateRules ?? []
        ]);
    }




    public function update(AdsRequest $request, $id)
    {

        $request->validated();
        $ads = Article::find($id);
        $inputs = $request->all();
        $isAdmin = (strpos($request->segment(1), 'admin') !== false) ? true : false;

        try{
            $moderateMsg =  ($this->adsService->uploadChain($inputs, $ads, $isAdmin)) ? $ads::MODERATE_AND_UPDATE :  $ads::UPDATE;
            $request->session()->flash('notice', $moderateMsg);
        }catch (\Exception $e){
            return back()->withErrors( $e->getMessage())->withInput();
        }
        $url = $request->only('redirects_to');
        return redirect()->to($url['redirects_to']);




    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Article $article
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy( Article $article, Request $request) {

        try{
            $article->favoritesProfiles()->detach();
            $this->adsService->removeAds($article);
        }catch (\Exception $e){
            if($request->ajax())
                return response()->json(array('success' => false), 500);
            return redirect()->route('profile.ads.index')->with('errors',$e->getMessage());
        }
        if($request->ajax())
            return response()->json(array('success' => true, 'msg' => 'Объявление полностью удалено'), 200);

        return redirect()->route('admin.article.index')->with('success', 'Объявление полностью удалено');
    }


    public function search( Request $request ) {
        $search   = trim(strip_tags($request->get('q')));
        $articles = Article::where('title', 'LIKE', '%' . $search . '%')
            ->paginate(10);

        return view('admin.articles.index',

            [
                'articles' => $articles,
                'title'    => 'Результаты поиска'
            ]
        );
    }

    public   function autocomplete( Request $request ) {
        $search = trim(strip_tags($request->get('q')));

        //return response()->json($request->all());
        $res = DB::table('articles')
            ->where('title', 'LIKE', '%' . $search . '%')
            ->get();

        return response()->json($res);

    }




    public function postUp(Request $request){
        $articleId =trim(strip_tags($request->get('id')));
        $article = DB::table('articles')
            ->where('id', $articleId)
            ->first();


        if(Carbon::parse($article->up_post)->lt(Carbon::now())){
            DB::table('articles')
            ->where('id', $articleId)
            ->update(['up_post' => Carbon::now()->addMinutes(10)]);
            $response = 'Ваше объявление поднято';
        }else{
            $response = 'Поднять можно через ' .
                Carbon::parse($article->up_post)->diff(Carbon::now())->format('%h часов %i минут %s секунд');
        }

        return response()->json($response, 200);
    }


    public function restore($id, Request $request){
        try {
            $article = Article::onlyTrashed()->findOrFail($id);
            $article->restore();
            $request->session()->flash('notice', 'Объявление восстановлено');
        }catch (\Exception $e){
                return redirect()->route('profile.ads.index')->with('errors',$e->getMessage());
        }
        return redirect()->route('admin.article.index');
    }


    public function forceDelete($id, Request $request){
        try {
            $article = Article::onlyTrashed()->findOrFail($id);
            $article->forceDelete();
            $request->session()->flash('notice', 'Объявление безвозвратно удалено');
        }catch (\Exception $e){
            return redirect()->route('admin.article.index')->with('errors',$e->getMessage());
        }
        return redirect()->route('admin.article.index');
    }
}
