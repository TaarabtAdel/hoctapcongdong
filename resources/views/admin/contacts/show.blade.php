@extends('admin.layouts.app')
@section('title', 'Liên hệ #'.$contact->id)
@section('content')
<p>{{ $contact->message }}</p>
<form method="post" action="{{ route('admin.contacts.update', $contact) }}">@csrf @method('PUT')
<textarea name="reply" class="form-control mb-2">{{ $contact->reply }}</textarea>
<button class="btn btn-primary">Lưu trả lời</button>
</form>
@endsection
