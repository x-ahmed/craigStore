<?php

namespace App\Observers;

use App\Models\SubCate;

class SubCateObserver
{
    /**
     * Handle the sub cate "created" event.
     *
     * @param  \App\Models\SubCate  $subCate
     * @return void
     */
    public function created(SubCate $subCate)
    {
        //
    }

    /**
     * Handle the sub cate "updated" event.
     *
     * @param  \App\Models\SubCate  $subCate
     * @return void
     */
    public function updated(SubCate $subCate)
    {
        //
    }

    /**
     * Handle the sub cate "deleted" event.
     *
     * @param  \App\Models\SubCate  $subCate
     * @return void
     */
    public function deleted(SubCate $subCate)
    {
        //
    }

    /**
     * Handle the sub cate "restored" event.
     *
     * @param  \App\Models\SubCate  $subCate
     * @return void
     */
    public function restored(SubCate $subCate)
    {
        //
    }

    /**
     * Handle the sub cate "force deleted" event.
     *
     * @param  \App\Models\SubCate  $subCate
     * @return void
     */
    public function forceDeleted(SubCate $subCate)
    {
        //
    }
}
