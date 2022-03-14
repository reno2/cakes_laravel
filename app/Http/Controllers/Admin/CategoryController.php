<?php

namespace App\Http\Controllers\Admin;


use App\Http\Requests\AdsRequest;
use App\Http\Requests\CategoryRequest;
use App\Models\Article;
use App\Models\Category;
use App\Services\CategoryService;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{

    public $categoryService;

    public function __construct () {
        $this->categoryService = new CategoryService();
        $this->middleware('auth');
    }



    public function index () {
        try {
            $categories = $this->categoryService->getAll();
            return view('admin.categories.index', compact('categories'));
        } catch (\Mockery\Exception $exception) {

        }
    }


    public function create () {
        return view('admin.categories.create', [
            'category' => [],
            'categories' => Category::with('children')->where('parent_id', 0)->get(),
            'delimiter' => '',
        ]);
    }


    public function store (CategoryRequest $request) {

        try {

            $this->categoryService->createCategory($request);
            return redirect()->route('admin.category.index');

        } catch (\Exception $e) {
            return back()->withErrors( $e->getMessage())->withInput();
        }

    }

    /**
     * Display the specified resource.
     *
     * @param \App\Category $category
     * @param Request $request
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show (Category $category, Request $request) {

        if ($request->get('sort')) {
            $sort = $request->get('sort');
            $articles = $category->articles()->orderBy('sort', $sort)->paginate(12);
        } else {
            $articles = $category->articles()->orderBy('sort', 'desc')->orderBy('created_at', 'desc')->paginate(12);
        }

        //$articles = $category->articles()->paginate(12);

        return view('admin.categories.show', [
            'articles' => $articles,
            'category_name' => $category->title,
        ]);
    }


    public function edit (Category $category) {


        $category = $this->categoryService->getForEdit($category);

        return view('admin.categories.edit', [
            'category' => $category,
            'categories' => Category::with('children')->where('parent_id', 0)->get(),
            'delimiter' => '',
        ]);
    }


    public function update (CategoryRequest $request, Category $category) {

        try {
            $this->categoryService->updateCategory($category, $request);
            session()->flash('message', "Категория  изменена");
        }catch (\Exception $e){
            return back()->withErrors( $e->getMessage())->withInput();
        }
        return redirect()->route('admin.category.index');
    }


    public function destroy (Category $category) {
        try {
            $this->categoryService->deleteFilesAndRelation($category);
        }catch (\Exception $e){
            return back()->withErrors( $e->getMessage())->withInput();
        }
        return redirect()->route('admin.category.index');
    }
}
