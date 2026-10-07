<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class TagController extends Controller
{
    public function index(): View
    {
        return view('admin.taxonomy.index', [
            'title' => __('admin.menu.tags'),
            'items' => Tag::orderBy('name')->get(),
            'routePrefix' => 'admin.tags',
        ]);
    }

    public function create(): View
    {
        return view('admin.taxonomy.form', [
            'title' => __('admin.actions.add_new'),
            'item' => new Tag,
            'routePrefix' => 'admin.tags',
            'parents' => collect(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate(['name' => ['required', 'string', 'max:255'], 'slug' => ['nullable', 'string']]);
        $data['slug'] = $data['slug'] ?: Str::slug($data['name']);
        Tag::create($data);

        return redirect()->route('admin.tags.index')->with('success', __('admin.messages.saved'));
    }

    public function edit(Tag $tag): View
    {
        return view('admin.taxonomy.form', [
            'title' => __('admin.actions.edit'),
            'item' => $tag,
            'routePrefix' => 'admin.tags',
            'parents' => collect(),
        ]);
    }

    public function update(Request $request, Tag $tag): RedirectResponse
    {
        $data = $request->validate(['name' => ['required', 'string'], 'slug' => ['required', 'string']]);
        $tag->update($data);

        return redirect()->route('admin.tags.index')->with('success', __('admin.messages.updated'));
    }

    public function destroy(Tag $tag): RedirectResponse
    {
        $tag->delete();

        return back()->with('success', __('admin.messages.deleted'));
    }
}
