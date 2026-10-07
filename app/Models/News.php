<?php

namespace App\Models;

use App\Models\Concerns\BaseContentModel;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class News extends BaseContentModel
{
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(NewsCategory::class, 'news_category_news');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'news_tag');
    }
}
