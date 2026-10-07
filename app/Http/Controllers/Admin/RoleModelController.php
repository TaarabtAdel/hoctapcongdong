<?php

namespace App\Http\Controllers\Admin;

use App\Models\RoleModel;

class RoleModelController extends BaseContentController
{
    protected function modelClass(): string
    {
        return RoleModel::class;
    }

    protected function permissionModule(): string
    {
        return 'role_models';
    }

    protected function contentType(): string
    {
        return 'role-model';
    }

    protected function routePrefix(): string
    {
        return 'admin.role-models';
    }

    protected function viewPrefix(): string
    {
        return 'admin.content';
    }

    protected function singularLabel(): string
    {
        return __('admin.menu.role_models');
    }

    protected function extraValidationRules(): array
    {
        return [
            'person_name' => ['nullable', 'string', 'max:255'],
            'model_type' => ['nullable', 'in:individual,family,clan,community'],
            'address' => ['nullable', 'string', 'max:255'],
        ];
    }
}
