@extends('admin.layouts.app')
@section('title', $title)
@section('title_actions')<a href="{{ route($routePrefix.'.create') }}" class="btn btn-primary btn-sm">{{ __('admin.actions.add_new') }}</a>@endsection
@section('content')
<table class="table bg-white"><thead><tr><th>Tên</th><th>Slug</th><th></th></tr></thead>
<tbody>@foreach($items as $item)<tr><td>{{ $item->name ?? $item->title }}</td><td>{{ $item->slug ?? '' }}</td><td><a href="{{ route($routePrefix.'.edit', $item) }}">{{ __('admin.actions.edit') }}</a></td></tr>@endforeach</tbody></table>
@endsection
