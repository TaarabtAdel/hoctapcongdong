<?php

namespace App\Http\Controllers\Front;

use App\Models\Program;

class ProgramController extends ContentListController
{
    protected function modelClass(): string
    {
        return Program::class;
    }

    protected function title(): string
    {
        return __('front.menu.programs');
    }

    protected function routeShow(string $slug): string
    {
        return route('front.programs.show', $slug);
    }
}
