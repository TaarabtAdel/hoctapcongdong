<?php

namespace App\Observers;

use App\Models\Concerns\BaseContentModel;
use App\Services\Settings\SettingsService;

class ContentCacheObserver
{
    public function saved(BaseContentModel $model): void
    {
        app(SettingsService::class)->flush();
    }

    public function deleted(BaseContentModel $model): void
    {
        app(SettingsService::class)->flush();
    }
}
