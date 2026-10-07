@php
    $meta = $meta ?? [];
    $title = $meta['title'] ?? ($siteSettings['site_name'] ?? config('app.name'));
    $siteName = $meta['site_name'] ?? ($siteSettings['site_name'] ?? config('app.name'));
    $description = $meta['description'] ?? ($siteSettings['seo_default_description'] ?? '');
    $canonical = $meta['canonical'] ?? url()->current();
    $image = $meta['image'] ?? null;
    $ogType = $meta['type'] ?? 'website';
    $robots = $meta['robots'] ?? 'index, follow';
@endphp
<title>{{ $title }}</title>
<meta name="description" content="{{ $description }}">
<meta name="robots" content="{{ $robots }}">
<link rel="canonical" href="{{ $canonical }}">

<meta property="og:locale" content="{{ $meta['locale'] ?? 'vi_VN' }}">
<meta property="og:type" content="{{ $ogType }}">
<meta property="og:title" content="{{ $title }}">
<meta property="og:description" content="{{ $description }}">
<meta property="og:url" content="{{ $canonical }}">
<meta property="og:site_name" content="{{ $siteName }}">
@if($image)
<meta property="og:image" content="{{ $image }}">
@endif
@if(!empty($meta['published_time']))
<meta property="article:published_time" content="{{ $meta['published_time'] }}">
@endif
@if(!empty($meta['modified_time']))
<meta property="article:modified_time" content="{{ $meta['modified_time'] }}">
@endif

<meta name="twitter:card" content="{{ $meta['twitter_card'] ?? 'summary_large_image' }}">
<meta name="twitter:title" content="{{ $title }}">
<meta name="twitter:description" content="{{ $description }}">
@if($image)
<meta name="twitter:image" content="{{ $image }}">
@endif

@if(!empty($meta['json_ld']))
    @foreach($meta['json_ld'] as $schema)
        @if(is_array($schema))
            <script type="application/ld+json">{!! json_encode(array_filter($schema, fn ($v) => $v !== null && $v !== ''), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
        @endif
    @endforeach
@endif
