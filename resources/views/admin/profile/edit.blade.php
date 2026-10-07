@extends('admin.layouts.app')
@section('title', 'Hồ sơ của bạn')
@section('content')
<form method="post" action="{{ route('admin.profile.update') }}">@csrf @method('PUT')
<input name="name" class="form-control mb-2" value="{{ old('name', $user->name) }}">
<input name="email" type="email" class="form-control mb-2" value="{{ old('email', $user->email) }}">
<input name="phone" class="form-control mb-2" value="{{ old('phone', $user->phone) }}">
<input name="password" type="password" class="form-control mb-2" placeholder="Mật khẩu mới">
<input name="password_confirmation" type="password" class="form-control mb-2" placeholder="Xác nhận mật khẩu">
<button class="btn btn-primary">{{ __('admin.actions.update') }}</button>
</form>
@endsection
