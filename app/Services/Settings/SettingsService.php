<?php

namespace App\Services\Settings;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SettingsService
{
    private const CACHE_KEY = 'app.settings.all';

    public function get(string $key, mixed $default = null): mixed
    {
        $all = $this->all();

        return array_key_exists($key, $all) ? $all[$key] : $default;
    }

    public function set(string $key, mixed $value, string $group = 'general'): void
    {
        Setting::query()->updateOrCreate(
            ['key' => $key],
            ['value' => is_array($value) ? json_encode($value, JSON_UNESCAPED_UNICODE) : (string) $value, 'group' => $group]
        );
        $this->flush();
    }

    /**
     * @param  array<string, mixed>  $pairs
     */
    public function setMany(array $pairs, string $group = 'general'): void
    {
        foreach ($pairs as $key => $value) {
            $this->set($key, $value, $group);
        }
    }

    /**
     * @return array<string, mixed>
     */
    public function all(): array
    {
        return Cache::rememberForever(self::CACHE_KEY, function (): array {
            $settings = [];
            foreach (Setting::query()->get(['key', 'value']) as $row) {
                $decoded = json_decode($row->value, true);
                $settings[$row->key] = json_last_error() === JSON_ERROR_NONE ? $decoded : $row->value;
            }

            return $settings;
        });
    }

    public function flush(): void
    {
        Cache::forget(self::CACHE_KEY);
        Cache::forget('homepage.blocks');
        Cache::forget('menus.all');
    }

    public function adminPath(): string
    {
        return trim((string) $this->get('admin_path', config('htcd.admin_path', 'admin')), '/');
    }

    public function permalink(string $type): string
    {
        return trim((string) $this->get("permalink.{$type}", $type), '/');
    }
}
