<?php

namespace App\Services\Media;

use App\Models\Media;
use Illuminate\Support\Facades\DB;

class MediaUsageService
{
    /**
     * @return list<string>
     */
    public function references(int $mediaId): array
    {
        $refs = [];
        $tables = [
            'pages', 'news', 'announcements', 'events', 'programs', 'role_models',
            'learning_models', 'library_items', 'documents', 'galleries',
        ];
        foreach ($tables as $table) {
            $count = DB::table($table)->where('featured_image_id', $mediaId)->count();
            if ($count) {
                $refs[] = "{$table} (ảnh đại diện): {$count}";
            }
        }

        return $refs;
    }

    public function canDelete(Media $media): bool
    {
        return count($this->references($media->id)) === 0;
    }
}
