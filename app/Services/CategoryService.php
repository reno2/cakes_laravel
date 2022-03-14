<?php

namespace App\Services;

use App\Media\LocalMedia;
use App\Models\Attachment;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class CategoryService{


    public function createCategory($request){
        $category = Category::create($request->except('image'));

        if($request->hasFile('image')) {
            $fileSave = new LocalMedia($category->id, 'categories', [80, 80]);
            $fileUrl = $fileSave->add($request->file('image'));
            if($fileUrl){
                $category->attachments()->create(['url' => $fileUrl]);
            }
        }
    }


    public function getAll () {
        $categories = Category::orderBy('sort', 'asc')->orderBy('id', 'desc')->with('attachments')->paginate(10);

        foreach ($categories as $category) {
            if ($category->attachments()->exists()) {
                foreach ($category->attachments as $attach) {
                    $category->image = Storage::url($attach->url);
                }
            } else {
                $category->image = Storage::url("images/defaults/cake.svg");
                continue;
            }
        }
        return $categories;
    }


    public function getForEdit ($category) {
        if ($category->attachments()->exists()) {
            foreach ($category->attachments as $attach) {
                $category->image = Storage::url($attach->url);
                $category->imageId = $attach->id;
            }
        } else {
            $category->image = Storage::url("images/defaults/cake.svg");
        }
        return $category;
    }


    public function updateCategory (Category $category, Request $request) {
        $inputsArray = $request->all();

        // Получаем id связанных файлов
        if ($inputsArray['category_img_del']) {
            $attachmentIds = explode(',', $inputsArray['category_img_del']);

            $filesUrls = \DB::table('attachments')
                            ->whereIn('id', $attachmentIds)
                            ->pluck('url');

            // Если есть, то удаляем фалйы
            if ($filesUrls) {
                foreach ($filesUrls as $fileUrl) {
                    $this->checkIfExistsAndDelete($fileUrl);
                }
            }
            // Удляем связи
            $category->attachments()->whereIn('id', $attachmentIds)->delete();
        }

        // Если есть новая картинка добавяем
        if ($request->hasFile('image')) {
            $fileSave = new LocalMedia($category->id, 'categories', [80, 80]);
            $fileUrl = $fileSave->add($request->file('image'));
            if ($fileUrl) {
                $category->attachments()->create(['url' => $fileUrl]);
            }
        }

        $category->update($inputsArray);
    }



    public function deleteFilesAndRelation (Category $category) {
        if ($category->articles()) {
            $category->articles()->detach();
        }
        $this->deleteAttachments($category);
        try {
            $category->delete();
        } catch (\Exception $e) {

        }

    }

    public function deleteAttachments (Category $category) {
        if (!$category->attachments()) {
            return true;
        }

        $ids = [];
        // Проверяем есть ли связанные файлы
        // Если есть получаем ids
        foreach ($category->attachments as $photo) {
            $this->checkIfExistsAndDelete($photo->url);
            $ids[] = $photo->id;
        }

        if (count($ids) == 0) return true;

        if(!Attachment::whereIn('id', $ids)->delete()){
            throw new \Exception('Ошибка при удалении связанных файлов');
        }

    }


    /**
     * Если файл существует удаляем
     * @param string $url
     */
    public function checkIfExistsAndDelete (string $url) {
        $path = Storage::disk('public')->path($url);
        if (File::exists($path)) {
            File::delete($path);
            File::deleteDirectory(dirname($path));
        }
    }
}