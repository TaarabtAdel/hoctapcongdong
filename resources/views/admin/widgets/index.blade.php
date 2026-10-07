@extends('admin.layouts.app')
@section('title', __('admin.menu.widgets'))
@section('title_actions')<a href="{{ route('admin.widgets.create') }}" class="btn btn-primary btn-sm">{{ __('admin.actions.add_new') }}</a>@endsection
@section('content')
<table class="table table-striped bg-white">
    <thead><tr><th>Tiêu đề</th><th>Vị trí</th><th>Loại</th><th>TT</th><th></th></tr></thead>
    <tbody>
    @foreach($items as $item)
        <tr>
            <td>{{ $item->title }}</td>
            <td>{{ $item->location }}</td>
            <td>{{ $item->type }}</td>
            <td>{{ $item->is_active ? '✓' : '—' }}</td>
            <td><a href="{{ route('admin.widgets.edit', $item) }}">{{ __('admin.actions.edit') }}</a></td>
        </tr>
    @endforeach
    </tbody>
</table>
@endsection
