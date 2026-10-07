@extends('admin.layouts.app')
@section('title', $item->exists ? 'Sửa banner' : 'Thêm banner')
@section('content')
<form method="post" action="{{ $item->exists ? route('admin.banners.update', $item) : route('admin.banners.store') }}">@csrf @if($item->exists)@method('PUT')@endif
<input name="name" class="form-control mb-2" value="{{ old('name', $item->name) }}" required>
<input name="location" class="form-control mb-2" value="{{ old('location', $item->location ?? 'header') }}">
<input type="number" name="image_id" id="banner_image_id" class="form-control mb-2" value="{{ old('image_id', $item->image_id) }}" placeholder="ID ảnh media">
<button type="button" class="btn btn-sm btn-outline-secondary mb-2" data-media-picker data-target="#banner_image_id">Chọn ảnh</button>
<input name="title" class="form-control mb-2" value="{{ old('title', $item->title) }}">
<input type="url" name="link_url" class="form-control mb-2" value="{{ old('link_url', $item->link_url) }}">
<div class="custom-control custom-checkbox mb-2">
    <input type="checkbox" class="custom-control-input" id="banner_active" name="is_active" value="1" @checked(old('is_active', $item->is_active ?? true))>
    <label class="custom-control-label" for="banner_active">Hiển thị</label>
</div>
<button class="btn btn-primary">{{ __('admin.actions.save') }}</button>
</form>
@include('admin.partials.media-modal')
@endsection
