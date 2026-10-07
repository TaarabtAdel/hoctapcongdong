<!DOCTYPE html>
<html lang="vi"><head><meta charset="utf-8"><title>Quên mật khẩu</title>@vite(['resources/css/admin/app.scss'])</head>
<body class="admin-body"><div class="wp-login">
<h1 class="h5 mb-3">Khôi phục mật khẩu</h1>
@if(session('status'))<div class="alert alert-success">{{ session('status') }}</div>@endif
<form method="post" action="{{ route('admin.password.email') }}">@csrf
<input type="email" name="email" class="form-control mb-2" required>
<button class="btn btn-primary btn-block">Gửi link</button>
</form>
</div></body></html>
