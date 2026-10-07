<?php

namespace App\Console\Commands;

use App\Enums\ContentStatus;
use App\Models\Announcement;
use App\Models\Document;
use App\Models\Event;
use App\Models\Gallery;
use App\Models\LearningModel;
use App\Models\LibraryItem;
use App\Models\News;
use App\Models\Page;
use App\Models\Program;
use App\Models\RoleModel;
use Illuminate\Console\Command;

class PublishScheduledContent extends Command
{
    protected $signature = 'content:publish-scheduled';

    protected $description = 'Chuyển nội dung scheduled sang published khi đến giờ';

    public function handle(): int
    {
        $models = [News::class, Page::class, Announcement::class, Event::class, Program::class, RoleModel::class, LearningModel::class, LibraryItem::class, Document::class, Gallery::class];
        $count = 0;
        foreach ($models as $model) {
            $count += $model::query()
                ->where('status', ContentStatus::Scheduled->value)
                ->where('published_at', '<=', now())
                ->update(['status' => ContentStatus::Published->value]);
        }
        $this->info("Published {$count} items.");

        return self::SUCCESS;
    }
}
