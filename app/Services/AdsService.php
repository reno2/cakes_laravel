<?php

namespace App\Services;


use App\Events\AdsModerate;
use App\Models\Article;
use App\Models\Moderate;
use App\Models\PostImage;
use App\Repositories\AdsRepository;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Support\Facades\Auth;
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


    public function __construct (AdsRepository $adsRepository) {
        $this->adsRepository = $adsRepository;
    }

    public function getAllForEdit ($request) {

        $sorts = ['published', 'on_front', 'updated_at'];
        $sortParam = NULL;
        $sortType = NULL;

        foreach ($sorts as $sort) {
            if ($request->get($sort)) {
                $sortParam = $sort;
                $sortType = $request->get($sort) ?? 'desc';
                break;
            }
        }
        $filters = ['with_deleted', 'moderate'];
        $filter = null;
        foreach ($filters as $fill) {
            if ($request->get($fill)) {
                $filter = $fill;
                break;
            }
        }


        $articles = $this->adsRepository->allForEditWithPaginateAndSort($sortParam, $sortType, $filter);


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

    public function chain ($request) {

        $extraData = [
            'user_id' => Auth::id(),
            'moderate' => isset($request['moderate']) ? 1 : 0,
            'sort' => $request['sort'] ?? 100,
        ];
        $newAds = array_merge($request, $extraData);

        $this->setDeal($newAds);
        unset($newAds['image']);

        $article = Article::create($newAds);


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


    public function setDeal(&$inputsArray){
        $inputsArray['deal'] = $inputsArray['price'] ? 0 : 1;
    }

    function uploadChain ($requestArray, $article, $isAdminPage) {

        $this->article = $article;
        $this->adsRepository = new AdsRepository();
        $this->request = $requestArray;

        $sendToModerate = $this->sentToModerate($isAdminPage);
        if($sendToModerate){
            $requestArray['moderate'] = 0;
        }

       $this->setDeal($requestArray);


        $moderateBefore = $article->moderate;
        $updatedAds = tap($article)->update($requestArray);

        if($isAdminPage) $this->fireModerateEvent($requestArray, $moderateBefore);

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

        return $sendToModerate;

    }




    /**
     * Сравнивает поля для проверки на изменения из новых данных со старыми
     * И отправляет на модерацию
     * @param $requestArray
     * @param $moderateBefore
     * @return void
     */
    public function fireModerateEvent ($requestArray, $moderateBefore) {

            if ($requestArray['moderate'] == 1 && $moderateBefore == 0) {
                if ($this->article->moderateComments()->exists()) {
                    $this->article->moderateComments()->first()->settings()->detach();
                    $this->article->moderateComments()->detach();
                }

                // выбрасываем событие о пройденой модерации
                event(new AdsModerate($this->article, []));
            }

            // Если валидация не пройдена и заполнен коммент или отмеченно правило
            if ($requestArray['moderate'] == 0
               // && ($requestArray['moderate_text'] || isset($requestArray['rule']))
            ) {

                $moderateItem = Moderate::updateOrCreate(
                    ['id' => $requestArray['moderate_id']],       // Фильтр
                    ['message' => $requestArray['moderate_text']] // Колонки которые будет обновлены
                );

                $moderateItem->settings()->sync($requestArray['rule'] ?? []);
                $this->article->moderateComments()->sync($moderateItem->id);

                // выбрасываем событие о непройденой модерации
                event(new AdsModerate($this->article, $moderateItem));
            }

    }

    public function sentToModerate($isAdminPage){

        // Получаем старые значения
        $oldValues = $this->article->getAttributes();

        // Проверяем изменени ли картинка
        $isImgChange = $this->prepareImages();

        // Модерация не требуется
        if ($this->article->moderate == 0) {
            return false;
        }

        // Модерация не требуется, так админ ничего не изменил
        if ($isAdminPage && $this->article->moderate === $oldValues['moderate']) {
            return false;
        }




        // Проверяем изменения ли категория или картинка
        $adsCat = $this->article->categories->pluck('id')->toArray();
        $catDiff = $adsCat == $this->request['categories'][0];


        // Модерация требуется
        if ($catDiff || $isImgChange) {
            return true;
        }


        foreach ($this->article->toModerate as $field) {

            $checkVal = $this->request[$field];

            if ($field === 'published') {
                $checkVal = intval($this->request[$field]);
            }

            if ($field === 'price') {
                $checkVal = floatval($this->request[$field]);
            }

            // Модерация требуется
            if ($oldValues[$field] !== $checkVal) {
                return true;
            }

        }

        // Модерация не требуется
        return false;
    }


}
