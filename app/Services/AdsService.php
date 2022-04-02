<?php

namespace App\Services;


use App\Events\AdsModerate;
use App\Models\Article;
use App\Models\Moderate;
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


    public function __construct(AdsRepository $adsRepository){
        $this->adsRepository = $adsRepository;
    }

    public function getAllForEdit ($request) {

        $sorts = ['moderate', 'published', 'on_front', 'updated_at'];
        $sortParam = null;
        $sortType = null;
        $deleted = false;
        foreach ($sorts as $sort){
            if($request->get($sort)) {
                $sortParam = $sort;
                $sortType = $request->get($sort) ?? 'desc';
                break;
            }
        }

        if($request->get('with_deleted')){
            $deleted = true;
        }
        $articles = $this->adsRepository->allForEditWithPaginateAndSort($sortParam, $sortType, $deleted);


        foreach ($articles as $article) {
            // Категории
            $article->categoryName = $article->categories->pluck('title')->first() ?? NULL;
            $article->userEmail = $article->user->email;
            // Если ест теги то добавляем
            $article->tagsNames = $article->tags ? implode(', ', $article->tags->pluck('title')->all()) : NULL;
            $src = Media::where('model_id', $article->id)
                        ->whereJsonContains('custom_properties->main', true)
                        ->first();
            $article->image = $src
                ? $src->getUrl('thumb')
                : helper_returnFakeImg('admin_ads');
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


    function uploadChain ($requestArray, $article, $isAdminPage) {


        $this->article = $article;
        $this->adsRepository = new AdsRepository();
        $this->request = $requestArray;

        $isImgChange = $this->prepareImages();

        $needModerate = $this->moderateStatus($requestArray, $article, $isAdminPage, $isImgChange);

        if((int)$needModerate === 200) {
            $requestArray['moderate'] = 0;
        }
        $update = $article->update($requestArray);




        $this->adsRepository->removeRelationCategories($article);
        $this->adsRepository->removeRelationTags($article);
        $this->adsRepository->removeRelationTags($article);

        if (isset($requestArray['attrs']) && !empty($requestArray['attrs'])):
            $this->setNewRelations('Attrs', $requestArray['attrs'], $article);
        endif;

        if (isset($requestArray['categories']) && !empty($requestArray['categories'])):
            $this->setNewRelations('Categories', $requestArray['categories'], $article);
        endif;

        if (isset($requestArray['tags']) && !empty($requestArray['tags'])):
            $this->setNewRelations('Tags', $requestArray['tags'], $article);
        endif;

        return $needModerate;

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
        if($this->article->moderate == 0) {
            return $this->article->not_need_moderate;
        }

        // Проверяем изменения ли категория или картинка
        $adsCat = $this->article->categories->pluck('id')->toArray();
        $catDiff = $adsCat == $this->request['categories'][0];


        $needModerate = false;
        if ($catDiff || $isImgChange) {
            return $this->article->need_moderate;
        } else {

            $oldValues = $this->article->getAttributes();
            foreach ($this->article->toModerate as $field) {

                $checkVal = $this->request[$field];

                if ($field === 'published') {
                    $checkVal = intval($this->request[$field]);
                }

                if ($field === 'price') {
                    $checkVal = floatval($this->request[$field]);
                }


                if ($oldValues[$field] !== $checkVal) {
                    return $this->article->need_moderate;
                }

            }
        }
        return $this->article->not_need_moderate;
    }

    private function moderateStatus ($requestArray, $article, $isAdminPage, bool $imgIsNotChange) {

        // Проверяем требуется ли модерация если это не админка
        if (!$isAdminPage) {
            return $this->onModerate($imgIsNotChange);
        }


        // Если раздел админки
        if ($requestArray['moderate'] == 1) {
            if ($article->moderateComments()->exists()) {
                $article->moderateComments()->first()->settings()->detach();
                $article->moderateComments()->detach();
            }
            event(new AdsModerate($article, []));
            return 1;
        }

        $moderateItem = Moderate::updateOrCreate(
            ['id' => $requestArray['moderate_id']],       // Фильтр
            ['message' => $requestArray['moderate_text']] // Колонки которые будет обновлены
        );

        $moderateItem->settings()->sync($requestArray['rule'] ?? []);
        $article->moderateComments()->sync($moderateItem->id);


        event(new AdsModerate($article, $moderateItem));
        return 0;
    }



}
