<?php

namespace App\Enums;

enum ContentStatus: string
{
    case Draft = 'draft';
    case Pending = 'pending';
    case Published = 'published';
    case Scheduled = 'scheduled';
    case Private = 'private';

    public function label(): string
    {
        return match ($this) {
            self::Draft => __('content.status.draft'),
            self::Pending => __('content.status.pending'),
            self::Published => __('content.status.published'),
            self::Scheduled => __('content.status.scheduled'),
            self::Private => __('content.status.private'),
        };
    }

    /**
     * @return list<string>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
