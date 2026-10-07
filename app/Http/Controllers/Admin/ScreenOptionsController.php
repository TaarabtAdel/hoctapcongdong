<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserPreference;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ScreenOptionsController extends Controller
{
    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'context' => ['required', 'string', 'max:100'],
            'columns' => ['required', 'array'],
            'columns.*' => ['boolean'],
        ]);

        $columns = collect($data['columns'])
            ->map(fn ($v) => filter_var($v, FILTER_VALIDATE_BOOLEAN))
            ->all();

        UserPreference::storeFor(
            $request->user()->id,
            'screen_options.'.$data['context'],
            $columns
        );

        return back()->with('success', __('admin.messages.screen_options_saved'));
    }
}
