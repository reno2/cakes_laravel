<?php
namespace App\Http\Controllers\Admin\Seo;

use App\Models\Seo;
use Illuminate\Database\Eloquent\Model;
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
        $type = $request->input('type');
        return redirect()->route("seo.{$type}.index");
    }

    public function update(Request $request){
       $id=  $request->input('id');
       $type = $request->input('type');
       $this->model::where('id', $id)->update($request->except('_token'));
       return redirect()->route("seo.{$type}.index");
    }

    public function delete(){

    }
}
