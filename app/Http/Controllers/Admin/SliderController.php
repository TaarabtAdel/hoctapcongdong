<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SliderController extends Controller
{
    public function index(): View
    {
        return view('admin.sliders.index', ['items' => Slider::withCount('slides')->get()]);
    }

    public function create(): View
    {
        return view('admin.sliders.form', ['slider' => new Slider]);
    }

    public function store(Request $request): RedirectResponse
    {
        $slider = Slider::create($request->validate(['name' => ['required'], 'location' => ['required'], 'is_active' => ['nullable', 'boolean']]));

        return redirect()->route('admin.sliders.edit', $slider)->with('success', __('admin.messages.saved'));
    }

    public function edit(Slider $slider): View
    {
        $slider->load('slides');

        return view('admin.sliders.form', compact('slider'));
    }

    public function update(Request $request, Slider $slider): RedirectResponse
    {
        $slider->update($request->validate(['name' => ['required'], 'location' => ['required'], 'is_active' => ['nullable', 'boolean']]) + [
            'is_active' => $request->boolean('is_active', true),
        ]);

        foreach ($request->input('slides', []) as $index => $row) {
            if (empty($row['title']) && empty($row['image_id'])) {
                continue;
            }
            $payload = [
                'title' => $row['title'] ?? null,
                'subtitle' => $row['subtitle'] ?? null,
                'link_url' => $row['link_url'] ?? null,
                'badge_text' => $row['badge_text'] ?? null,
                'image_id' => $row['image_id'] ?: null,
                'sort_order' => (int) ($row['sort_order'] ?? $index),
                'is_active' => ! empty($row['is_active']),
            ];
            if (! empty($row['id'])) {
                $slider->slides()->whereKey($row['id'])->update($payload);
            } else {
                $slider->slides()->create($payload);
            }
        }

        return back()->with('success', __('admin.messages.updated'));
    }

    public function destroy(Slider $slider): RedirectResponse
    {
        $slider->delete();

        return back()->with('success', __('admin.messages.deleted'));
    }
}
