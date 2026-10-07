@extends('front.layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="h3 font-weight-bold mb-4">{{ __('front.home.gallery') }}</h1>
    <div class="row">
        @foreach($galleries as $gallery)
            <div class="col-md-6 mb-4">
                <a href="{{ route('front.gallery.show', $gallery->slug) }}" class="d-block card-soft overflow-hidden">
                    @php $cover = $gallery->items->first()?->media; @endphp
                    @if($cover)
                        <img src="{{ $cover->url('medium') }}" alt="" class="img-fluid w-100" style="max-height:220px;object-fit:cover" loading="lazy">
                    @endif
                    <div class="p-3">
                        <h2 class="h6 mb-0">{{ $gallery->title }}</h2>
                        <span class="small text-muted">{{ $gallery->items->count() }} mục</span>
                    </div>
                </a>
            </div>
        @endforeach
    </div>
    {{ $galleries->links() }}
</div>
@endsection
