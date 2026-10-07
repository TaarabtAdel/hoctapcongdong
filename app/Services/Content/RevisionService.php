<?php

namespace App\Services\Content;

use App\Models\Concerns\BaseContentModel;
use App\Models\Revision;
use Illuminate\Support\Facades\Auth;

class RevisionService
{
    public function restore(Revision $revision): BaseContentModel
    {
        /** @var BaseContentModel $model */
        $model = $revision->revisionable;
        $payload = $revision->payload ?? [];
        $model->fill($payload);
        $model->save();

        Revision::query()->create([
            'revisionable_type' => $model->getMorphClass(),
            'revisionable_id' => $model->getKey(),
            'user_id' => Auth::id(),
            'payload' => $model->only($model->revisionFields()),
        ]);

        return $model->fresh();
    }
}
