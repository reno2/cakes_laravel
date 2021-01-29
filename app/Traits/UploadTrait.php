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
    public function prepareImages(){
        (!empty($this->request['main_image'])) ? $main = $this->request['main_image'] : $main = false;

        if (isset($this->request['image']) && !is_null($this->request['image'])) {

            if (is_array($this->request['image'])) {
                foreach ($this->request['image'] as $file) {
                    $this->addToMedia($file, $main);
                }
            } else {
                $this->addToMedia($this->request['image'], $main);
            }
        }
        if(!empty($this->request["remove"])){
            $this->deleteMediaItem(json_decode($this->request["remove"]));
        }

        if(!empty($this->request["old_files"]) && $main && in_array($main, $this->request["old_files"])){
           // $this->changeMain($main);
//            $oldMain = Media::where('model_id', $this->article->id)->whereJsonContains('custom_properties->main', true)->get();
//            $oldMain[0]->update(['custom_properties->main' => '']);
//            $newMain = Media::find($main)->setCustomProperty('main', true)->save();
        }
    }

   // Изменяем главную
    public function changeMain($main){
        $oldMain = Media::where('model_id', $this->article->id)->whereJsonContains('custom_properties->main', true)->get();
        if(!$oldMain->isEmpty())
            $oldMain[0]->update(['custom_properties->main' => '']);

        $newMain = Media::where('file_name', $main)->first();
        if(!$newMain->isEmpty())
            $rr = $newMain->custom_properties;
        //$newMain->update(['custom_properties' => json_encode((object) ['main' => false]) ]);
           // ->setCustomProperty('main', true)->save();
        $rrg = '';
        //$newMain;
    }

    // Добавляем файл в коллекцию
    public function addToMedia($file, $main){
        $name = md5($file->getClientOriginalName()) .'.'. $file->getClientOriginalExtension();
        if($main && $name == $main) {
            //$r = Media::where('model_type','App\Article')->whereJsonContains('custom_properties->main', true)->get();
            $this->article->addMedia($file)
                ->usingFileName($name)
                ->withCustomProperties(['main' => true])
                ->toMediaCollection('cover');


        }else{
            $this->article->addMedia($file)
                ->usingFileName($name)
                ->toMediaCollection('cover');
        }
    }

    // Удаляем файлы переданные в запросе
    public function deleteMediaItem($items){
        $images  = $this->article->getMedia('cover');
        foreach($images as $img)
            if(in_array($img->id, $items)) $img->delete();

    }




//    public function uploadOne($file, $adsId)
//    {
//        $name           = $file->getClientOriginalName();
//        $folders        = [
//            'big' => 'images/' . $adsId . '/big_' . $name,
//            'small' => 'images/' . $adsId . '/small_' . $name
//        ];
//        $sizes = [
//            'big' => [350, 750, 'center'],
//            'small' => [250, 250, 'center']
//        ];
//        $adsImageModel = new PostImage;
//        $adsImageModel->article_id = $adsId;
//        $adsImageModel->name = $name;
//
//        foreach ($folders as $key => $folder) {
//            if (!Storage::disk('public')->exists($folder)) {
//                $this->fileCrop($file, $sizes[$key], $folder);
//                $url = Storage::url($folder);
//                $adsImageModel->$key = $url;
//            }
//        }
//        if( !$adsImageModel->save())
//            $this->fail();
//    }
//
//
//
//    public function fileCrop($file, $sizes, $path)
//    {
//        $image = Image::make($file)->fit($sizes[0], $sizes[1],
//            function ($constraint) {
//                $constraint->upsize();
//            }, $sizes[2]);
//        $save  = Storage::put('public/'.$path, (string)$image->encode());
//        if (!$save) {
//            $this->fail('Не удалось сохранить файл');
//        }
//    }
}
