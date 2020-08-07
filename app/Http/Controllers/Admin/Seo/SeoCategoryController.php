<?php

namespace App\Http\Controllers\Admin\Seo;

use \App\Http\Controllers\Admin\Seo\SeoAbstractController;
use App\Http\Requests\SeoCategoryRequest;
use App\Seo as MSeo;
use Illuminate\Http\Request;

class SeoCategoryController extends SeoAbstractController{

    public function __construct(MSeo $model, SeoCategoryRequest $request)
    {
        $this->model = $model;
    }

    public function updateCategory(SeoCategoryRequest $request)
    {
        if($request->has('id') && !empty($request->input('id')))
            return parent::update($request);
         else
             return parent::create($request);
    }

    public function get(){

        $category = MSeo::where('type', 'category')->first();
        return view('admin.seo.category.index', compact("category"));
    }



}
