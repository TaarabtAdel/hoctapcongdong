@extends('front.layouts.app')
@section('content')
<div class="container py-4"><h1 class="h3 mb-3">{{ __('front.menu.register') }}</h1>
<form method="post" action="{{ route('front.registration.store') }}">@csrf
<input type="text" name="website" class="d-none" tabindex="-1" autocomplete="off">
<div class="form-group"><label>Họ tên *</label><input name="full_name" class="form-control" required></div>
<div class="form-group"><label>SĐT *</label><input name="phone" class="form-control" required></div>
<div class="form-group"><label>Email</label><input type="email" name="email" class="form-control"></div>
<div class="form-group"><label>Địa chỉ</label><input name="address" class="form-control"></div>
<div class="form-group"><label>Chương trình quan tâm</label><select name="program_id" class="form-control"><option value="">-- Chọn --</option>@foreach($programs as $p)<option value="{{ $p->id }}">{{ $p->title }}</option>@endforeach</select></div>
<div class="form-group"><label>Nội dung mong muốn</label><textarea name="desired_content" class="form-control" rows="4"></textarea></div>
<button class="btn btn-primary">{{ __('front.home.register_now') }}</button>
</form></div>
@endsection
