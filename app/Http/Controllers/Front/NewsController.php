<?php

namespace App\Http\Controllers\Front;

use App\Models\News;

class NewsController extends ContentListController
{
    protected function modelClass(): string
    {
        return News::class;
    }

    protected function title(): string
    {
        return __('front.menu.news');
    }

    protected function routeShow(string $slug): string
    {
        return route('front.news.show', $slug);
    }
}
