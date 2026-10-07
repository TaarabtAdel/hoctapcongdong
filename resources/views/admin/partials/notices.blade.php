@if(session('success'))
    <div class="notice notice-success">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="notice notice-error">{{ session('error') }}</div>
@endif
@if(session('warning'))
    <div class="notice notice-warning">{{ session('warning') }}</div>
@endif
@if(isset($errors) && $errors->any())
    <div class="notice notice-error">
        <ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
    </div>
@endif
