<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="admin-base" content="{{ url('/'.config('htcd.admin_path', 'admin')) }}">
    <title>@yield('title', __('admin.dashboard')) · {{ $siteSettings['site_name'] ?? config('app.name') }}</title>
    @vite(['resources/css/admin/app.scss', 'resources/js/admin/app.js'])
</head>
<body class="admin-body">
@include('admin.partials.admin-bar')
<div class="d-flex">
    @include('admin.partials.sidebar')
    <div id="wpcontent" class="flex-grow-1">
        @include('admin.partials.notices')
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1 class="h4 mb-0">@yield('title')</h1>
            @yield('title_actions')
        </div>
        @yield('content')
        @include('admin.partials.footer')
    </div>
</div>
@stack('scripts')
</body>
</html>
