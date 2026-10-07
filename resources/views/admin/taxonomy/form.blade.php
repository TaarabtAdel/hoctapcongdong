@extends('admin.layouts.app')
@section('title', $title)
@section('content')
<form method="post" action="{{ $item->exists ? route($routePrefix.'.update', $item) : route($routePrefix.'.store') }}">@csrf @if($item->exists)@method('PUT')@endif
<div class="postbox"><div class="inside">
<input name="name" class="form-control mb-2" value="{{ old('name', $item->name ?? '') }}" placeholder="Tên" required>
<input name="slug" class="form-control mb-2" value="{{ old('slug', $item->slug ?? '') }}" placeholder="Slug">
@if(isset($item->description))<textarea name="description" class="form-control mb-2">{{ old('description', $item->description) }}</textarea>@endif
<input name="color" class="form-control mb-2" value="{{ old('color', $item->color ?? '') }}" placeholder="Màu">
<input name="icon" class="form-control mb-2" value="{{ old('icon', $item->icon ?? '') }}" placeholder="Icon">
<input name="sort_order" type="number" class="form-control mb-2" value="{{ old('sort_order', $item->sort_order ?? 0) }}">
<button class="btn btn-primary">{{ __('admin.actions.save') }}</button>
</div></div></form>
@endsection
