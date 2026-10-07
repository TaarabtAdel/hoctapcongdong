<?php

namespace App\Http\Controllers\Admin;

use App\Models\LibraryItem;
use App\Models\LibraryType;

class LibraryItemController extends BaseContentController
{
    protected function modelClass(): string
    {
        return LibraryItem::class;
    }

    protected function permissionModule(): string
    {
        return 'library';
    }

    protected function contentType(): string
    {
        return 'library-item';
    }

    protected function routePrefix(): string
    {
        return 'admin.library-items';
    }

    protected function viewPrefix(): string
    {
        return 'admin.content';
    }

    protected function singularLabel(): string
    {
        return __('admin.menu.library');
    }

    protected function formViewData($item): array
    {
        return ['libraryTypes' => LibraryType::orderBy('sort_order')->get()];
    }

    protected function extraValidationRules(): array
    {
        return [
            'library_type_id' => ['nullable', 'exists:library_types,id'],
            'file_media_id' => ['nullable', 'exists:media,id'],
            'external_url' => ['nullable', 'url'],
            'duration' => ['nullable', 'string', 'max:50'],
            'author_name' => ['nullable', 'string', 'max:255'],
        ];
    }
}
