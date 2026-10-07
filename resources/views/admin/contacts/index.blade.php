@extends('admin.layouts.app')
@section('title', __('admin.menu.contacts'))
@section('content')
<table class="table bg-white"><tr><th>Họ tên</th><th>Email</th><th>Đã đọc</th></tr>
@foreach($items as $item)<tr><td><a href="{{ route('admin.contacts.show', $item) }}">{{ $item->full_name }}</a></td><td>{{ $item->email }}</td><td>{{ $item->is_read ? 'Yes' : 'No' }}</td></tr>@endforeach</table>
{{ $items->links() }}
@endsection
