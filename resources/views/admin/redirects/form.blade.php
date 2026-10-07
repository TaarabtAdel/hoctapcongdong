@extends('admin.layouts.app')
@section('title', $item->exists ? 'Sửa chuyển hướng' : 'Thêm chuyển hướng')
@section('content')
<form method="post" action="{{ $item->exists ? route('admin.redirects.update', $item) : route('admin.redirects.store') }}">@csrf @if($item->exists)@method('PUT')@endif
<input name="from_path" class="form-control mb-2" placeholder="/duong-dan-cu" value="{{ old('from_path', $item->from_path) }}" required>
<input name="to_path" class="form-control mb-2" placeholder="/duong-dan-moi" value="{{ old('to_path', $item->to_path) }}" required>
<select name="status_code" class="form-control mb-2">
    @foreach([301,302,307,308] as $code)
        <option value="{{ $code }}" @selected(old('status_code', $item->status_code ?? 301) == $code)>{{ $code }}</option>
    @endforeach
</select>
<button class="btn btn-primary">{{ __('admin.actions.save') }}</button>
</form>
@endsection
