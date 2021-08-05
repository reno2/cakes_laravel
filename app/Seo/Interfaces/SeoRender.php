<?php

namespace App\Seo\Interfaces;

interface SeoRender{
    public function setData($data);
    public function renderTag($data);
}