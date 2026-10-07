<?php

namespace App\Services\Content;

use App\Models\Concerns\BaseContentModel;
use App\Models\Revision;
use App\Services\Settings\SettingsService;
use App\Services\Slug\SlugService;
use Illuminate\Support\Facades\Auth;
use Stevebauman\Purify\Facades\Purify;

class ContentPersistenceService
{
    public function __construct(
        private SlugService $slugService,
        private ContentUrlService $urlService,
        private SettingsService $settings,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public function fill(BaseContentModel $model, array $data): BaseContentModel
    {
        $oldSlug = $model->slug;
        $oldUrl = $model->exists ? $this->urlService->for($model) : null;

        if (isset($data['content'])) {
            $data['content'] = Purify::clean($data['content']);
        }
        if (isset($data['excerpt'])) {
            $data['excerpt'] = strip_tags($data['excerpt']);
        }

        $model->fill($data);
        if (empty($model->author_id)) {
            $model->author_id = Auth::id();
        }
        $model->save();

        if ($oldUrl && $model->slug !== $oldSlug) {
            $newUrl = parse_url($this->urlService->for($model), PHP_URL_PATH) ?: '';
            $oldPath = parse_url($oldUrl, PHP_URL_PATH) ?: '';
            $this->slugService->registerRedirect($oldPath, $newPath);
        }

        $this->storeRevision($model);
        $this->settings->flush();

        return $model;
    }

    private function storeRevision(BaseContentModel $model): void
    {
        $payload = [];
        foreach ($model->revisionFields() as $field) {
            $payload[$field] = $model->getAttribute($field);
        }

        Revision::query()->create([
            'revisionable_type' => $model->getMorphClass(),
            'revisionable_id' => $model->getKey(),
            'user_id' => Auth::id(),
            'payload' => $payload,
        ]);
    }
}
