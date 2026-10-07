@extends('front.layouts.app')
@section('content')
<div class="container py-5 text-center">
    <h1 class="display-4">404</h1>
    <p class="lead">Không tìm thấy trang bạn yêu cầu.</p>
    <a href="{{ route('home') }}" class="btn btn-primary">Về trang chủ</a>
</div>
@endsection
