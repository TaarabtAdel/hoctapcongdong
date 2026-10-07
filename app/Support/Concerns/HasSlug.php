<?php

namespace App\Support\Concerns;

use App\Services\Slug\SlugService;
use Illuminate\Database\Eloquent\Model;

trait HasSlug
{
    public static function bootHasSlug(): void
    {
        static::saving(function (Model $model): void {
            if (empty($model->slug) && ! empty($model->title)) {
                $model->slug = app(SlugService::class)->generate($model->title, $model);
            }
        });
    }
}
