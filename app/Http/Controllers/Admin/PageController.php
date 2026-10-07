<?php

namespace App\Http\Controllers\Admin;

use App\Models\Concerns\BaseContentModel;
use App\Models\Page;

class PageController extends BaseContentController
{
    protected function modelClass(): string
    {
        return Page::class;
    }

    protected function permissionModule(): string
    {
        return 'pages';
    }

    protected function routePrefix(): string
    {
        return 'admin.pages';
    }

    protected function viewPrefix(): string
    {
        return 'admin.content';
    }

    protected function singularLabel(): string
    {
        return __('admin.menu.pages');
    }

    protected function contentType(): string
    {
        return 'page';
    }

    protected function formViewData(BaseContentModel $item): array
    {
        return [
            'pages' => Page::query()->when($item->exists, fn ($q) => $q->whereKeyNot($item->id))->orderBy('title')->get(),
        ];
    }

    protected function extraValidationRules(): array
    {
        return [
            'parent_id' => ['nullable', 'exists:pages,id'],
            'template' => ['nullable', 'in:default,full-width,contact,about'],
            'menu_order' => ['nullable', 'integer'],
        ];
    }
}
