<?php

namespace App\Policies;

class DocumentPolicy extends BaseContentPolicy
{
    protected function module(): string
    {
        return 'documents';
    }
}
