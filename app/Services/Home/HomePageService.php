<?php

namespace App\Services\Home;

use App\Models\Announcement;
use App\Models\Document;
use App\Models\Event;
use App\Models\Gallery;
use App\Models\LearningModel;
use App\Models\LibraryType;
use App\Models\News;
use App\Models\Program;
use App\Models\Slide;
use App\Services\Settings\SettingsService;
use Illuminate\Support\Facades\Cache;

class HomePageService
{
    public function __construct(private SettingsService $settings) {}

    /**
     * @return array<string, mixed>
     */
    public function blocks(): array
    {
        return Cache::remember('homepage.blocks', 3600, function (): array {
            return [
                'announcements' => Announcement::published()->orderByDesc('is_pinned')->orderByDesc('published_at')
                    ->limit((int) $this->settings->get('home_announcements', 3))->get(),
                'events' => Event::published()->orderBy('start_at')
                    ->limit((int) $this->settings->get('home_events', 3))->get(),
                'programs' => Program::published()->orderBy('sort_order')->limit(6)->get(),
                'libraryTypes' => LibraryType::orderBy('sort_order')->get(),
                'news' => News::published()->orderByDesc('published_at')
                    ->limit((int) $this->settings->get('home_news', 2))->get(),
                'learningModels' => LearningModel::published()->orderBy('sort_order')->limit(4)->get(),
                'documents' => Document::published()->with('documentLevel')->orderByDesc('issued_at')
                    ->limit((int) $this->settings->get('home_documents', 5))->get(),
                'galleries' => Gallery::published()->with('items.media')->orderByDesc('published_at')->limit(1)->get(),
                'heroSlides' => Slide::query()
                    ->whereHas('slider', fn ($q) => $q->where('location', 'hero')->where('is_active', true))
                    ->where('is_active', true)->orderBy('sort_order')->get(),
            ];
        });
    }
}
