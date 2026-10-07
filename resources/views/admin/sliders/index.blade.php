@extends('admin.layouts.app')
@section('title', __('admin.menu.sliders'))
@section('title_actions')<a href="{{ route('admin.sliders.create') }}" class="btn btn-primary btn-sm">{{ __('admin.actions.add_new') }}</a>@endsection
@section('content')<ul>@foreach($items as $slider)<li><a href="{{ route('admin.sliders.edit', $slider) }}">{{ $slider->name }}</a></li>@endforeach</ul>@endsection
