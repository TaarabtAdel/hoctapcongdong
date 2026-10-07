<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\LibraryItem;
use App\Models\LibraryType;
use App\Services\Seo\MetaService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LibraryController extends Controller
{
    public function index(Request $request): View
    {
        $typeSlug = $request->string('loai')->toString();
        $query = LibraryItem::published()->with(['libraryType', 'fileMedia']);
        if ($typeSlug) {
            $query->whereHas('libraryType', fn ($q) => $q->where('slug', $typeSlug));
        }

        return view('front.library.index', [
            'items' => $query->latest('published_at')->paginate(12)->withQueryString(),
            'types' => LibraryType::orderBy('sort_order')->get(),
            'activeType' => $typeSlug,
            'meta' => app(MetaService::class)->forGeneric(__('front.menu.library')),
        ]);
    }

    public function show(string $slug): View
    {
        $item = LibraryItem::published()->with(['libraryType', 'fileMedia'])->where('slug', $slug)->firstOrFail();
        $item->increment('view_count');

        return view('front.library.show', [
            'item' => $item,
            'meta' => app(MetaService::class)->forContent($item),
        ]);
    }
}
