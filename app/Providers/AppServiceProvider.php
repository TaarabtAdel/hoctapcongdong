<?php

namespace App\Providers;

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
use App\Observers\ContentCacheObserver;
use App\Services\Settings\SettingsService;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(SettingsService::class);
    }

    public function boot(): void
    {
        foreach ([
            News::class, Page::class, Announcement::class, Event::class, Program::class,
            RoleModel::class, LearningModel::class, LibraryItem::class, Document::class, Gallery::class,
        ] as $modelClass) {
            $modelClass::observe(ContentCacheObserver::class);
        }

        Gate::before(function ($user, $ability) {
            return $user?->hasRole('super_admin') ? true : null;
        });

        View::composer(['front.*', 'admin.*'], function ($view): void {
            $settings = app(SettingsService::class)->all();
            $view->with('siteSettings', $settings);
            if (! $view->offsetExists('meta')) {
                $view->with('meta', [
                    'title' => $settings['seo_default_title'] ?? config('app.name'),
                    'description' => $settings['seo_default_description'] ?? null,
                ]);
            }
        });
    }
}
