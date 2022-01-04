<?php

namespace App\Traits;

use App\Models\PostImage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\Models\Media;

trait UploadTrait
{
    // Подготавливаем файлы для добавления и удаления
    public function prepareImages()
    {
        $change = false;

        (!empty($this->request['main_image'])) ? $mainImg = $this->request['main_image'] : $mainImg = false;
        (!empty($this->request['main'])) ? $mainDb = $this->request['main'] : $mainDb = false;

        if (isset($this->request['image']) && !is_null($this->request['image'])) {
            $change = true;
            if (is_array($this->request['image'])) {
                foreach ($this->request['image'] as $file) {
                    $this->addToMedia($file, $mainImg);
                }
            } else {
                $this->addToMedia($this->request['image'][0], $mainImg);
            }
        }



        // проверчем что есть картинки чтобы изменить главную
        if (isset($this->request['image']) || $mainImg){
            if (!$mainImg && !$mainDb) {
                // когда загрузили и не указали главную при создании
                $this->setFirstAsMain();
            } elseif ($mainImg && !$mainDb) {
                //dd("Создали выбрали но нет в базе");
                $this->setAsMain($mainImg);
            } elseif ($mainImg != $mainDb) {
                //Выбрали есть в базе, но отличаются";
                $this->removeAsMain();
                $this->setAsMain($mainImg);
            }
            $change = true;
        }

        if (!empty($this->request["remove"])) {
            $change = true;
            $this->deleteMediaItem(json_decode($this->request["remove"]));
        }

        // Если картинка была изменена то отправляем на модерацию
        if($change){
            return true;
        }
        else{
            return false;
        }
    }

    public function removeAsMain()
    {
        $oldMain = Media::where('model_id', $this->article->id)->whereJsonContains('custom_properties->main',
            true)->first();
        if ($oldMain->id) {
            $oldMain->order_column += 1;
            $oldMain->update(['custom_properties->main' => '']);
        }
    }

    public function setFirstAsMain()
    {
        $newMain = Media::where('model_id', $this->article->id)->first();
        if ($newMain->id) {
            $newMain->update(['custom_properties->main' => true]);
        }
    }

    public function setAsMain($mainImg)
    {
        $newMain = Media::where('model_id', $this->article->id)->where('file_name', $mainImg)->first();
        if ($newMain->id) {
            $newMain->order_column = 1;
            $y = $newMain->update(['custom_properties->main' => true]);
        }else{
            dd($newMain);
        }
    }

    // Добавляем файл в коллекцию
    public function addToMedia($file, $main)
    {
        $name = md5($file->getClientOriginalName()) . '.' . $file->getClientOriginalExtension();
        $this->article->addMedia($file)
            ->usingFileName($name)
            ->toMediaCollection('cover');
    }

    // Удаляем файлы переданные в запросе
    public function deleteMediaItem($items)
    {
        $images = $this->article->getMedia('cover');
        foreach ($images as $img) {
            if (in_array($img->id, $items)) {
                $img->delete();
            }
        }

    }

    // Удаление всех заисей и файлов связанной модели
    public function deleteAllElementMedia($article)
    {

        if($article->hasMedia())
            $article->forceDelete();
        return true;
    }

}
