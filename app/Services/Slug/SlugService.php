<?php

namespace App\Services\Slug;

use App\Models\Redirect;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SlugService
{
    public function generate(string $title, ?Model $model = null, ?string $column = 'slug'): string
    {
        $base = Str::slug($title);
        if ($base === '') {
            $base = 'noi-dung';
        }

        $slug = $base;
        $i = 2;
        while ($this->exists($slug, $model, $column)) {
            $slug = $base.'-'.$i;
            $i++;
        }

        return $slug;
    }

    public function exists(string $slug, ?Model $model, string $column = 'slug'): bool
    {
        if (! $model) {
            return false;
        }

        $query = $model->newQuery()->where($column, $slug);
        if ($model->exists) {
            $query->whereKeyNot($model->getKey());
        }

        return $query->exists();
    }

    public function registerRedirect(string $fromPath, string $toPath): void
    {
        if ($fromPath === $toPath) {
            return;
        }

        Redirect::query()->updateOrCreate(
            ['from_path' => '/'.trim($fromPath, '/')],
            ['to_path' => '/'.trim($toPath, '/'), 'status_code' => 301]
        );
    }
}
