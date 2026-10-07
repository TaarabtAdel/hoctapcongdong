<?php

namespace App\Http\Controllers\Admin;

use App\Models\LearningModel;

class LearningModelController extends BaseContentController
{
    protected function modelClass(): string
    {
        return LearningModel::class;
    }

    protected function permissionModule(): string
    {
        return 'learning_models';
    }

    protected function contentType(): string
    {
        return 'learning-model';
    }

    protected function routePrefix(): string
    {
        return 'admin.learning-models';
    }

    protected function viewPrefix(): string
    {
        return 'admin.content';
    }

    protected function singularLabel(): string
    {
        return __('admin.menu.learning_models');
    }

    protected function extraValidationRules(): array
    {
        return [
            'icon' => ['nullable', 'string', 'max:100'],
            'color' => ['nullable', 'string', 'max:20'],
            'criteria' => ['nullable', 'string'],
        ];
    }
}
