<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Services\Home\HomePageService;
use App\Services\Seo\MetaService;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(HomePageService $homePageService, MetaService $meta): View
    {
        return view('front.home.index', [
            'blocks' => $homePageService->blocks(),
            'meta' => $meta->forHome(),
        ]);
    }
}
