<?php

namespace App\Http\Controllers\Admin\Seo;

use \App\Http\Controllers\Admin\Seo\SeoAbstractController;
use App\Http\Requests\SeoCategoryRequest;
use App\Models\Seo as MSeo;
use Illuminate\Http\Request;

class SeoTagController extends SeoAbstractController{

    public function __construct(MSeo $model, SeoCategoryRequest $request)
    {
        $this->model = $model;
    }

    public function updateTag(SeoCategoryRequest $request)
    {
        if($request->has('id') && !empty($request->input('id')))
            return parent::update($request);
        else
            return parent::create($request);
    }

    public function get(){
        $tag = MSeo::where('type', 'tag')->first();
        return view('admin.seo.tag.index', compact("tag"));
    }



}
