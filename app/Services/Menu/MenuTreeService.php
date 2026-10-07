<?php

namespace App\Services\Menu;

use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Support\Collection;

class MenuTreeService
{
    /**
     * @return Collection<int, MenuItem>
     */
    public function rootItems(Menu $menu): Collection
    {
        return $menu->items()->with(['children' => fn ($q) => $q->with('children')])->get();
    }

    /**
     * @param  list<array<string, mixed>>  $nodes
     */
    public function syncTree(Menu $menu, array $nodes): void
    {
        $seenIds = [];
        $this->walk($menu, $nodes, null, 0, $seenIds);
        $menu->allItems()->whereNotIn('id', $seenIds)->delete();
    }

    /**
     * @param  list<array<string, mixed>>  $nodes
     * @param  list<int>  $seenIds
     */
    private function walk(Menu $menu, array $nodes, ?int $parentId, int $depth, array &$seenIds): void
    {
        foreach ($nodes as $order => $node) {
            $payload = [
                'label' => (string) ($node['label'] ?? 'Mục menu'),
                'url' => $node['url'] ?? null,
                'icon' => $node['icon'] ?? null,
                'target' => $node['target'] ?? null,
                'css_class' => $node['css_class'] ?? null,
                'parent_id' => $parentId,
                'sort_order' => (int) ($node['sort_order'] ?? $order),
            ];

            $id = $node['id'] ?? null;
            if ($id && MenuItem::query()->where('menu_id', $menu->id)->whereKey($id)->exists()) {
                MenuItem::query()->whereKey($id)->update($payload);
                $itemId = (int) $id;
            } else {
                $item = $menu->allItems()->create($payload);
                $itemId = $item->id;
            }

            $seenIds[] = $itemId;

            $children = $node['children'] ?? [];
            if (is_array($children) && $children !== []) {
                $this->walk($menu, $children, $itemId, $depth + 1, $seenIds);
            }
        }
    }
}
