@extends('admin.layouts.app')
@section('title', __('admin.menu.activity'))
@section('content')
<form method="get" class="mb-3 form-inline">
    <input type="search" name="s" value="{{ request('s') }}" class="form-control form-control-sm mr-2">
    <button class="btn btn-sm btn-secondary">{{ __('admin.actions.search') }}</button>
</form>
<table class="table table-striped bg-white small">
    <thead><tr><th>Thời gian</th><th>Người dùng</th><th>Mô tả</th></tr></thead>
    <tbody>
    @foreach($items as $log)
        <tr>
            <td>{{ $log->created_at?->format('d/m/Y H:i') }}</td>
            <td>{{ $log->causer?->name ?? '—' }}</td>
            <td>{{ $log->description }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
{{ $items->links() }}
@endsection
