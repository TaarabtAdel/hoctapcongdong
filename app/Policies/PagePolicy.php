<?php

namespace App\Policies;

class PagePolicy extends BaseContentPolicy
{
    protected function module(): string
    {
        return 'pages';
    }
}
