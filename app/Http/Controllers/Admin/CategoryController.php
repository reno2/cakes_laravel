<?php

namespace App\Http\Controllers\Admin;

use App\Article;
use App\Category;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;
class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::paginate(10);
        //list
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $oo = Category::with('children')->where('parent_id', 0)->get();
        return view('admin.categories.create', [
            'category' => [],
            'categories' => Category::with('children')->where('parent_id', 0)->get(),
            'delimiter' => ''
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Category::create($request->all());
        return redirect()->route('admin.category.index');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Category $category
     * @param Request       $request
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category, Request $request)
    {

        if($request->get('sort')){
            $sort = $request->get('sort');
            $articles = $category->articles()->orderBy('sort', $sort)->paginate(12);
        }
        else{
            $articles = $category->articles()->orderBy('sort', 'desc')->orderBy('created_at', 'desc')->paginate(12);
        }

        //$articles = $category->articles()->paginate(12);

        return view('admin.categories.show', [
            'articles' => $articles,
            'category_name' => $category->title
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Category $category)
    {

        return view('admin.categories.edit', [
            'category' => $category,
            'categories' => Category::with('children')->where('parent_id', 0)->get(),
            'delimiter' => ''
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Category            $category
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Category $category)
    {
//        $category->update($request->except('slug'));

        $this->validate($request, [
            'slug' => Rule::unique('categories')->ignore($category->id, 'id'),
            'title' => 'required'
        ]);


        $category->update($request->all());
        session()->flash('message', "Категория  изменена");
        return redirect()->route('admin.category.index');
    }

    /**
     * Remove the specified resource from storage
     *
     * @param \App\Category $category
     * @return Illuminate\Http\Response
     * @throws Exception
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.category.index');
    }
}
