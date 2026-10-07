@extends('admin.layouts.app')
@section('title', __('admin.menu.settings'))
@section('content')
<form method="post" action="{{ route('admin.settings.update', $group) }}">@csrf @method('PUT')
<div class="postbox"><div class="inside">
@foreach($settings as $key => $value)
@if(is_string($value) || is_numeric($value))
<label class="d-block small text-muted">{{ $key }}</label>
<input class="form-control mb-2" name="{{ $key }}" value="{{ old($key, $value) }}">
@endif
@endforeach
<button class="btn btn-primary">{{ __('admin.actions.update') }}</button>
</div></div></form>
@endsection
