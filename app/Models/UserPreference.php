<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserPreference extends Model
{
    protected $guarded = ['id'];

    protected function casts(): array
    {
        return ['value' => 'array'];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return array<string, mixed>|null
     */
    public static function valueFor(int $userId, string $key): ?array
    {
        $row = static::query()->where('user_id', $userId)->where('key', $key)->first();

        return $row?->value;
    }

    /**
     * @param  array<string, mixed>  $value
     */
    public static function storeFor(int $userId, string $key, array $value): void
    {
        static::query()->updateOrCreate(
            ['user_id' => $userId, 'key' => $key],
            ['value' => $value]
        );
    }
}
