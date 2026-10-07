@extends('front.layouts.app')

@section('content')
<div class="container py-4">
    <h1 class="mb-2">{{ $gallery->title }}</h1>
    @if($gallery->excerpt)<p class="text-muted">{{ $gallery->excerpt }}</p>@endif
    <div class="row" id="gallery-lightbox">
        @foreach($gallery->items as $item)
            <div class="col-6 col-md-4 mb-3">
                @if($item->type === 'video' && $item->video_url)
                    <div class="embed-responsive embed-responsive-16by9 card-soft">
                        <iframe class="embed-responsive-item" src="{{ $item->video_url }}" title="{{ $item->caption }}" allowfullscreen loading="lazy"></iframe>
                    </div>
                @elseif($item->media)
                    <a href="{{ $item->media->url() }}" target="_blank" rel="noopener" class="d-block card-soft overflow-hidden">
                        <img src="{{ $item->media->url('medium') }}" alt="{{ $item->caption }}" class="img-fluid w-100" loading="lazy">
                    </a>
                @endif
                @if($item->caption)<div class="small mt-1">{{ $item->caption }}</div>@endif
            </div>
        @endforeach
    </div>
</div>
@endsection
