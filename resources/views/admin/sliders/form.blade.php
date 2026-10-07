@extends('admin.layouts.app')
@section('title', $slider->exists ? 'Sửa slider' : 'Thêm slider')
@section('content')
<form method="post" action="{{ $slider->exists ? route('admin.sliders.update', $slider) : route('admin.sliders.store') }}">@csrf @if($slider->exists)@method('PUT')@endif
<input name="name" class="form-control mb-2" value="{{ old('name', $slider->name) }}">
<input name="location" class="form-control mb-2" value="{{ old('location', $slider->location ?? 'hero') }}">
<div class="custom-control custom-checkbox mb-3">
    <input type="checkbox" class="custom-control-input" id="slider_active" name="is_active" value="1" @checked(old('is_active', $slider->is_active ?? true))>
    <label class="custom-control-label" for="slider_active">Kích hoạt</label>
</div>

@if($slider->exists)
    <h3 class="h6">Slide</h3>
    @foreach($slider->slides as $slide)
        <div class="border rounded p-2 mb-2">
            <input type="hidden" name="slides[{{ $loop->index }}][id]" value="{{ $slide->id }}">
            <input name="slides[{{ $loop->index }}][title]" class="form-control form-control-sm mb-1" placeholder="Tiêu đề" value="{{ $slide->title }}">
            <input name="slides[{{ $loop->index }}][subtitle]" class="form-control form-control-sm mb-1" placeholder="Phụ đề" value="{{ $slide->subtitle }}">
            <input name="slides[{{ $loop->index }}][link_url]" class="form-control form-control-sm mb-1" placeholder="Link" value="{{ $slide->link_url }}">
            <input name="slides[{{ $loop->index }}][badge_text]" class="form-control form-control-sm mb-1" placeholder="Badge" value="{{ $slide->badge_text }}">
            <input type="number" name="slides[{{ $loop->index }}][image_id]" class="form-control form-control-sm mb-1" placeholder="Media ID ảnh" value="{{ $slide->image_id }}">
            <label class="small"><input type="checkbox" name="slides[{{ $loop->index }}][is_active]" value="1" @checked($slide->is_active)> Hiển thị</label>
        </div>
    @endforeach
    @php $n = $slider->slides->count(); @endphp
    <div class="border rounded p-2 mb-2 bg-light">
        <strong class="small">Thêm slide mới</strong>
        <input name="slides[{{ $n }}][title]" class="form-control form-control-sm mb-1 mt-1" placeholder="Tiêu đề">
        <input name="slides[{{ $n }}][subtitle]" class="form-control form-control-sm mb-1" placeholder="Phụ đề">
        <input name="slides[{{ $n }}][link_url]" class="form-control form-control-sm mb-1" placeholder="Link">
        <input type="number" name="slides[{{ $n }}][image_id]" class="form-control form-control-sm mb-1" placeholder="Media ID ảnh">
    </div>
@endif

<button class="btn btn-primary mt-2">{{ __('admin.actions.save') }}</button>
</form>
@endsection
