<?php

namespace App\Traits;

use App\Models\PostImage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;

trait UploadTrait
{
    public function uploadOne($file, $adsId)
    {
        $name           = $file->getClientOriginalName();
        $folders        = [
            'big' => 'images/' . $adsId . '/big_' . $name,
            'small' => 'images/' . $adsId . '/small_' . $name
        ];
        $sizes = [
            'big' => [350, 750, 'center'],
            'small' => [250, 250, 'center']
        ];
        $adsImageModel = new PostImage;
        $adsImageModel->article_id = $adsId;
        $adsImageModel->name = $name;

        foreach ($folders as $key => $folder) {
            if (!Storage::disk('public')->exists($folder)) {
                $this->fileCrop($file, $sizes[$key], $folder);
                $url = Storage::url($folder);
                $adsImageModel->$key = $url;
            }
        }
        if( !$adsImageModel->save())
            $this->fail();
    }



    public function fileCrop($file, $sizes, $path)
    {
        $image = Image::make($file)->fit($sizes[0], $sizes[1],
            function ($constraint) {
                $constraint->upsize();
            }, $sizes[2]);
        $save  = Storage::put('public/'.$path, (string)$image->encode());
        if (!$save) {
            $this->fail('Не удалось сохранить файл');
        }
    }
}
