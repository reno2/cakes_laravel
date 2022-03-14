<?php

namespace App\Services;


use App\Models\Article;
use App\Models\PostImage;
use App\Repositories\AdsRepository;
use App\Repositories\UserRepository;
use Exception;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use App\Traits\UploadTrait;
use Spatie\MediaLibrary\Models\Media;

class AdsService
{
    use UploadTrait;
    protected $article;
    protected $adsRepository;
    protected $request;


    public function getAllForEdit ($request) {

        if ($request->get('sort')) {
            $sort = $request->get('sort');
            $articles = Article::orderBy('sort', $sort)
                               ->with('media', 'tags')
                               ->paginate(10);
        } else {
            $articles = Article::orderBy('sort', 'asc')
                               ->orderBy('id', 'desc')
                               ->with('media', 'tags')
                               ->paginate(10);
        }

        foreach ($articles as $article) {
            // Категории
            $article->categoryName =  $article->categories->pluck('title')->first() ?? null;
            $article->userEmail = $article->user->email;
            // Если ест теги то добавляем
            $article->tagsNames = $article->tags ? implode(', ', $article->tags->pluck('title')->all()) : NULL;
            $src = Media::where('model_id', $article->id)
                        ->whereJsonContains('custom_properties->main', true)
                        ->first();
            $article->image = $src
                ? $src->getUrl('thumb')
                : Storage::url("images/defaults/cake.svg");
        }

        return $articles;
    }

    public function removeAds ($article) {
        $this->adsRepository = new AdsRepository();

        if (!$this->adsRepository->removeFilterValName($article)) {
            $this->fail('Ошибка при удалении связи');
        }

        if (!$this->adsRepository->removeRelationCategories($article)) {
            $this->fail('Ошибка при удалении связи');
        }

        if (!$this->adsRepository->removeRelationTags($article)) {
            $this->fail('Ошибка при удалении связи');
        }

        if (!$this->deleteAllElementMedia($article)) {
            $this->fail('Ошибка при удалении связи картинок');
        }

        if (!$this->adsRepository->removeArticle($article)) {
            $this->fail('Ошибка при удалении связи');
        }


    }

    public function chain ($request, $article) {
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

    function setNewRelations ($name, $relation, $article = NULL) {
        $method = 'setRelation' . $name;
        if (!$this->adsRepository->$method($relation, $article)) {
            $this->fail('Ошибка при создании связи');
        }
    }

    function fail ($msg = 'Ошибка сохранения файла') {
        throw new \Exception($msg);
    }


    function uploadChain ($request, $article, $isAdminPage) {

        //$oldValues = $article->getAttributes();
        $this->article = $article;
        $this->adsRepository = new AdsRepository();
        $this->request = $request;

        $imgIsChange = $this->prepareImages();

        // Если раздел админки
        if($isAdminPage) {
            $request['moderate'] = isset($request['moderate']) ? 1 : 0;
            $needModerate = (bool)$request['moderate'];
        }

        // Если это раздел админки то пропускаем проверку
        if(!$isAdminPage) {
            $needModerate = $this->onModerate($imgIsChange);
            if ($needModerate) $request['moderate'] = 0;
        }

        $update = $article->update($request);

        //  $isTagsCatsChange = ($catDiff && $tagsDiff) ? false : true;


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

        return $needModerate;
        //$imgIsChange = $this->prepareImages();

        //return $this->onModerate($request, $imgIsChange, $isTagsCatsChange, $oldValues);
    }


    /**
     * Сравнивает поля для проверки на изменения из новых данных со старыми
     * И отправляет на модерацию
     * @param $request - obj Объект реквеста
     * @param $isImgChange - bool Изменены ли картинки
     * @param $isTagsCatsChange - bool состояние false если или теги или категории изменены и нужно отправять на модерацию
     * @param $oldValues
     * @return bool
     */
    public function onModerate ($isImgChange) {

        $adsCat = $this->article->categories->pluck('id')->toArray();
        //$adsTags = $this->article->tags->pluck('id')->toArray();
        //$tagsDiff = $adsTags == $this->request['tags'];
        $catDiff = $adsCat == $this->request['categories'];
        $isCatsChange = ($catDiff) ? false : true;

        $needModerate = false;
        if ($isCatsChange || $isImgChange) {
            $needModerate = true;
        } else {

            $oldValues = $this->article->getAttributes();
            foreach ($this->article->toModerate as $field) {

                if (in_array($field, ['tags', 'categories'])) continue;

                if ($field === 'price') {
                    $checkVal = floatval($this->request[$field]);
                } else {
                    if ($field === 'published') {
                        $checkVal = intval($this->request[$field]);
                    } else {
                        $checkVal = $this->request[$field];
                    }
                }

                if ($oldValues[$field] !== $checkVal) {
                    $needModerate = true;
                }

            }
        }
        return $needModerate;
    }

}
