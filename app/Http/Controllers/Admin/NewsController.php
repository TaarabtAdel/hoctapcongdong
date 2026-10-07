<?php

namespace App\Http\Controllers\Admin;

use App\Models\Concerns\BaseContentModel;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NewsController extends BaseContentController
{
    protected function modelClass(): string
    {
        return News::class;
    }

    protected function permissionModule(): string
    {
        return 'news';
    }

    protected function routePrefix(): string
    {
        return 'admin.news';
    }

    protected function viewPrefix(): string
    {
        return 'admin.content';
    }

    protected function singularLabel(): string
    {
        return __('admin.menu.news');
    }

    protected function formViewData(BaseContentModel $item): array
    {
        $news = $item instanceof News ? $item : null;

        return [
            'newsCategories' => NewsCategory::orderBy('name')->get(),
            'tags' => Tag::orderBy('name')->get(),
            'selectedCategories' => $news?->categories()->pluck('news_categories.id')->all() ?? [],
            'selectedTags' => $news?->tags()->pluck('tags.id')->all() ?? [],
        ];
    }

    protected function afterSave(BaseContentModel $item, Request $request): void
    {
        if (! $item instanceof News) {
            return;
        }
        $item->categories()->sync($request->input('category_ids', []));
        $tagIds = $request->input('tag_ids', []);
        if ($request->filled('tag_names')) {
            foreach (explode(',', $request->string('tag_names')->toString()) as $name) {
                $name = trim($name);
                if ($name === '') {
                    continue;
                }
                $tag = Tag::query()->firstOrCreate(['slug' => Str::slug($name)], ['name' => $name]);
                $tagIds[] = $tag->id;
            }
        }
        $item->tags()->sync(array_unique($tagIds));
    }
}
