<?php

namespace App\Models;

use App\Models\Concerns\BaseContentModel;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Gallery extends BaseContentModel
{
    public function items(): HasMany
    {
        return $this->hasMany(GalleryItem::class)->orderBy('sort_order');
    }
}
