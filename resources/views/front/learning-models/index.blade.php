@extends('front.layouts.app')
@section('content')
<div class="container py-4"><h1 class="h3 mb-4">{{ __('front.menu.lifelong') }}</h1>
<div class="row">@foreach($items as $item)<div class="col-md-6 mb-3"><div class="card-soft p-4"><h2 class="h5">{{ $item->title }}</h2><div>{!! $item->criteria !!}</div><a href="{{ route('front.learning-models.show', $item->slug) }}">Chi tiết</a></div></div>@endforeach</div>
</div>
@endsection
