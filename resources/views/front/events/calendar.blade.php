@extends('front.layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 font-weight-bold mb-0">Lịch tháng {{ $month->format('m/Y') }}</h1>
        <div>
            <a href="{{ route('front.events.calendar', ['thang' => $month->copy()->subMonth()->format('Y-m')]) }}" class="btn btn-sm btn-outline-secondary">&laquo; Tháng trước</a>
            <a href="{{ route('front.events.calendar', ['thang' => $month->copy()->addMonth()->format('Y-m')]) }}" class="btn btn-sm btn-outline-secondary">Tháng sau &raquo;</a>
        </div>
    </div>
    <a href="{{ route('front.events.index') }}" class="btn btn-link btn-sm mb-3">← Danh sách sự kiện</a>
    <ul class="list-group">
        @forelse($events as $event)
            <li class="list-group-item">
                <strong>{{ $event->start_at?->format('d/m/Y H:i') }}</strong> —
                <a href="{{ route('front.events.show', $event->slug) }}">{{ $event->title }}</a>
                @if($event->location)<span class="text-muted small"> · {{ $event->location }}</span>@endif
            </li>
        @empty
            <li class="list-group-item text-muted">Không có sự kiện trong tháng này.</li>
        @endforelse
    </ul>
</div>
@endsection
