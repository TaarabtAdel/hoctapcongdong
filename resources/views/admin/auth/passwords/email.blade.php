<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Quên mật khẩu</title>
    @vite(['resources/css/admin/app.scss'])
</head>
<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo"><b>Khôi phục mật khẩu</b></div>
    <div class="card">
        <div class="card-body login-card-body">
            @if(session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif
            <form method="post" action="{{ route('admin.password.email') }}">
                @csrf
                <div class="input-group mb-3">
                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fas fa-envelope"></span></div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Gửi link</button>
            </form>
            <p class="mt-3 mb-0 text-center"><a href="{{ route('admin.login') }}">Quay lại đăng nhập</a></p>
        </div>
    </div>
</div>
</body>
</html>
