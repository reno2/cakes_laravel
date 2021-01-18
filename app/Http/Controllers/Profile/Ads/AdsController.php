<?php

namespace App\Http\Controllers\Profile\Ads;

use App\Http\Requests\ProfileValidate;
use App\Http\Requests\AdsRequest;
use App\Http\Controllers\Controller;


use App\Models\Category;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Article;

class AdsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param UserRepository $userRepository
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        $userRepository = new UserRepository();
        return view('profile.ads.index', [
            'user'    => $user,
            'profile' => $userRepository->getUserProfileEdit($user->id)
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
     * @param  AdsRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(AdsRequest $request)
    {
        $validated = $request->validated();
        $inputs             = $request->all();
        dd($inputs);
       // dd($inputs);
        // Валидируем поля
       // $validated = $request->validated();

        $rr = '';
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int    $id
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
