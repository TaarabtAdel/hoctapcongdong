<?php

namespace App\Policies;

class RoleModelPolicy extends BaseContentPolicy
{
    protected function module(): string
    {
        return 'role_models';
    }
}
