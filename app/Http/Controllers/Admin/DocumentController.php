<?php

namespace App\Http\Controllers\Admin;

use App\Models\Document;
use App\Models\DocumentLevel;

class DocumentController extends BaseContentController
{
    protected function modelClass(): string
    {
        return Document::class;
    }

    protected function permissionModule(): string
    {
        return 'documents';
    }

    protected function routePrefix(): string
    {
        return 'admin.documents';
    }

    protected function viewPrefix(): string
    {
        return 'admin.content';
    }

    protected function singularLabel(): string
    {
        return __('admin.menu.documents');
    }

    protected function formViewData($item): array
    {
        return ['documentLevels' => DocumentLevel::orderBy('sort_order')->get()];
    }

    protected function extraValidationRules(): array
    {
        return [
            'document_level_id' => ['nullable', 'exists:document_levels,id'],
            'document_number' => ['nullable', 'string', 'max:100'],
            'issued_at' => ['nullable', 'date'],
            'issuing_agency' => ['nullable', 'string', 'max:255'],
            'file_media_id' => ['nullable', 'exists:media,id'],
        ];
    }
}
