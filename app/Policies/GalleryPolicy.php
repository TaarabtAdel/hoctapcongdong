<?php

namespace App\Policies;

class GalleryPolicy extends BaseContentPolicy
{
    protected function module(): string
    {
        return 'galleries';
    }
}
