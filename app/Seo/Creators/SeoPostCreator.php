<?php
namespace App\Seo\Creators;

use App\Seo\Classes\SeoPostRender;
use App\Seo\Classes\SeoPostDefault;
use App\Seo\SeoFabricClass;
use App\Seo\Contracts\SeoMetaRender;
use Illuminate\Support\Facades\DB;

/**
 * Этот Конкретный Создатель поддерживает LinkedIn.
 */
class SeoPostCreator extends SeoFabricClass
{
    private $type, $data;

    private $fillable = ['title', 'description', 'h1'];

    public function __construct(string $type, array $data)
    {
        $this->type = $type;
        $this->data = $data;
    }

    public function issetSepTpl(){

            $rawData = DB::table('seo')->where('type', $this->type)->first();
            if($rawData){
                foreach ($this->fillable as $toTpl){
                    if(in_array($rawData, $toTpl)) return true;
                }



            }
            $rr = '';
        return $r;

    }

    public function getSeoMeta (): SeoMetaRender {
        if($this->issetSepTpl()) return new SeoPostRender($this->type, $this->data);
         return new SeoPostDefault($this->type, $this->data);

    }
}