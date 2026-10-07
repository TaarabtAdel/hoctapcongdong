<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Services\Settings\SettingsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BannerController extends Controller
{
    public function index(): View
    {
        return view('admin.banners.index', [
            'items' => Banner::with('image')->orderBy('location')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.banners.form', ['item' => new Banner]);
    }

    public function store(Request $request): RedirectResponse
    {
        Banner::create($this->validated($request));
        app(SettingsService::class)->flush();

        return redirect()->route('admin.banners.index')->with('success', __('admin.messages.saved'));
    }

    public function edit(Banner $banner): View
    {
        return view('admin.banners.form', ['item' => $banner]);
    }

    public function update(Request $request, Banner $banner): RedirectResponse
    {
        $banner->update($this->validated($request));
        app(SettingsService::class)->flush();

        return back()->with('success', __('admin.messages.updated'));
    }

    public function destroy(Banner $banner): RedirectResponse
    {
        $banner->delete();
        app(SettingsService::class)->flush();

        return back()->with('success', __('admin.messages.deleted'));
    }

    /**
     * @return array<string, mixed>
     */
    private function validated(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'location' => ['required', 'string', 'max:50'],
            'image_id' => ['nullable', 'exists:media,id'],
            'title' => ['nullable', 'string', 'max:255'],
            'link_url' => ['nullable', 'url'],
            'is_active' => ['nullable', 'boolean'],
        ]) + ['is_active' => $request->boolean('is_active', true)];
    }
}
