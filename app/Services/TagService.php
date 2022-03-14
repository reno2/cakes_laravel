<?php

namespace App\Services;


use App\Media\LocalMedia;
use App\Models\Attachment;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class TagService
{

    public function createTag($request){
        $tag = Tag::create($request->except('image'));

        if($request->hasFile('image')) {
            $fileSave = new LocalMedia($tag->id, 'tags', [320, 200]);
            $fileUrl = $fileSave->add($request->file('image'));
            if($fileUrl){
                $tag->attachments()->create(['url' => $fileUrl]);
            }
        }
    }


    public function getAll () {

        $tags = Tag::orderBy('sort', 'asc')->orderBy('id', 'desc')->with('attachments')->paginate(10);
        foreach ($tags as $tag) {
            if ($tag->attachments()->exists()) {
                foreach ($tag->attachments as $attach) {
                    $tag->image = Storage::url($attach->url);
                }
            } else {
                $tag->image = Storage::url("images/defaults/cake.svg");
                continue;
            }
        }
        return $tags;
    }

    public function getForEdit ($tag) {
        if ($tag->attachments()->exists()) {
            foreach ($tag->attachments as $attach) {
                $tag->image = Storage::url($attach->url);
                $tag->imageId = $attach->id;
            }
        } else {
            $tag->image = Storage::url("images/defaults/cake.svg");
        }
        return $tag;
    }

    /**
     * @param Tag $tag
     * @param Request $request
     */
    public function updateTag (Tag $tag, Request $request) {
        $inputsArray = $request->all();
        $inputsArray['important'] = $inputsArray['important'] ? true : false;

        // Получаем id связанных файлов
        if ($inputsArray['tag_img_del']) {
            $attachmentIds = explode(',', $inputsArray['tag_img_del']);

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
            $tag->attachments()->whereIn('id', $attachmentIds)->delete();
        }

        // Если есть новая картинка добавяем
        if ($request->hasFile('image')) {
            $fileSave = new LocalMedia($tag->id, 'tags', [320, 200]);
            $fileUrl = $fileSave->add($request->file('image'));
            if ($fileUrl) {
                $tag->attachments()->create(['url' => $fileUrl]);
            }
        }

        $tag->update($inputsArray);
    }


    public function deleteFilesAndRelation (Tag $tag) {

        if ($tag->articles()) {
            $tag->articles()->detach();
        }

        $this->deleteAttachments($tag);

        try {
            $tag->delete();
        } catch (\Exception $e) {
        }
    }


    public function deleteAttachments (Tag $tag) {

        if (!$tag->attachments()) {
            return true;
        }

        $ids = [];
        foreach ($tag->attachments as $photo) {
            $this->checkIfExistsAndDelete($photo->url);
            $ids[] = $photo->id;
        }
        $tag->attachments()->delete();

        if (count($ids)) Attachment::whereIn('id', $ids)->delete();

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