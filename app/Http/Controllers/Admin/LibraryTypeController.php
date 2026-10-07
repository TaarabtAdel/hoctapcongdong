<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LibraryType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class LibraryTypeController extends Controller
{
    public function index(): View
    {
        return view('admin.taxonomy.index', [
            'title' => __('admin.menu.library_types'),
            'items' => LibraryType::orderBy('sort_order')->get(),
            'routePrefix' => 'admin.library-types',
        ]);
    }

    public function create(): View
    {
        return view('admin.taxonomy.form', [
            'title' => __('admin.actions.add_new'),
            'item' => new LibraryType,
            'routePrefix' => 'admin.library-types',
            'parents' => collect(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate(['name' => ['required'], 'icon' => ['nullable'], 'color' => ['nullable'], 'sort_order' => ['nullable', 'integer']]);
        $data['slug'] = Str::slug($data['name']);
        LibraryType::create($data);

        return redirect()->route('admin.library-types.index')->with('success', __('admin.messages.saved'));
    }

    public function edit(LibraryType $libraryType): View
    {
        return view('admin.taxonomy.form', [
            'title' => __('admin.actions.edit'),
            'item' => $libraryType,
            'routePrefix' => 'admin.library-types',
            'parents' => collect(),
        ]);
    }

    public function update(Request $request, LibraryType $libraryType): RedirectResponse
    {
        $libraryType->update($request->validate(['name' => ['required'], 'slug' => ['required'], 'icon' => ['nullable'], 'color' => ['nullable'], 'sort_order' => ['nullable', 'integer']]));

        return redirect()->route('admin.library-types.index')->with('success', __('admin.messages.updated'));
    }

    public function destroy(LibraryType $libraryType): RedirectResponse
    {
        $libraryType->delete();

        return back()->with('success', __('admin.messages.deleted'));
    }
}
