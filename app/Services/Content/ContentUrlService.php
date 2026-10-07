<?php

namespace App\Services\Content;

use App\Models\Announcement;
use App\Models\Concerns\BaseContentModel;
use App\Models\Document;
use App\Models\Event;
use App\Models\LearningModel;
use App\Models\LibraryItem;
use App\Models\News;
use App\Models\Page;
use App\Models\Program;
use App\Models\RoleModel;
use App\Services\Settings\SettingsService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ContentUrlService
{
    public function __construct(private SettingsService $settings) {}

    public function for(Model $model): string
    {
        $slug = $model->slug ?? '';
        $prefix = match ($model::class) {
            News::class => $this->settings->permalink('tin-tuc'),
            Announcement::class => $this->settings->permalink('thong-bao'),
            Event::class => $this->settings->permalink('su-kien'),
            Program::class => $this->settings->permalink('chuong-trinh'),
            RoleModel::class => $this->settings->permalink('guong-hoc-tap'),
            LibraryItem::class => $this->settings->permalink('thu-vien-so'),
            Document::class => $this->settings->permalink('van-ban'),
            LearningModel::class => $this->settings->permalink('mo-hinh'),
            Page::class => '',
            default => Str::kebab(class_basename($model)),
        };

        if ($model instanceof BaseContentModel && $prefix === '') {
            return url('/'.$slug);
        }

        return url('/'.trim($prefix.'/'.$slug, '/'));
    }
}
