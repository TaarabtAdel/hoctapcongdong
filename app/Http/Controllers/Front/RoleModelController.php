<?php

namespace App\Http\Controllers\Front;

use App\Models\RoleModel;

class RoleModelController extends ContentListController
{
    protected function modelClass(): string
    {
        return RoleModel::class;
    }

    protected function title(): string
    {
        return __('front.menu.role_models');
    }

    protected function routeShow(string $slug): string
    {
        return route('front.role-models.show', $slug);
    }
}
