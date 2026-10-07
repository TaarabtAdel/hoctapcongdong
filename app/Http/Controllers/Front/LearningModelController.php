<?php

namespace App\Http\Controllers\Front;

use App\Models\LearningModel;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LearningModelController extends ContentListController
{
    protected function modelClass(): string
    {
        return LearningModel::class;
    }

    protected function title(): string
    {
        return __('front.menu.lifelong');
    }

    protected function routeShow(string $slug): string
    {
        return route('front.learning-models.show', $slug);
    }

    public function index(Request $request): View
    {
        $items = LearningModel::published()->orderBy('sort_order')->get();

        return view('front.learning-models.index', [
            'items' => $items,
            'title' => $this->title(),
        ]);
    }
}
