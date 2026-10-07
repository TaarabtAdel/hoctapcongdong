<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Services\Seo\MetaService;
use Illuminate\View\View;

class StaticPageController extends Controller
{
    public function resolve(string $slug): View
    {
        $reserved = [
            'admin', 'tin-tuc', 'thong-bao', 'lich-hoat-dong', 'su-kien', 'chuong-trinh-hoc-tap',
            'van-ban-tai-lieu', 'hoc-tap-suot-doi', 'mo-hinh', 'thu-vien-so', 'guong-hoc-tap',
            'hinh-anh-video', 'lien-he', 'dang-ky-hoc-tap', 'cam-on-dang-ky', 'tim-kiem',
            'preview', 'sitemap.xml', 'robots.txt',
        ];
        if (in_array($slug, $reserved, true)) {
            abort(404);
        }

        $page = Page::published()->where('slug', $slug)->firstOrFail();

        return view('front.pages.show', [
            'page' => $page,
            'meta' => app(MetaService::class)->forPage($page),
        ]);
    }
}
