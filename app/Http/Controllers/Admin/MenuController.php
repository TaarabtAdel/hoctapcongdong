<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Services\Menu\MenuTreeService;
use App\Services\Settings\SettingsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MenuController extends Controller
{
    public function index(): View
    {
        return view('admin.menus.index', ['menus' => Menu::withCount('allItems')->get()]);
    }

    public function create(): View
    {
        return view('admin.menus.form', ['menu' => new Menu]);
    }

    public function store(Request $request): RedirectResponse
    {
        $menu = Menu::create($request->validate(['name' => ['required'], 'location' => ['nullable']]));
        app(SettingsService::class)->flush();

        return redirect()->route('admin.menus.edit', $menu)->with('success', __('admin.messages.saved'));
    }

    public function edit(Menu $menu): View
    {
        $menu->load(['items' => fn ($q) => $q->with(['children' => fn ($c) => $c->with('children')->orderBy('sort_order')])->orderBy('sort_order')]);

        return view('admin.menus.form', compact('menu'));
    }

    public function update(Request $request, Menu $menu, MenuTreeService $treeService): RedirectResponse
    {
        $menu->update($request->validate(['name' => ['required'], 'location' => ['nullable']]));

        if ($request->filled('items_tree')) {
            $tree = json_decode($request->string('items_tree')->toString(), true);
            if (is_array($tree)) {
                $treeService->syncTree($menu, $tree);
            }
        }

        app(SettingsService::class)->flush();

        return back()->with('success', __('admin.messages.updated'));
    }

    public function destroy(Menu $menu): RedirectResponse
    {
        $menu->delete();

        return redirect()->route('admin.menus.index')->with('success', __('admin.messages.deleted'));
    }

    public function storeItem(Request $request, Menu $menu): JsonResponse
    {
        $data = $request->validate([
            'label' => ['required', 'string', 'max:255'],
            'url' => ['nullable', 'string', 'max:255'],
            'parent_id' => ['nullable', 'exists:menu_items,id'],
        ]);

        $item = $menu->allItems()->create([
            'label' => $data['label'],
            'url' => $data['url'] ?? '#',
            'parent_id' => $data['parent_id'] ?? null,
            'sort_order' => (int) $menu->allItems()->max('sort_order') + 1,
        ]);

        app(SettingsService::class)->flush();

        return response()->json(['item' => $item]);
    }

    public function destroyItem(Menu $menu, MenuItem $item): JsonResponse
    {
        abort_unless($item->menu_id === $menu->id, 404);
        $item->delete();
        app(SettingsService::class)->flush();

        return response()->json(['ok' => true]);
    }
}
