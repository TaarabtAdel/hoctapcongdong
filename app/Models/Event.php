<?php

namespace App\Models;

use App\Models\Concerns\BaseContentModel;

class Event extends BaseContentModel
{
    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            'start_at' => 'datetime',
            'end_at' => 'datetime',
        ]);
    }

    public function displayStatus(): string
    {
        $now = now();
        if ($this->end_at && $this->end_at->lt($now)) {
            return __('front.events.ended');
        }
        if ($this->start_at->lte($now) && (! $this->end_at || $this->end_at->gte($now))) {
            return __('front.events.ongoing');
        }

        return __('front.events.upcoming');
    }
}
