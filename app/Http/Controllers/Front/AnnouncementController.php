<?php

namespace App\Http\Controllers\Front;

use App\Models\Announcement;

class AnnouncementController extends ContentListController
{
    protected function modelClass(): string
    {
        return Announcement::class;
    }

    protected function title(): string
    {
        return __('front.menu.announcements');
    }

    protected function routeShow(string $slug): string
    {
        return route('front.announcements.show', $slug);
    }
}
