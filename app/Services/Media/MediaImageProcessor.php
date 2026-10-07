<?php

namespace App\Services\Media;

use App\Models\Media;
use App\Services\Settings\SettingsService;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class MediaImageProcessor
{
    public function __construct(private SettingsService $settings) {}

    public function process(Media $media, string $fullPath): void
    {
        $manager = new ImageManager(new Driver);
        $image = $manager->read($fullPath);
        $media->width = $image->width();
        $media->height = $image->height();

        $sizes = [
            'thumbnail' => (int) $this->settings->get('media_thumbnail', 150),
            'medium' => (int) $this->settings->get('media_medium', 300),
            'large' => (int) $this->settings->get('media_large', 1024),
        ];

        $variants = [];
        $dir = dirname($media->path);
        $base = pathinfo($media->filename, PATHINFO_FILENAME);
        $quality = (int) $this->settings->get('media_quality', 85);

        foreach ($sizes as $name => $width) {
            $variantPath = $dir.'/'.$base.'-'.$name.'.webp';
            $clone = clone $image;
            $clone->scaleDown(width: $width);
            $clone->toWebp($quality)->save(storage_path('app/public/'.$variantPath));
            $variants[$name] = $variantPath;
        }

        $media->variants = $variants;
        $media->save();
    }
}
