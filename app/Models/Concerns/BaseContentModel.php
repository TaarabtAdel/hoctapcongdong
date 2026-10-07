<?php

namespace App\Models\Concerns;

use App\Enums\ContentStatus;
use App\Support\Concerns\HasAuthor;
use App\Support\Concerns\HasFeaturedImage;
use App\Support\Concerns\HasRevisions;
use App\Support\Concerns\HasSeo;
use App\Support\Concerns\HasSlug;
use App\Support\Concerns\HasStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

abstract class BaseContentModel extends Model
{
    protected $guarded = ['id'];

    use HasAuthor;
    use HasFeaturedImage;
    use HasRevisions;
    use HasSeo;
    use HasSlug;
    use HasStatus;
    use SoftDeletes;

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
            'is_featured' => 'boolean',
            'view_count' => 'integer',
            'sort_order' => 'integer',
            'status' => ContentStatus::class,
        ];
    }

    /**
     * @return list<string>
     */
    public function revisionFields(): array
    {
        return ['title', 'slug', 'excerpt', 'content', 'status', 'published_at', 'seo_title', 'seo_description'];
    }
}
