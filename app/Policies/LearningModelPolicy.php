<?php

namespace App\Policies;

class LearningModelPolicy extends BaseContentPolicy
{
    protected function module(): string
    {
        return 'learning_models';
    }
}
