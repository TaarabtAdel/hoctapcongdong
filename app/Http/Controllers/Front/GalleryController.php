<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Services\Seo\MetaService;
use Illuminate\View\View;

class GalleryController extends Controller
{
    public function index(): View
    {
        $galleries = Gallery::published()->with(['items.media'])->latest('published_at')->paginate(6);

        return view('front.gallery.index', [
            'galleries' => $galleries,
            'meta' => app(MetaService::class)->forGeneric(__('front.home.gallery')),
        ]);
    }

    public function show(string $slug): View
    {
        $gallery = Gallery::published()->with(['items.media'])->where('slug', $slug)->firstOrFail();

        return view('front.gallery.show', [
            'gallery' => $gallery,
            'meta' => app(MetaService::class)->forContent($gallery),
        ]);
    }
}
