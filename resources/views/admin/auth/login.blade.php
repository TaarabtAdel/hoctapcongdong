<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('admin.login') }}</title>
    @vite(['resources/css/admin/app.scss'])
</head>
<body class="hold-transition login-page">
@php($loginError = $errors->first('email') ?: $errors->first('password'))
<div class="login-box">
    <div class="login-logo">
        <b>{{ $siteSettings['site_name'] ?? config('app.name') }}</b>
    </div>
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">{{ __('admin.login') }}</p>

            @if(session('status'))
                <div class="alert alert-success" role="alert">{{ session('status') }}</div>
            @endif
            @if($loginError)
                <div class="alert alert-danger" role="alert">{{ $loginError }}</div>
            @endif

            <form method="post" action="{{ route('admin.login') }}" novalidate>
                @csrf
                <div class="input-group mb-3">
                    <input type="email" name="email" id="login-email"
                           class="form-control @if($loginError) is-invalid @endif"
                           placeholder="Email" value="{{ old('email') }}" required autofocus autocomplete="username">
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fas fa-envelope"></span></div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" name="password" id="login-password"
                           class="form-control @if($errors->has('password')) is-invalid @endif"
                           placeholder="Mật khẩu" required autocomplete="current-password">
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fas fa-lock"></span></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-8">
                        <div class="icheck-primary">
                            <input type="checkbox" name="remember" id="remember" @checked(old('remember'))>
                            <label for="remember">Ghi nhớ đăng nhập</label>
                        </div>
                    </div>
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">{{ __('admin.login') }}</button>
                    </div>
                </div>
            </form>
            <p class="mb-0 mt-3 text-center">
                <a href="{{ route('admin.password.request') }}">Quên mật khẩu?</a>
            </p>
        </div>
    </div>
</div>
</body>
</html>
