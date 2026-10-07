@extends('admin.layouts.app')
@section('title', __('admin.menu.banners'))
@section('title_actions')<a href="{{ route('admin.banners.create') }}" class="btn btn-primary btn-sm">{{ __('admin.actions.add_new') }}</a>@endsection
@section('content')
<table class="table table-striped bg-white">
    <thead><tr><th>Tên</th><th>Vị trí</th><th>Ảnh</th><th></th></tr></thead>
    <tbody>
    @foreach($items as $item)
        <tr>
            <td>{{ $item->name }}</td>
            <td>{{ $item->location }}</td>
            <td>{{ $item->image_id }}</td>
            <td><a href="{{ route('admin.banners.edit', $item) }}">{{ __('admin.actions.edit') }}</a></td>
        </tr>
    @endforeach
    </tbody>
</table>
@endsection
