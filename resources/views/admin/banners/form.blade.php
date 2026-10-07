@extends('admin.layouts.app')
@section('title', $item->exists ? 'Sửa banner' : 'Thêm banner')
@section('content')
<form method="post" action="{{ $item->exists ? route('admin.banners.update', $item) : route('admin.banners.store') }}">
    @csrf
    @if($item->exists)
        @method('PUT')
    @endif
    <div class="card card-outline card-primary">
        <div class="card-body">
            <div class="form-group">
                <label>Tên quản trị</label>
                <input name="name" class="form-control" value="{{ old('name', $item->name) }}" required>
            </div>
            <div class="form-group">
                <label>Vị trí (location)</label>
                <input name="location" class="form-control" value="{{ old('location', $item->location ?? 'header') }}" placeholder="header, sidebar, footer…" required>
                <small class="form-text text-muted">Mã vị trí hiển thị trên theme (vd. <code>header</code>).</small>
            </div>
            <div class="form-group">
                <label>Tiêu đề hiển thị</label>
                <input name="title" class="form-control" value="{{ old('title', $item->title) }}">
            </div>
            <div class="form-group">
                <label>Liên kết</label>
                <input type="text" name="link_url" class="form-control" value="{{ old('link_url', $item->link_url) }}" placeholder="https://… hoặc /duong-dan-tuong-doi">
            </div>
            <div class="form-group">
                <label>Ảnh banner</label>
                <input type="hidden" name="image_id" id="banner_image_id" value="{{ old('image_id', $item->image_id) }}">
                <div id="banner-image-preview" class="mb-2">
                    @if($item->image)
                        <img src="{{ $item->image->url('thumb') }}" alt="" class="img-fluid rounded" style="max-height:120px">
                    @endif
                </div>
                <button type="button" class="btn btn-outline-primary btn-sm" data-media-picker data-target="#banner_image_id" data-preview="#banner-image-preview">Chọn ảnh</button>
                <button type="button" class="btn btn-link btn-sm" onclick="document.getElementById('banner_image_id').value='';document.getElementById('banner-image-preview').innerHTML=''">Xóa ảnh</button>
            </div>
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="banner_active" name="is_active" value="1" @checked(old('is_active', $item->is_active ?? true))>
                <label class="custom-control-label" for="banner_active">Đang hiển thị</label>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">{{ __('admin.actions.save') }}</button>
            <a href="{{ route('admin.banners.index') }}" class="btn btn-default">Quay lại</a>
        </div>
    </div>
</form>
@include('admin.partials.media-modal')
@endsection
