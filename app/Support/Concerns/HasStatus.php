<?php

namespace App\Support\Concerns;

use App\Enums\ContentStatus;
use Illuminate\Database\Eloquent\Builder;

trait HasStatus
{
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', ContentStatus::Published->value)
            ->where(function (Builder $q): void {
                $q->whereNull('published_at')->orWhere('published_at', '<=', now());
            });
    }

    public function scopeStatus(Builder $query, ?string $status): Builder
    {
        if ($status === 'trash') {
            return $query->onlyTrashed();
        }

        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }

        return $query;
    }

    public function isPubliclyVisible(): bool
    {
        if ($this->status === ContentStatus::Private->value) {
            return false;
        }

        if ($this->status !== ContentStatus::Published->value) {
            return false;
        }

        return ! $this->published_at || $this->published_at->lte(now());
    }
}
