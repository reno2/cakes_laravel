<?php

namespace App\Http\Controllers\admin;

use App\Facades\Seometa;
use App\Models\Seo;
use App\Seo\SeometaFacade;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;



class SeoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function categoryIndex()
    {
        $category = Seo::where('type', 'category')->first();
        //SeometaFacade::setM('hello');
        return view('admin.seo.category.index', compact("category"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {

        Seo::create($request->all());
        return redirect()->route('admin.seo.index');
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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function categoryUpdate(Request $request)
    {
        $t = $request->all();
           unset($t['_token']);
       if($t['id'] && !empty($t['id'])){

           $r = Seo::where('id', $t['id'])->update($t);
           $rr = '';
       }else
        Seo::create($request->all());
        return redirect()->route('seo.category.index');
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
