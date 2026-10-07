@extends('admin.layouts.app')
@section('title', $user->exists ? 'Sửa người dùng' : 'Thêm người dùng')
@section('content')
<form method="post" action="{{ $user->exists ? route('admin.users.update', $user) : route('admin.users.store') }}">@csrf @if($user->exists)@method('PUT')@endif
<input name="name" class="form-control mb-2" value="{{ old('name', $user->name) }}" required>
<input name="email" type="email" class="form-control mb-2" value="{{ old('email', $user->email) }}" required>
<input name="password" type="password" class="form-control mb-2" placeholder="Mật khẩu" @if(!$user->exists) required @endif>
<select name="role" class="form-control mb-2">@foreach($roles as $role)<option value="{{ $role->name }}" @selected($user->hasRole($role->name))>{{ $role->name }}</option>@endforeach</select>
<select name="status" class="form-control mb-2"><option value="active">active</option><option value="inactive">inactive</option></select>
<button class="btn btn-primary">{{ __('admin.actions.save') }}</button>
</form>
@endsection
