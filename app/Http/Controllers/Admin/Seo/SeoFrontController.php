<?php

namespace App\Http\Controllers\Admin\Seo;

use \App\Http\Controllers\Admin\Seo\SeoAbstractController;
use App\Http\Requests\SeoCategoryRequest;
use App\Models\Seo as MSeo;
use Illuminate\Http\Request;

class SeoFrontController extends SeoAbstractController{

    public function __construct(MSeo $model, SeoCategoryRequest $request)
    {
        $this->model = $model;
    }

    public function updateFront(SeoCategoryRequest $request)
    {
        if($request->has('id') && !empty($request->input('id')))
            return parent::update($request);
        else
            return parent::create($request);
    }

    public function get(){
        $front = MSeo::where('type', 'front')->first();
        return view('admin.seo.front.index', compact("front"));
    }



}
