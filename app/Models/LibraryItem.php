<?php

namespace App\Models;

use App\Models\Concerns\BaseContentModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LibraryItem extends BaseContentModel
{
    public function libraryType(): BelongsTo
    {
        return $this->belongsTo(LibraryType::class);
    }

    public function fileMedia(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'file_media_id');
    }
}
