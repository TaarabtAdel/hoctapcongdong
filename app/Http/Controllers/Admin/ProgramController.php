<?php

namespace App\Http\Controllers\Admin;

use App\Models\Program;

class ProgramController extends BaseContentController
{
    protected function modelClass(): string
    {
        return Program::class;
    }

    protected function permissionModule(): string
    {
        return 'programs';
    }

    protected function contentType(): string
    {
        return 'program';
    }

    protected function routePrefix(): string
    {
        return 'admin.programs';
    }

    protected function viewPrefix(): string
    {
        return 'admin.content';
    }

    protected function singularLabel(): string
    {
        return __('admin.menu.programs');
    }

    protected function extraValidationRules(): array
    {
        return [
            'color' => ['nullable', 'string', 'max:20'],
            'icon' => ['nullable', 'string', 'max:100'],
            'schedule_note' => ['nullable', 'string', 'max:255'],
        ];
    }
}
