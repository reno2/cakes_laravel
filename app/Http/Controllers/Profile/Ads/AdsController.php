<?php

namespace App\Http\Controllers\Profile\Ads;

use App\Http\Requests\ProfileValidate;
use App\Http\Requests\AdsRequest;
use App\Http\Controllers\Controller;


use App\Models\Category;
use App\Models\User;
use App\Notifications\PostCreatedNotification;
use App\Repositories\ProfileRepository;
use App\Repositories\UserRepository;
use App\Services\AdsService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Article;
use App\Repositories\AdsRepository;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Notification;
use Spatie\MediaLibrary\Models\Media;

class AdsController extends Controller
{


    protected $adsService;
    protected $adsRepository;
    protected $userRepository;

    public function __construct(AdsService $adsService, AdsRepository $adsRepository, UserRepository $userRepository)
    {
        $this->adsService = $adsService;
        $this->adsRepository = $adsRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param ProfileRepository $profileRepository
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(ProfileRepository $profileRepository)
    {

        $user = Auth::user();
        $profile = $profileRepository->getFirstProfileByUser(Auth::id());
        $favorites_profile = $profileRepository->getFavoritesArray($profile->id);
        $where = [
            ['user_id', Auth::id()],
            ['moderate', '=', 1],
            ['published', '=', 1]
        ];
        $notPublished = [
            ['user_id', Auth::id()],
            ['moderate', '=', 1],
            ['published', '=', 0]
        ];
        $adsOnModerate = [
            ['user_id', Auth::id()],
            ['moderate', '=', 0],
        ];
        return view('profile.ads.index', [
            'user'    => $user,
            'ads' => $this->adsRepository->getByCurrentProfileAdsSortedDesc($where),
            'adsNotPublished' => $this->adsRepository->getByCurrentProfileAdsSortedDesc($notPublished),
            'adsOnModerate' =>  $this->adsRepository->getByCurrentProfileAdsSortedDesc($adsOnModerate),
            'favorites_cookies' => json_decode(Cookie::get('favorites')),
            'favorites_profile' => $favorites_profile
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('profile.ads.switch_article', [
            'tags'       => \App\Models\Tag::all(),
            'ads'    => null,
            'categories' => Category::with('children')->where('parent_id', 0)->get(),
            'delimiter'  => '',
            'profile' =>  $this->userRepository->getUserProfileEdit(Auth::id()) ?? null
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
        $article = Article::create(array_merge($request->except('image'), ['user_id' => Auth::id()]));
        try{
            $this->adsService->chain($inputs, $article);
            session()->flash('notice', "Объявление создано и отправлено на модерацию");
        }catch (\Exception $e){
            return back()->withErrors( $e->getMessage())->withInput();
        }
        return redirect()->to(route('profile.ads.index').'#moderate');

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
        $tags = \App\Models\Tag::all();
        $tags2 = [];
       $rr =  $ads->filterValues;
        foreach($tags as $tag){
            $tags2[$tag->id] = $tag->name;
        }
        $mediaItem =  Media::where('model_id', $ads->id)->whereJsonContains('custom_properties->main', true)->first();

        //$mediaItem2 =  Media::where('model_id', $ads->id)->orderBy('custom_properties->main', 'desc')->get();


        return view('profile.ads.switch_article', [
            'main' => ($mediaItem->file_name) ?? '',
            'mediaFiles'=> $this->adsRepository->getAdsImages($ads->id),
            'ads'    => $ads,
            'categories' => Category::with('children')->where('parent_id', 0)->get(),
            'tags'       => $tags,
            'filter'     => $ads->filterValues->pluck('id')->toArray(),
            'delimiter'  => '',
            'profile' => $this->adsRepository->getUserProfileFirst($ads)
       ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AdsRequest $request
     * @param Article    $ads
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(AdsRequest $request, $id)
    {

        $validated = $request->validated();
        $ads = Article::find($id);
        $inputs = $request->all();

        try{
            $this->adsService->uploadChain($inputs, $ads);
            session()->flash('notice', "Объявление обновленно и отправлено на модерацию");
        }catch (\Exception $e){
            return back()->withErrors( $e->getMessage())->withInput();
        }
        return redirect()->route('profile.ads.index');


    }

    /**
     * Remove the specified resource from storage.
     * @param int
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id, Request $request)
    {
        $ads = Article::find($id);
        try{
           $ads->favoritesProfiles()->detach();
           $this->adsService->removeAds($ads);
        }catch (\Exception $e){
            if($request->ajax())
                return response()->json(array('success' => false), 500);
            return redirect()->route('profile.ads.index')->with('errors',$e->getMessage());
        }
        if($request->ajax())
            return response()->json(array('success' => true, 'msg' => 'Объявление полностью удалено'), 200);

        return redirect()->route('profile.ads.index')->with('success', 'Объявление полностью удалено');
    }

}
