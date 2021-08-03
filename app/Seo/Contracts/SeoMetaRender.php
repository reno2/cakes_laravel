<?php
namespace App\Seo\Contracts;

interface SeoMetaRender
{
    public function setData();

   // public function getTpl();

    public function returnMeta();
   // public function fieldBuilder();
}