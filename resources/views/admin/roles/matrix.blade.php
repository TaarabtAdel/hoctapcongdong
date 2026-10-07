@extends('admin.layouts.app')
@section('title', $role->exists ? 'Sửa vai trò' : 'Thêm vai trò')
@section('content')
<form method="post" action="{{ $role->exists ? route('admin.roles.update', $role) : route('admin.roles.store') }}">@csrf @if($role->exists)@method('PUT')@endif
<input name="name" class="form-control mb-3" value="{{ old('name', $role->name) }}" required>
@foreach($permissions as $module => $perms)
<h3 class="h6">{{ $module }}</h3>
@foreach($perms as $perm)
<label class="d-block"><input type="checkbox" name="permissions[]" value="{{ $perm->name }}" @checked($role->exists && $role->hasPermissionTo($perm->name))> {{ $perm->name }}</label>
@endforeach
@endforeach
<button class="btn btn-primary mt-3">{{ __('admin.actions.save') }}</button>
</form>
@endsection
