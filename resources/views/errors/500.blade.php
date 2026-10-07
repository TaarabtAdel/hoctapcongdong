@extends('front.layouts.app')
@section('content')
<div class="container py-5 text-center">
    <h1 class="display-4">500</h1>
    <p class="lead">Đã xảy ra lỗi. Vui lòng thử lại sau.</p>
    <a href="{{ route('home') }}" class="btn btn-primary">Về trang chủ</a>
</div>
@endsection
