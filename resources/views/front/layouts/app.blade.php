<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('front.partials.seo')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    @vite(['resources/css/front/app.scss', 'resources/js/front/app.js'])
</head>
<body>
@include('front.partials.topbar')
@include('front.partials.header')
@include('front.partials.nav')

<main id="main-content">
    @yield('content')
</main>

@include('front.partials.footer')
<button type="button" id="backToTop" class="btn btn-primary btn-sm" aria-label="Lên đầu trang"><i class="fas fa-arrow-up"></i></button>
</body>
</html>
