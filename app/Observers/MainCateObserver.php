<?php

namespace App\Observers;

use App\Models\MainCate;

class MainCateObserver
{
    /**
     * Handle the main cate "created" event.
     *
     * @param  \App\Models\MainCate  $mainCate
     * @return void
     */
    public function created(MainCate $mainCate)
    {
        //
    }

    /**
     * Handle the main cate "updated" event.
     *
     * @param  \App\Models\MainCate  $mainCate
     * @return void
     */
    public function updated(MainCate $mainCate)
    {
        // UPDATE VENDORS STATUS RELATED TO THIS MAIN CATEGORY WITH THE SAME STATUS OF MAIN CATEGORY
        $mainCate->vendors()->update([
            'status' => $mainCate->status
        ]);
    }

    /**
     * Handle the main cate "deleted" event.
     *
     * @param  \App\Models\MainCate  $mainCate
     * @return void
     */
    public function deleted(MainCate $mainCate)
    {
        // ASSIGN WHICH MAIN CATEGORY HAS DEFAULT LANGUAGE
        $mainCate = ($mainCate->translation_of == 0) ? $mainCate : $mainCate->def_cate;
        // DELETE TRANSLATED CATEGORIES OF THE MAIN CATEGORY
        $mainCate->trans_cates()->delete();
    }

    /**
     * Handle the main cate "restored" event.
     *
     * @param  \App\Models\MainCate  $mainCate
     * @return void
     */
    public function restored(MainCate $mainCate)
    {
        // 
    }

    /**
     * Handle the main cate "force deleted" event.
     *
     * @param  \App\Models\MainCate  $mainCate
     * @return void
     */
    public function forceDeleted(MainCate $mainCate)
    {
        //
    }
}
