<?php

namespace App\Policies;

class ProgramPolicy extends BaseContentPolicy
{
    protected function module(): string
    {
        return 'programs';
    }
}
