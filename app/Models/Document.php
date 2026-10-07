<?php

namespace App\Models;

use App\Models\Concerns\BaseContentModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Document extends BaseContentModel
{
    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            'issued_at' => 'date',
            'download_count' => 'integer',
        ]);
    }

    public function documentLevel(): BelongsTo
    {
        return $this->belongsTo(DocumentLevel::class);
    }

    public function fileMedia(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'file_media_id');
    }
}
