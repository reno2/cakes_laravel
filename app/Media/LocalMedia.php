<?php


namespace App\Media;


use App\Media\MediaInterface;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class LocalMedia implements MediaInterface
{

    public $path;
    public $sizes;

    public function __construct ($id, $dir = 'files', $resize = [320, 200]) {
        $this->path = 'images/' . $dir . '/' . $id . '/';
        $this->sizes = $resize;
    }

    public function makePath($fileName){
        return $this->path . $fileName;
    }


    public function add ($files) {
        if(is_array($files)) {
            if(count($files) > 1){
                // TODO:
            }else{
                return $this->saveFile($files[0]);
            }
        }
    }

    public function saveFile($file){

        $newImage = Image::make($file)->fit( $this->sizes[0],  $this->sizes[1], function ($constraint) {
            $constraint->upsize();
        }, 'center');

        $filePath = md5($file->getClientOriginalName()) .'.'.$file->getClientOriginalExtension();

        if(Storage::disk('public')->put($this->makePath($filePath), (string) $newImage->encode()))
            return $this->makePath($filePath);

        return false;
    }



}