<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DocumentLevel;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class DocumentLevelController extends Controller
{
    public function index(): View
    {
        return view('admin.taxonomy.index', [
            'title' => __('admin.menu.document_levels'),
            'items' => DocumentLevel::orderBy('sort_order')->get(),
            'routePrefix' => 'admin.document-levels',
        ]);
    }

    public function create(): View
    {
        return view('admin.taxonomy.form', [
            'title' => __('admin.actions.add_new'),
            'item' => new DocumentLevel,
            'routePrefix' => 'admin.document-levels',
            'parents' => collect(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate(['name' => ['required'], 'color' => ['nullable'], 'sort_order' => ['nullable', 'integer']]);
        $data['slug'] = Str::slug($data['name']);
        DocumentLevel::create($data);

        return redirect()->route('admin.document-levels.index')->with('success', __('admin.messages.saved'));
    }

    public function edit(DocumentLevel $documentLevel): View
    {
        return view('admin.taxonomy.form', [
            'title' => __('admin.actions.edit'),
            'item' => $documentLevel,
            'routePrefix' => 'admin.document-levels',
            'parents' => collect(),
        ]);
    }

    public function update(Request $request, DocumentLevel $documentLevel): RedirectResponse
    {
        $documentLevel->update($request->validate(['name' => ['required'], 'slug' => ['required'], 'color' => ['nullable'], 'sort_order' => ['nullable', 'integer']]));

        return redirect()->route('admin.document-levels.index')->with('success', __('admin.messages.updated'));
    }

    public function destroy(DocumentLevel $documentLevel): RedirectResponse
    {
        $documentLevel->delete();

        return back()->with('success', __('admin.messages.deleted'));
    }
}
