<?php

namespace App\Search;

use App\Repositories\AdsRepository;
use App\Search\SphinxClient;

class SearchSphinxRepository{
    private $connect;
    private $adsRepository;

    function __construct () {
        $this->adsRepository = new AdsRepository();

        $this->connect = new SphinxClient();
        $this->connect->SetServer('lara_sphinx', 9312);
        $this->connect->SetConnectTimeout(1);
    }

    /**
     * @param $phrase
     * #return Illuminate\Database\Eloquent\Collection
     * @return
     */
    public function getByQuery($phrase)  {
        return  $this->connect->Query($phrase, 'test');

    }

}