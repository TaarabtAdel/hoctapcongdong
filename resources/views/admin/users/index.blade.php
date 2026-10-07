@extends('admin.layouts.app')
@section('title', __('admin.menu.users'))
@section('title_actions')<a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm">{{ __('admin.actions.add_new') }}</a>@endsection
@section('content')
<table class="table bg-white"><tr><th>Tên</th><th>Email</th><th>Vai trò</th><th></th></tr>
@foreach($users as $u)<tr><td>{{ $u->name }}</td><td>{{ $u->email }}</td><td>{{ $u->roles->pluck('name')->join(', ') }}</td><td><a href="{{ route('admin.users.edit', $u) }}">Sửa</a></td></tr>@endforeach</table>
{{ $users->links() }}
@endsection
