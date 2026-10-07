@extends('admin.layouts.app')
@section('title', __('admin.menu.roles'))
@section('title_actions')<a href="{{ route('admin.roles.create') }}" class="btn btn-primary btn-sm">{{ __('admin.actions.add_new') }}</a>@endsection
@section('content')
<ul>@foreach($roles as $role)<li><a href="{{ route('admin.roles.edit', $role) }}">{{ $role->name }}</a> ({{ $role->permissions_count }})</li>@endforeach</ul>
@endsection
