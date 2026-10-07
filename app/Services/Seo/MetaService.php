<?php

namespace App\Services\Seo;

use App\Models\Concerns\BaseContentModel;
use App\Services\Content\ContentUrlService;
use App\Services\Settings\SettingsService;
use Illuminate\Support\Facades\URL;

class MetaService
{
    public function __construct(
        private SettingsService $settings,
        private ContentUrlService $contentUrls,
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function forHome(): array
    {
        return $this->build([
            'title' => (string) $this->settings->get('seo_default_title', config('app.name')),
            'description' => (string) $this->settings->get('seo_default_description', ''),
            'type' => 'website',
            'url' => url('/'),
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    public function forContent(BaseContentModel $model): array
    {
        $url = $this->contentUrls->for($model);
        $image = $model->featuredImage?->url('large') ?? $model->featuredImage?->url();

        return $this->build([
            'title' => $model->seoTitle(),
            'description' => $model->seoDescription(),
            'type' => 'article',
            'url' => $url,
            'image' => $image,
            'published_time' => $model->published_at?->toIso8601String(),
            'modified_time' => $model->updated_at?->toIso8601String(),
            'author' => $model->author?->name,
        ], $this->articleJsonLd($model, $url, $image));
    }

    /**
     * @return array<string, mixed>
     */
    public function forPage(BaseContentModel $page): array
    {
        $url = $this->contentUrls->for($page);

        return $this->build([
            'title' => $page->seoTitle(),
            'description' => $page->seoDescription(),
            'type' => 'website',
            'url' => $url,
            'image' => $page->featuredImage?->url('large'),
        ], $this->webPageJsonLd($page, $url));
    }

    /**
     * @return array<string, mixed>
     */
    public function forGeneric(string $title, ?string $description = null, ?string $url = null): array
    {
        return $this->build([
            'title' => $title,
            'description' => $description,
            'type' => 'website',
            'url' => $url ?? URL::current(),
        ]);
    }

    /**
     * @param  list<array<string, mixed>>|null  $extraJsonLd
     * @return array<string, mixed>
     */
    private function build(array $overrides, ?array $extraJsonLd = null): array
    {
        $siteName = (string) $this->settings->get('site_name', config('app.name'));
        $title = $overrides['title'] ?? $siteName;
        $url = $overrides['url'] ?? URL::current();
        $description = $overrides['description'] ?? null;
        $image = $overrides['image'] ?? $this->settings->get('seo_default_image');
        if ($image && ! str_starts_with((string) $image, 'http')) {
            $image = url($image);
        }

        $jsonLd = [
            $this->organizationJsonLd($siteName),
        ];

        if (($overrides['type'] ?? '') === 'website' && ($url === url('/') || rtrim($url, '/') === rtrim(url('/'), '/'))) {
            $jsonLd[] = $this->websiteJsonLd($siteName, $url);
        }

        if ($extraJsonLd) {
            $jsonLd[] = $extraJsonLd;
        }

        return [
            'title' => $title,
            'description' => $description,
            'site_name' => $siteName,
            'type' => $overrides['type'] ?? 'website',
            'url' => $url,
            'canonical' => $url,
            'locale' => 'vi_VN',
            'image' => $image,
            'published_time' => $overrides['published_time'] ?? null,
            'modified_time' => $overrides['modified_time'] ?? null,
            'author' => $overrides['author'] ?? null,
            'robots' => $this->settings->get('seo_robots', 'index, follow'),
            'twitter_card' => 'summary_large_image',
            'json_ld' => $jsonLd,
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function organizationJsonLd(string $siteName): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => $siteName,
            'url' => url('/'),
            'logo' => $this->settings->get('site_logo_url') ? url((string) $this->settings->get('site_logo_url')) : null,
            'address' => [
                '@type' => 'PostalAddress',
                'addressLocality' => $this->settings->get('contact_address'),
            ],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function websiteJsonLd(string $siteName, string $url): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'name' => $siteName,
            'url' => $url,
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => route('front.search').'?q={search_term_string}',
                'query-input' => 'required name=search_term_string',
            ],
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function articleJsonLd(BaseContentModel $model, string $url, ?string $image): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => $model->seoTitle(),
            'description' => $model->seoDescription(),
            'datePublished' => $model->published_at?->toIso8601String(),
            'dateModified' => $model->updated_at?->toIso8601String(),
            'author' => [
                '@type' => 'Person',
                'name' => $model->author?->name ?? $this->settings->get('site_name'),
            ],
            'image' => $image,
            'mainEntityOfPage' => $url,
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function webPageJsonLd(BaseContentModel $page, string $url): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'WebPage',
            'name' => $page->seoTitle(),
            'description' => $page->seoDescription(),
            'url' => $url,
        ];
    }
}
