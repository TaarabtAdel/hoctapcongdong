@extends('admin.layouts.app')
@section('title', __('admin.menu.menus'))
@section('title_actions')<a href="{{ route('admin.menus.create') }}" class="btn btn-primary btn-sm">{{ __('admin.actions.add_new') }}</a>@endsection
@section('content')<ul>@foreach($menus as $menu)<li><a href="{{ route('admin.menus.edit', $menu) }}">{{ $menu->name }}</a> ({{ $menu->all_items_count }})</li>@endforeach</ul>@endsection
