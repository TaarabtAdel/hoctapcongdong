<?php

namespace App\Policies;

use App\Models\Concerns\BaseContentModel;
use App\Models\User;

abstract class BaseContentPolicy
{
    abstract protected function module(): string;

    public function viewAny(User $user): bool
    {
        return $user->can("{$this->module()}.view") || $user->can("manage_{$this->module()}");
    }

    public function view(User $user, BaseContentModel $model): bool
    {
        return $this->viewAny($user);
    }

    public function create(User $user): bool
    {
        return $user->can("{$this->module()}.create") || $user->can("manage_{$this->module()}");
    }

    public function update(User $user, BaseContentModel $model): bool
    {
        if ($user->can("manage_{$this->module()}") || $user->can("{$this->module()}.edit_others")) {
            return true;
        }

        return $user->can("{$this->module()}.edit") && (int) $model->author_id === (int) $user->id;
    }

    public function publish(User $user, BaseContentModel $model): bool
    {
        return $user->can("{$this->module()}.publish") || $user->can("manage_{$this->module()}");
    }

    public function delete(User $user, BaseContentModel $model): bool
    {
        return $user->can("{$this->module()}.delete") || $user->can("manage_{$this->module()}");
    }

    public function restore(User $user, BaseContentModel $model): bool
    {
        return $user->can("{$this->module()}.restore") || $user->can("manage_{$this->module()}");
    }

    public function forceDelete(User $user, BaseContentModel $model): bool
    {
        return $user->can("{$this->module()}.force_delete") || $user->can("manage_{$this->module()}");
    }
}
