<?php

namespace App\Http\Controllers\Front;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EventController extends ContentListController
{
    protected function modelClass(): string
    {
        return Event::class;
    }

    protected function title(): string
    {
        return __('front.menu.events');
    }

    protected function routeShow(string $slug): string
    {
        return route('front.events.show', $slug);
    }

    public function calendar(Request $request): View
    {
        $month = Carbon::parse($request->input('thang', now()->format('Y-m')).'-01');
        $start = $month->copy()->startOfMonth();
        $end = $month->copy()->endOfMonth();
        $events = Event::published()
            ->whereBetween('start_at', [$start, $end])
            ->orderBy('start_at')
            ->get();

        return view('front.events.calendar', [
            'month' => $month,
            'events' => $events,
            'meta' => ['title' => __('front.menu.events').' — Lịch tháng'],
        ]);
    }
}
