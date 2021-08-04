<?php
namespace App\Http\Controllers\Admin\Seo;

use App\Models\Seo;
use Illuminate\Http\Request;

abstract class SeoAbstractController
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Model
     */
    protected $model;

    public function create(Request $request){
        $this->model::create($request->except('_token'));
        return redirect()->route('seo.category.index');
    }

    public function update(Request $request){
       $id=  $request->input('id');
       $r = $this->model::where('id', $id)->update($request->except('_token'));
        $route = implode('.', ['seo', $request->type, 'index']);
        return redirect()->route($route);
    }

    public function delete(){

    }
}
