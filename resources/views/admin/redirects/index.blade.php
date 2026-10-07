@extends('admin.layouts.app')
@section('title', __('admin.menu.redirects'))
@section('title_actions')<a href="{{ route('admin.redirects.create') }}" class="btn btn-primary btn-sm">{{ __('admin.actions.add_new') }}</a>@endsection
@section('content')
<table class="table table-striped bg-white">
    <thead><tr><th>Từ</th><th>Đến</th><th>Mã</th><th>Lượt</th><th></th></tr></thead>
    <tbody>
    @foreach($items as $item)
        <tr>
            <td><code>{{ $item->from_path }}</code></td>
            <td><code>{{ $item->to_path }}</code></td>
            <td>{{ $item->status_code }}</td>
            <td>{{ $item->hits }}</td>
            <td><a href="{{ route('admin.redirects.edit', $item) }}">{{ __('admin.actions.edit') }}</a></td>
        </tr>
    @endforeach
    </tbody>
</table>
{{ $items->links() }}
@endsection
