@extends('front.layouts.app')

@section('content')
<article class="container py-4">
    <p class="small text-muted">{{ $item->libraryType?->name }}</p>
    <h1 class="mb-3">{{ $item->title }}</h1>
    @if($item->author_name)<p class="text-muted">Tác giả: {{ $item->author_name }}</p>@endif
    <div class="content-body mb-4">{!! $item->content !!}</div>
    @if($item->external_url)
        <a href="{{ $item->external_url }}" class="btn btn-primary" target="_blank" rel="noopener">Mở liên kết</a>
    @elseif($item->fileMedia)
        <a href="{{ $item->fileMedia->url() }}" class="btn btn-primary" download>Tải tài liệu</a>
    @endif
</article>
@endsection
