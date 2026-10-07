@extends('admin.layouts.app')
@section('title', __('admin.menu.registrations'))
@section('content')
<table class="table bg-white"><tr><th>Họ tên</th><th>SĐT</th><th>Trạng thái</th><th></th></tr>
@foreach($items as $item)<tr><td>{{ $item->full_name }}</td><td>{{ $item->phone }}</td><td>{{ $item->status }}</td><td><a href="{{ route('admin.registrations.show', $item) }}">Xem</a></td></tr>@endforeach</table>
{{ $items->links() }}
@endsection
