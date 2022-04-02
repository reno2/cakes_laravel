<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use App\Models\Category as Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\Models\Media;
use App\Models\Profile;


class CategoryRepository extends CoreRepository
{

    public function forFrontPage(){
        $categories = $this->startCondition()
                      ->where('published', '1')
                      ->orderBy('sort', 'asc')
                      ->orderBy('id', 'asc')
                      ->with('attachments')
                        ->whereHas('articles', function ($query){
                            $query->where('published', '1')->where('moderate', '1');
                        })
                      ->get();

        foreach ($categories as $category) {
            $imgFromDb = $category->attachments->first();
            $category->cover = $imgFromDb
                ? Storage::url($imgFromDb->url)
                : Storage::url("images/defaults/cake.svg") ;

        }
        return  $categories ?? [];
    }

    public function getAllActiveParentItems(){
        return $this->startCondition()
                    ->where('published', '1')
                    ->where('parent', '0')
                    ->orderBy('sort', 'asc')
                    ->get();
    }

    /*
   * @return string
   */
    protected function getModelClass()
    {
        return Model::class;
    }




}
