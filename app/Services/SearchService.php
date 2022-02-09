<?php

namespace App\Services;


use App\Repositories\AdsRepository;
use App\Search\SearchSphinxRepository;

class SearchService{

    public $searchRepository = null;
    public $adsRepository;

    function __construct () {
        $this->searchRepository = new SearchSphinxRepository();
        $this->adsRepository = new AdsRepository();
    }

    public function getByQuery($phrase){
        $searchResult = $this->searchRepository->getByQuery($phrase);

        if(count($searchResult["matches"])){

            $wordForm = helper_getNumWord($searchResult["total"],  ['Найден', 'Найдено', 'Найдены']);
            $title = " {$wordForm} '{$searchResult["total"]}' по запросу <b>{$phrase}</b>";
            $ids = array_keys($searchResult["matches"]);

            $rawArticles = $this->adsRepository->getByCurrentProfileFavoritesAdsSortedDesc($ids);



            $items = $rawArticles->sortBy(function($model) use ($ids, $phrase){
                $model->description = str_replace( $phrase, "<b>{$phrase}</b>",  $model->description);
                // $model->title = str_replace( $phrase, "<b>{$phrase}</b>",   $model->title);
                return array_search($model->id, $ids);
            });

           return [
              'items' => $items,
              'title' => $title
            ];

        }else {
            return [
                'items' => [],
                'title' => ''
            ];
        }
    }
}