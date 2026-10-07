@extends('front.layouts.app')

@section('content')
<article class="container py-4">
    <h1 class="mb-3">{{ $item->title }}</h1>
    <p class="text-muted small">{{ $item->published_at?->format('d/m/Y H:i') }}</p>
    <div class="content-body">{!! $item->content !!}</div>
</article>
@endsection
