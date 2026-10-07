@extends('front.layouts.app')
@section('content')
<article class="container py-4"><h1>{{ $page->title }}</h1><div>{!! $page->content !!}</div></article>
@endsection
