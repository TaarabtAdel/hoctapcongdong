<?php

namespace App\Policies;

class LibraryItemPolicy extends BaseContentPolicy
{
    protected function module(): string
    {
        return 'library';
    }
}
