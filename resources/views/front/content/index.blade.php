@extends('front.layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="h3 mb-4">{{ $title }}</h1>
    <div class="list-group">
        @foreach($items as $item)
            <a href="{{ $showRoute($item) }}" class="list-group-item list-group-item-action">
                <div class="d-flex w-100 justify-content-between">
                    <h2 class="h6 mb-1">{{ $item->title }}</h2>
                    <small>{{ $item->published_at?->format('d/m/Y') }}</small>
                </div>
                <p class="mb-1 small text-muted">{{ $item->excerpt }}</p>
            </a>
        @endforeach
    </div>
    {{ $items->links() }}
</div>
@endsection
