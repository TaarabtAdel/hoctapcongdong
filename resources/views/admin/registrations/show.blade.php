@extends('admin.layouts.app')
@section('title', 'Đăng ký #'.$registration->id)
@section('content')
<p><strong>{{ $registration->full_name }}</strong> · {{ $registration->phone }} · {{ $registration->email }}</p>
<form method="post" action="{{ route('admin.registrations.update', $registration) }}">@csrf @method('PUT')
<select name="status" class="form-control mb-2"><option value="new">new</option><option value="contacted">contacted</option><option value="scheduled">scheduled</option><option value="rejected">rejected</option></select>
<textarea name="internal_note" class="form-control mb-2">{{ $registration->internal_note }}</textarea>
<button class="btn btn-primary">{{ __('admin.actions.update') }}</button>
</form>
@endsection
