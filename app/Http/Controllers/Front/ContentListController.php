<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Concerns\BaseContentModel;
use App\Services\Seo\MetaService;
use Illuminate\Http\Request;
use Illuminate\View\View;

abstract class ContentListController extends Controller
{
    abstract protected function modelClass(): string;

    abstract protected function title(): string;

    abstract protected function routeShow(string $slug): string;

    public function index(Request $request): View
    {
        /** @var class-string<BaseContentModel> $class */
        $class = $this->modelClass();
        $items = $class::published()->latest('published_at')->paginate(12);

        return view('front.content.index', [
            'items' => $items,
            'title' => $this->title(),
            'showRoute' => fn ($item) => $this->routeShow($item->slug),
            'meta' => app(MetaService::class)->forGeneric($this->title()),
        ]);
    }

    public function show(string $slug): View
    {
        /** @var class-string<BaseContentModel> $class */
        $class = $this->modelClass();
        $item = $class::published()->where('slug', $slug)->firstOrFail();
        $item->increment('view_count');

        return view('front.content.show', [
            'item' => $item,
            'meta' => app(MetaService::class)->forContent($item),
        ]);
    }
}
