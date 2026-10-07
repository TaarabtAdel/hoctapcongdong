@php
    $menuItems = \App\Models\Menu::where('location', 'primary')->first()?->allItems()->orderBy('sort_order')->get() ?? collect();
@endphp
<header class="site-header py-3">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 d-flex align-items-center">
                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mr-3" style="width:72px;height:72px;">
                    <i class="fas fa-landmark fa-2x"></i>
                </div>
                <div>
                    <div class="brand-title">{{ $siteSettings['organization_sub'] ?? $siteSettings['site_name'] }}</div>
                    <div class="text-muted">{{ $siteSettings['site_tagline'] ?? '' }}</div>
                </div>
            </div>
            <div class="col-lg-4 d-none d-lg-block text-right">
                <div class="card-soft p-2 bg-light">{{ __('front.menu.library') }}</div>
            </div>
        </div>
    </div>
</header>
