<?php

namespace App\Http\Controllers\Profile\Ads;

use App\Http\Requests\ProfileValidate;
use App\Http\Requests\AdsRequest;
use App\Http\Controllers\Controller;


use App\Models\Category;
use App\Repositories\UserRepository;
use App\Services\AdsService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Article;
use App\Repositories\AdsRepository;

class AdsController extends Controller
{


    protected $adsService;
    protected $adsRepository;

    public function __construct(AdsService $adsService, AdsRepository $adsRepository)
    {
        $this->adsService = $adsService;
        $this->adsRepository = $adsRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param UserRepository $userRepository
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $user           = Auth::user();
        $userRepository = new UserRepository();

        return view('profile.ads.index', [
            'user'    => $user,
            'ads' => $this->adsRepository->getAdsSortedDesc(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $tags = \App\Models\Tag::all();
        return view('profile.ads.switch_article', [
            'tags'       => $tags,
            'article'    => [],
            'categories' => Category::with('children')->where('parent_id', 0)->get(),
            'delimiter'  => ''
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AdsRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(AdsRequest $request)
    {
        $validated = $request->validated();
        $inputs = $request->all();
        $article = Article::create($request->except('image'));
        try{
            $this->adsService->chain($inputs, $article);
        }catch (\Exception $e){
            return back()->withErrors( $e->getMessage())->withInput();
        }
        return redirect()->route('profile.ads.index');

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit( $id)
    {
        $article = $this->adsRepository->getForEdit($id );
        //$r = Carbon::create($article->up_post);
        $tags = \App\Models\Tag::all();
        $tags2 = [];
       $rr =  $article->filterValues;
        foreach($tags as $tag){
            $tags2[$tag->id] = $tag->name;
        }
        return view('profile.ads.switch_article', [
            'article'    => $article,
            'categories' => Category::with('children')->where('parent_id', 0)->get(),
            'tags'       => $tags,
            'filter'     => $article->filterValues->pluck('id')->toArray(),
            'delimiter'  => '',
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int     $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
