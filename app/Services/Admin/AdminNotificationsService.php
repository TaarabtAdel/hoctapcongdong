<?php

namespace App\Services\Admin;

use App\Models\ContactMessage;
use App\Models\Registration;
use Illuminate\Support\Collection;

class AdminNotificationsService
{
    /**
     * @return array{total: int, items: Collection<int, object>}
     */
    public function feed(int $limit = 8): array
    {
        $registrations = Registration::query()
            ->where('status', 'new')
            ->latest()
            ->limit($limit)
            ->get()
            ->map(fn ($r) => (object) [
                'type' => 'registration',
                'label' => 'Đăng ký mới: '.$r->full_name,
                'url' => route('admin.registrations.show', $r),
                'at' => $r->created_at,
            ]);

        $contacts = ContactMessage::query()
            ->where('is_read', false)
            ->latest()
            ->limit($limit)
            ->get()
            ->map(fn ($c) => (object) [
                'type' => 'contact',
                'label' => 'Liên hệ: '.($c->subject ?: $c->full_name),
                'url' => route('admin.contacts.show', $c),
                'at' => $c->created_at,
            ]);

        $items = $registrations->concat($contacts)->sortByDesc('at')->take($limit)->values();

        return [
            'total' => Registration::where('status', 'new')->count() + ContactMessage::where('is_read', false)->count(),
            'items' => $items,
        ];
    }
}
