<?php

namespace App\Models;

use App\Models\Concerns\BaseContentModel;

class Announcement extends BaseContentModel
{
    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            'is_pinned' => 'boolean',
            'expires_at' => 'datetime',
        ]);
    }
}
