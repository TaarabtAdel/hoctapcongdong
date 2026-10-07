<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class NewsCategoryController extends Controller
{
    public function index(): View
    {
        return view('admin.taxonomy.index', [
            'title' => __('admin.menu.news_categories'),
            'items' => NewsCategory::with('parent')->orderBy('sort_order')->get(),
            'routePrefix' => 'admin.news-categories',
        ]);
    }

    public function create(): View
    {
        return view('admin.taxonomy.form', [
            'title' => __('admin.actions.add_new'),
            'item' => new NewsCategory,
            'routePrefix' => 'admin.news-categories',
            'parents' => NewsCategory::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'parent_id' => ['nullable', 'exists:news_categories,id'],
            'sort_order' => ['nullable', 'integer'],
        ]);
        $data['slug'] = $data['slug'] ?: Str::slug($data['name']);
        NewsCategory::create($data);

        return redirect()->route('admin.news-categories.index')->with('success', __('admin.messages.saved'));
    }

    public function edit(NewsCategory $newsCategory): View
    {
        return view('admin.taxonomy.form', [
            'title' => __('admin.actions.edit'),
            'item' => $newsCategory,
            'routePrefix' => 'admin.news-categories',
            'parents' => NewsCategory::whereKeyNot($newsCategory->id)->orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, NewsCategory $newsCategory): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'parent_id' => ['nullable', 'exists:news_categories,id'],
            'sort_order' => ['nullable', 'integer'],
        ]);
        $newsCategory->update($data);

        return redirect()->route('admin.news-categories.index')->with('success', __('admin.messages.updated'));
    }

    public function destroy(NewsCategory $newsCategory): RedirectResponse
    {
        $newsCategory->delete();

        return back()->with('success', __('admin.messages.deleted'));
    }
}
