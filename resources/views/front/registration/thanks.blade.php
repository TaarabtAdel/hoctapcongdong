@extends('front.layouts.app')
@section('content')
<div class="container py-5 text-center">
<h1 class="h3">{{ __('front.registration.thanks') }}</h1>
<p>{{ __('front.registration.thanks_body') }}</p>
<a href="{{ route('home') }}" class="btn btn-primary">Về trang chủ</a>
</div>
@endsection
