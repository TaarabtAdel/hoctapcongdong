<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Document;
use App\Models\Event;
use App\Models\Gallery;
use App\Models\LearningModel;
use App\Models\LibraryItem;
use App\Models\News;
use App\Models\Page;
use App\Models\Program;
use App\Models\RoleModel;
use App\Services\Seo\MetaService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SearchController extends Controller
{
    public function index(Request $request): View
    {
        $q = trim($request->string('q')->toString());
        $groups = [];
        if ($q !== '') {
            $groups = [
                __('front.menu.news') => News::published()->where('title', 'like', "%{$q}%")->limit(10)->get(),
                __('front.menu.announcements') => Announcement::published()->where('title', 'like', "%{$q}%")->limit(10)->get(),
                __('front.menu.events') => Event::published()->where('title', 'like', "%{$q}%")->limit(10)->get(),
                __('front.menu.documents') => Document::published()->where('title', 'like', "%{$q}%")->limit(10)->get(),
                __('admin.menu.pages') => Page::published()->where('title', 'like', "%{$q}%")->limit(10)->get(),
                __('front.menu.library') => LibraryItem::published()->where('title', 'like', "%{$q}%")->limit(10)->get(),
                __('front.menu.role_models') => RoleModel::published()->where('title', 'like', "%{$q}%")->limit(10)->get(),
                __('front.home.gallery') => Gallery::published()->where('title', 'like', "%{$q}%")->limit(10)->get(),
                __('front.menu.programs_short') => Program::published()->where('title', 'like', "%{$q}%")->limit(10)->get(),
                __('front.home.lifelong_title') => LearningModel::published()->where('title', 'like', "%{$q}%")->limit(10)->get(),
            ];
        }

        return view('front.search.index', [
            'q' => $q,
            'groups' => $groups,
            'meta' => app(MetaService::class)->forGeneric(__('front.home.search_placeholder'), null, route('front.search')),
        ]);
    }
}
