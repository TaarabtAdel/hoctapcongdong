<?php

namespace App\Http\Controllers\Admin;

use App\Models\Event;

class EventController extends BaseContentController
{
    protected function modelClass(): string
    {
        return Event::class;
    }

    protected function permissionModule(): string
    {
        return 'events';
    }

    protected function routePrefix(): string
    {
        return 'admin.events';
    }

    protected function viewPrefix(): string
    {
        return 'admin.content';
    }

    protected function singularLabel(): string
    {
        return __('admin.menu.events');
    }

    protected function extraValidationRules(): array
    {
        return [
            'start_at' => ['nullable', 'date'],
            'end_at' => ['nullable', 'date', 'after_or_equal:start_at'],
            'location' => ['nullable', 'string', 'max:255'],
            'audience' => ['nullable', 'string', 'max:255'],
            'registration_url' => ['nullable', 'url'],
        ];
    }
}
