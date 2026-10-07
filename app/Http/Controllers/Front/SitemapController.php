<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Page;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $urls = [url('/')];
        foreach (News::published()->get(['slug']) as $item) {
            $urls[] = url('/tin-tuc/'.$item->slug);
        }
        foreach (Page::published()->get(['slug']) as $item) {
            $urls[] = url('/'.$item->slug);
        }
        $xml = view('front.sitemap', compact('urls'))->render();

        return response($xml, 200, ['Content-Type' => 'application/xml']);
    }

    public function robots(): Response
    {
        $content = "User-agent: *\nAllow: /\nSitemap: ".url('/sitemap.xml')."\n";

        return response($content, 200, ['Content-Type' => 'text/plain']);
    }
}
