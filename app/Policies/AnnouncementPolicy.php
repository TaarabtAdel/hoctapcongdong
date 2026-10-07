<?php

namespace App\Policies;

class AnnouncementPolicy extends BaseContentPolicy
{
    protected function module(): string
    {
        return 'announcements';
    }
}
