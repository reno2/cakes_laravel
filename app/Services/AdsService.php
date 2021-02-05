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
    protected $request;

    public function removeAds($article){
        $this->adsRepository = new AdsRepository();

        if(!$this->adsRepository->removeFilterValName($article))
            $this->fail('Ошибка при удалении связи');

        if(!$this->adsRepository->removeRelationCategories($article))
            $this->fail('Ошибка при удалении связи');

        if(!$this->adsRepository->removeRelationTags($article))
            $this->fail('Ошибка при удалении связи');

        if(!$this->deleteAllElementMedia($article))
            $this->fail('Ошибка при удалении связи картинок');

        if(!$this->adsRepository->removeArticle($article))
            $this->fail('Ошибка при удалении связи');


    }

    public function chain($request, $article)
    {
        $this->article = $article;
        $this->adsRepository = new AdsRepository();
        $this->request = $request;

        $this->prepareImages();

        if (isset($request['attrs']) && !empty($request['attrs'])):
            $this->setNewRelations('Attrs', $request['attrs'], $article);
        endif;

        if (isset($request['categories']) && !empty($request['categories'])):
            $this->setNewRelations('Categories', $request['categories'], $article);
        endif;

        if (isset($request['tags']) && !empty($request['tags'])):
            $this->setNewRelations('Tags', $request['tags'], $article);
        endif;


        return true;
    }

    function setNewRelations($name, $relation, $article = null){
        $method = 'setRelation' . $name;
            if(!$this->adsRepository->$method($relation, $article))
                $this->fail('Ошибка при создании связи');
    }

    function fail($msg = 'Ошибка сохранения файла'){
        throw new \Exception($msg);
    }


    function uploadChain($request, $article){
        $this->article = $article;
        $this->adsRepository = new AdsRepository();
        $this->request = $request;

        $update = $article->update($request);

        $this->adsRepository->removeRelationCategories($article);
        $this->adsRepository->removeRelationTags($article);
        $this->adsRepository->removeRelationTags($article);

        if (isset($request['attrs']) && !empty($request['attrs'])):
            $this->setNewRelations('Attrs', $request['attrs'], $article);
        endif;

        if (isset($request['categories']) && !empty($request['categories'])):
            $this->setNewRelations('Categories', $request['categories'], $article);
        endif;

        if (isset($request['tags']) && !empty($request['tags'])):
            $this->setNewRelations('Tags', $request['tags'], $article);
        endif;

        $this->prepareImages();

        return true;
    }
}
