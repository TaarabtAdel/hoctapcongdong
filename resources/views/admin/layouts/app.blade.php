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
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    @include('admin.partials.navbar')
    @include('admin.partials.sidebar')

    <div class="content-wrapper">
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">@yield('title', __('admin.dashboard'))</h1>
                    </div>
                    <div class="col-sm-6">
                        @hasSection('title_actions')
                            <div class="float-sm-right">@yield('title_actions')</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                @include('admin.partials.notices')
                @yield('content')
            </div>
        </section>
    </div>

    <footer class="main-footer text-sm">
        <strong>{{ $siteSettings['site_name'] ?? config('app.name') }}</strong>
        <div class="float-right d-none d-sm-inline">Laravel {{ app()->version() }}</div>
    </footer>
</div>
@stack('scripts')
</body>
</html>
