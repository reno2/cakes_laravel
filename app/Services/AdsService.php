<?php

namespace App\Services;

use App\Models\PostImage;
use App\Repositories\AdsRepository;
use App\Repositories\UserRepository;
use Exception;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Traits\UploadTrait;

class AdsService
{
    use UploadTrait;
    protected $article;
    protected $adsRepository;
    function checkFile($file, $article)
    {
        $name           = $file->getClientOriginalName();
        $fileUrl        = Storage::url('images/' . $name);
        $path           = 'public/images/' . $name;
        $postImageModel = new PostImage;
        // Проверяем существует ли файл с таким именем,
        // если да, то не создаём, а используем существующий
        if (!Storage::disk('public')->exists('images/' . $name)) {
            $image = Image::make($file)->fit(450, 750,
                    function ($constraint) {
                        $constraint->upsize();
                    }, 'center');
            $save = Storage::put($path, (string)$image->encode());
            if(!$save) $this->fail('не удалось созранить файл');
            $url = Storage::url($path);
        } else {
            $url = $fileUrl;
        }

        $postImageModel->article_id = $article->id;
        $postImageModel->name       = md5($name);
        $postImageModel->image_path = $url;
        if( !$postImageModel->save())
            $this->fail();


    }

    function chain($request, $article)
    {
        $this->article = $article;
        $this->adsRepository = new AdsRepository();
        if (isset($request['image']) && !is_null($request['image'])) {
            if (is_array($request['image'])) {
                foreach ($request['image'] as $file) {
                    //$this->checkFile($file, $article);
                    $this->uploadOne($file, $article->id);
                }
            } else {
                $this->uploadOne($request['image'], $article->id);
            }
        }

        if (isset($request['attrs']) && !empty($request['attrs'])):
            $this->setNewRelations('Attrs', $request['attrs'], $article);
        endif;

        if (isset($request['categories']) && !empty($request['categories'])):
            $this->setNewRelations('Categories', $request['categories'], $article);
        endif;

        if (isset($request['tags']) && !empty($request['tags'])):
            $this->setNewRelations('Tags', $request['categories'], $article);
        endif;


        return true;
    }

    function setNewRelations($name, $relation, $article = null){

        $method = 'setRelation' . $name;
            if(!$this->adsRepository->$method($relation, $article))
                $this->fail('Ошибка при создании связи');
    }

    function fail($msg = 'Ошибка сохранения файла'){
        throw new  \Exception($msg);
    }
}
