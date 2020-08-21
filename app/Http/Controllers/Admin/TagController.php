<?php

namespace App\Http\Controllers\Admin;


use App\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Mockery\Exception;
use Session;

class TagController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Tag $tagEdit)
    {
        //	dd($tagEdit);
        $tags = Tag::paginate(10);

        return view('admin.tags.index', compact('tags'));

    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {

        return view('admin.tags.create', [
            'tag'=> []
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
//        $this->validate($request, [
//            'name' => 'required|max:255'
//        ]);
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:6'
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $res = $request->except('tags');
        $res['important'] =$request->input('important') ? true : false;

        try
        {
            $tag= Tag::create($res);
            if($request->input('tags')):
               $tag->articles()->attach($request->input('tags'));
            endif;

            //Session::flash('success', 'тег создан');
            return redirect()->route('admin.tags.index');

        }catch(Exception $exception){
            session()->flash('message', $exception->getMessage());
            return redirect()->route('admin.tag.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {
        return view('admin.tags.show', compact('tag'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Tag $tag)
    {
        $articles = $tag->articles;
        return view('admin.tags.edit', compact('tag', 'articles'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Tag                      $tag
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Tag $tag)
    {
        $y = '';
        $this->validate($request, [
            'slug' => Rule::unique('tags')->ignore($tag->id, 'id'),
            'name' => 'required'
        ]);
        $r = $request->except('tags');
        $t =$request->input('important');
        $r['important'] = ($request->input('important')) ? true : false;
        try{

            $update = $tag->update($r);
            //Articles
            $tag->articles()->detach();
            if ($request->input('tags')):
                $tag->articles()->attach($request->input('tags'));
            endif;
            session()->flash('message', "Тег  изменен " . $tag->name);
            return redirect()->route('admin.tags.index');
        }catch (Exception $exception){
            session()->flash('message', $exception->getMessage());
            return redirect()->route('admin.tags.index');
        }
       // return redirect()->route('admin.tags.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        if($tag->articles())
            $tag->articles()->detach();
        $tag->delete();
        return redirect()->route('admin.tags.index');
    }
}
