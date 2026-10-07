<?php

namespace App\Policies;

class EventPolicy extends BaseContentPolicy
{
    protected function module(): string
    {
        return 'events';
    }
}
