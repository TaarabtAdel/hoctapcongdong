@extends('front.layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="h3 font-weight-bold mb-3">{{ __('front.menu.library') }}</h1>
    <div class="mb-4">
        <a href="{{ route('front.library.index') }}" class="btn btn-sm {{ $activeType === '' ? 'btn-primary' : 'btn-outline-secondary' }} mr-1 mb-1">Tất cả</a>
        @foreach($types as $type)
            <a href="{{ route('front.library.index', ['loai' => $type->slug]) }}" class="btn btn-sm {{ $activeType === $type->slug ? 'btn-primary' : 'btn-outline-secondary' }} mr-1 mb-1">{{ $type->name }}</a>
        @endforeach
    </div>
    <div class="row">
        @forelse($items as $item)
            <div class="col-md-4 mb-4">
                <article class="card-soft h-100 p-3">
                    <h2 class="h6"><a href="{{ route('front.library.show', $item->slug) }}">{{ $item->title }}</a></h2>
                    <p class="small text-muted mb-2">{{ $item->libraryType?->name }} · {{ $item->author_name }}</p>
                    <p class="small mb-0">{{ $item->excerpt }}</p>
                </article>
            </div>
        @empty
            <p class="text-muted">Chưa có tài liệu.</p>
        @endforelse
    </div>
    {{ $items->links() }}
</div>
@endsection
