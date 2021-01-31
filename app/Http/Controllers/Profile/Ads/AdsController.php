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
use Spatie\MediaLibrary\Models\Media;

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
        //$f = $this->adsRepository->getAdsImagesSortByMain();
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
            'ads'    => null,
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
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit( $id)
    {
        $ads = $this->adsRepository->getForEdit($id);


       // $f = $ads->media()->delete();
        //dd($f);
        //$ads->deleteMedia($f->id);
        $rrdd = '';
//        $media = Media::find($id);

//        $model_type = $media->model_type;
//
//        $model = $model_type::find($media->model_id);
//        $model->deleteMedia($media->id);



        $tags = \App\Models\Tag::all();
        $tags2 = [];
       $rr =  $ads->filterValues;
        foreach($tags as $tag){
            $tags2[$tag->id] = $tag->name;
        }
        $mediaItem =  Media::where('model_id', $ads->id)->whereJsonContains('custom_properties->main', true)->first();

        $mediaItem2 =  Media::where('model_id', $ads->id)->orderBy('custom_properties->main', 'desc')->get();




        return view('profile.ads.switch_article', [
            'main' => ($mediaItem->file_name) ?? '',
            'mediaItem2'=> $mediaItem2,
            'ads'    => $ads,
            'categories' => Category::with('children')->where('parent_id', 0)->get(),
            'tags'       => $tags,
            'filter'     => $ads->filterValues->pluck('id')->toArray(),
            'delimiter'  => '',
       ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $ads = Article::find($id);
        $inputs = $request->all();

        try{
            $this->adsService->uploadChain($inputs, $ads);
        }catch (\Exception $e){
            return back()->withErrors( $e->getMessage())->withInput();
        }
        return redirect()->route('profile.ads.index');


    }

    /**
     * Remove the specified resource from storage.
     *
     *
     * @param int
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $ads = Article::find($id);
        try{
           $this->adsService->removeAds($ads);
        }catch (\Exception $e){
            return redirect()->route('profile.ads.index')->with('errors',$e->getMessage());
        }
        return redirect()->route('profile.ads.index')->with('success','Объявление полностью удалено');

    }
}
