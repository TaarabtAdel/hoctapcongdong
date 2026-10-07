<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Widget;
use App\Services\Settings\SettingsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WidgetController extends Controller
{
    public function index(): View
    {
        return view('admin.widgets.index', [
            'items' => Widget::query()->orderBy('location')->orderBy('sort_order')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.widgets.form', ['item' => new Widget]);
    }

    public function store(Request $request): RedirectResponse
    {
        Widget::create($this->validated($request));
        app(SettingsService::class)->flush();

        return redirect()->route('admin.widgets.index')->with('success', __('admin.messages.saved'));
    }

    public function edit(Widget $widget): View
    {
        return view('admin.widgets.form', ['item' => $widget]);
    }

    public function update(Request $request, Widget $widget): RedirectResponse
    {
        $widget->update($this->validated($request));
        app(SettingsService::class)->flush();

        return back()->with('success', __('admin.messages.updated'));
    }

    public function destroy(Widget $widget): RedirectResponse
    {
        $widget->delete();
        app(SettingsService::class)->flush();

        return back()->with('success', __('admin.messages.deleted'));
    }

    /**
     * @return array<string, mixed>
     */
    private function validated(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:50'],
            'type' => ['required', 'in:html,menu,posts'],
            'content' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer'],
            'is_active' => ['nullable', 'boolean'],
        ]) + ['is_active' => $request->boolean('is_active')];
    }
}
