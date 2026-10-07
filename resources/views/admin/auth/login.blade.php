<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('admin.login') }}</title>
    @vite(['resources/css/admin/app.scss'])
</head>
<body class="admin-body">
@php($loginError = $errors->first('email') ?: $errors->first('password'))
<div class="wp-login">
    <h1 class="h4 text-center mb-4">{{ $siteSettings['site_name'] ?? config('app.name') }}</h1>

    @if(session('status'))
        <div class="alert alert-success" role="alert">{{ session('status') }}</div>
    @endif
    @if($loginError)
        <div class="alert alert-danger" role="alert">{{ $loginError }}</div>
    @endif

    <form method="post" action="{{ route('admin.login') }}" novalidate>
        @csrf
        <div class="form-group">
            <label for="login-email">Email</label>
            <input type="email" name="email" id="login-email"
                   class="form-control @if($loginError) is-invalid @endif"
                   value="{{ old('email') }}" required autofocus autocomplete="username">
        </div>
        <div class="form-group">
            <label for="login-password">Mật khẩu</label>
            <input type="password" name="password" id="login-password"
                   class="form-control @if($errors->has('password')) is-invalid @endif"
                   required autocomplete="current-password">
        </div>
        <div class="form-group form-check">
            <input type="checkbox" name="remember" class="form-check-input" id="remember" @checked(old('remember'))>
            <label class="form-check-label" for="remember">Ghi nhớ đăng nhập</label>
        </div>
        <button class="btn btn-primary btn-block">{{ __('admin.login') }}</button>
        <p class="mt-3 mb-0 text-center"><a href="{{ route('admin.password.request') }}">Quên mật khẩu?</a></p>
    </form>
</div>
</body>
</html>
