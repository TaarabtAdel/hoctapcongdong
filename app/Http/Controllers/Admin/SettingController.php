<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Settings\SettingsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function edit(string $group = 'general'): View
    {
        $settings = app(SettingsService::class)->all();

        return view('admin.settings.edit', compact('group', 'settings'));
    }

    public function update(Request $request, SettingsService $settingsService, string $group = 'general'): RedirectResponse
    {
        $settingsService->setMany($request->except(['_token', '_method']), $group);

        return back()->with('success', __('admin.messages.updated'));
    }
}
