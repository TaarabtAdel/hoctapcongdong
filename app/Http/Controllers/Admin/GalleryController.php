<?php

namespace App\Http\Controllers\Admin;

use App\Models\Concerns\BaseContentModel;
use App\Models\Gallery;
use App\Models\GalleryItem;
use Illuminate\Http\Request;

class GalleryController extends BaseContentController
{
    protected function modelClass(): string
    {
        return Gallery::class;
    }

    protected function permissionModule(): string
    {
        return 'galleries';
    }

    protected function contentType(): string
    {
        return 'gallery';
    }

    protected function routePrefix(): string
    {
        return 'admin.galleries';
    }

    protected function viewPrefix(): string
    {
        return 'admin.content';
    }

    protected function singularLabel(): string
    {
        return __('admin.menu.galleries');
    }

    protected function formViewData(BaseContentModel $item): array
    {
        if ($item instanceof Gallery && $item->exists) {
            $item->load('items.media');
        }

        return ['galleryItems' => ($item instanceof Gallery && $item->exists) ? $item->items : collect()];
    }

    protected function afterSave(BaseContentModel $item, Request $request): void
    {
        if (! $item instanceof Gallery) {
            return;
        }

        $rows = $request->input('gallery_items', []);
        $keepIds = [];
        foreach ($rows as $index => $row) {
            if (empty($row['media_id']) && empty($row['video_url'])) {
                continue;
            }
            $payload = [
                'type' => $row['type'] ?? 'image',
                'media_id' => $row['media_id'] ?: null,
                'video_url' => $row['video_url'] ?? null,
                'caption' => $row['caption'] ?? null,
                'sort_order' => (int) ($row['sort_order'] ?? $index),
            ];
            if (! empty($row['id'])) {
                $gi = GalleryItem::query()->where('gallery_id', $item->id)->whereKey($row['id'])->first();
                if ($gi) {
                    $gi->update($payload);
                    $keepIds[] = $gi->id;
                }
            } else {
                $gi = $item->items()->create($payload);
                $keepIds[] = $gi->id;
            }
        }
        $item->items()->whereNotIn('id', $keepIds)->delete();
    }
}
