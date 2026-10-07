<?php

namespace App\Http\Controllers\Admin;

use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends BaseContentController
{
    protected function modelClass(): string
    {
        return Announcement::class;
    }

    protected function permissionModule(): string
    {
        return 'announcements';
    }

    protected function routePrefix(): string
    {
        return 'admin.announcements';
    }

    protected function viewPrefix(): string
    {
        return 'admin.content';
    }

    protected function singularLabel(): string
    {
        return __('admin.menu.announcements');
    }

    protected function extraValidationRules(): array
    {
        return [
            'expires_at' => ['nullable', 'date'],
        ];
    }

    protected function validated(Request $request): array
    {
        return parent::validated($request) + [
            'is_pinned' => $request->boolean('is_pinned'),
        ];
    }
}
