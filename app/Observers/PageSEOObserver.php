<?php

namespace App\Observers;

use Illuminate\Support\Str;
use App\Models\Page;

class PageSEOObserver
{
    /**
     * Handle the product "creating" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function creating(Page $page)
    {
        $page->slug = Str::kebab($page->title);
    }

    /**
     * Handle the product "updated" event.
     *
     * @param  \App\Models\Product  $product
     * @return void
     */
    public function updating(Page $page)
    {
        $page->slug = Str::kebab($page->title);
    }
}
