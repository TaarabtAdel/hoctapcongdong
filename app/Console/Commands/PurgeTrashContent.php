<?php

namespace App\Console\Commands;

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

class PurgeTrashContent extends Command
{
    protected $signature = 'trash:purge {--days=30}';

    protected $description = 'Xóa vĩnh viễn nội dung trong thùng rác quá số ngày quy định';

    public function handle(): int
    {
        $before = now()->subDays((int) $this->option('days'));
        $models = [News::class, Page::class, Announcement::class, Event::class, Program::class, RoleModel::class, LearningModel::class, LibraryItem::class, Document::class, Gallery::class];
        $count = 0;
        foreach ($models as $model) {
            $count += $model::onlyTrashed()->where('deleted_at', '<', $before)->forceDelete();
        }
        $this->info("Purged {$count} records.");

        return self::SUCCESS;
    }
}
