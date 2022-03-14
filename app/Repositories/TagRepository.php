<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;
use App\Models\Tag as Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\Models\Media;
use App\Models\Profile;


class TagRepository extends CoreRepository
{
    public function allWithAds(){
        $tags =  $this->startCondition()
                    ->orderBy('sort', 'asc')
                    ->orderBy('id', 'asc')
                    ->where('published', '1')
                    ->whereHas('articles')
                    ->with('attachments')
                    ->get();
        foreach ($tags as $tag) {
            $imgFromDb = $tag->attachments->first();
            $tag->cover = $imgFromDb
                ? Storage::url($imgFromDb->url)
                : Storage::url("images/defaults/cake.svg") ;

        }
        return  $tags ?? [];
    }

    protected function getModelClass () {
        return \App\Models\Tag::class;
    }
}