@extends('front.layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="h3 font-weight-bold mb-4">{{ __('front.menu.contact') }}</h1>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <form method="post" action="{{ route('front.contact.store') }}" class="card-soft p-4">
        @csrf
        <div class="d-none" aria-hidden="true"><input type="text" name="website" tabindex="-1" autocomplete="off"></div>
        <div class="form-group">
            <label>Họ tên *</label>
            <input type="text" name="full_name" class="form-control" value="{{ old('full_name') }}" required>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Email *</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
            </div>
            <div class="form-group col-md-6">
                <label>Điện thoại</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone') }}">
            </div>
        </div>
        <div class="form-group">
            <label>Chủ đề</label>
            <input type="text" name="subject" class="form-control" value="{{ old('subject') }}">
        </div>
        <div class="form-group">
            <label>Nội dung *</label>
            <textarea name="message" class="form-control" rows="6" required>{{ old('message') }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Gửi liên hệ</button>
    </form>
</div>
@endsection
