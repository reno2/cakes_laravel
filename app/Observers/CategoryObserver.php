<?php

namespace App\Observers;

use App\Models\Category;
use Illuminate\Support\Facades\Cache;

class CategoryObserver
{
    /**
     * Handle the category "created" event.
     *
     * @param  Category  $category
     * @return void
     */
    public function created(Category $category)
    {
        //
    }


    public function saving(Category $category)
    {
        Cache::forget('front_categories');

    }


    /**
     * Handle the category "updated" event.
     *
     * @param  Category  $category
     * @return void
     */
    public function updated(Category $category)
    {

    }

    /**
     * Handle the category "deleted" event.
     *
     * @param  Category  $category
     * @return void
     */
    public function deleted(Category $category)
    {
        //
    }

    /**
     * Handle the category "restored" event.
     *
     * @param  Category  $category
     * @return void
     */
    public function restored(Category $category)
    {
        //
    }

    /**
     * Handle the category "force deleted" event.
     *
     * @param  Category  $category
     * @return void
     */
    public function forceDeleted(Category $category)
    {
        //
    }
}
