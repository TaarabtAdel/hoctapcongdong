@extends('admin.layouts.app')
@section('title', $item->exists ? 'Sửa widget' : 'Thêm widget')
@section('content')
<form method="post" action="{{ $item->exists ? route('admin.widgets.update', $item) : route('admin.widgets.store') }}">@csrf @if($item->exists)@method('PUT')@endif
<input name="title" class="form-control mb-2" value="{{ old('title', $item->title) }}" required>
<input name="location" class="form-control mb-2" placeholder="sidebar-home, footer…" value="{{ old('location', $item->location) }}" required>
<select name="type" class="form-control mb-2">
    @foreach(['html','menu','posts'] as $t)
        <option value="{{ $t }}" @selected(old('type', $item->type ?? 'html') === $t)>{{ $t }}</option>
    @endforeach
</select>
<textarea name="content" class="form-control mb-2" rows="8">{{ old('content', $item->content) }}</textarea>
<input type="number" name="sort_order" class="form-control mb-2" value="{{ old('sort_order', $item->sort_order ?? 0) }}">
<div class="custom-control custom-checkbox mb-2">
    <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" @checked(old('is_active', $item->is_active ?? true))>
    <label class="custom-control-label" for="is_active">Kích hoạt</label>
</div>
<button class="btn btn-primary">{{ __('admin.actions.save') }}</button>
</form>
@endsection
