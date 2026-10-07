<?php

namespace App\Policies;

class NewsPolicy extends BaseContentPolicy
{
    protected function module(): string
    {
        return 'news';
    }
}
