<div class="topbar py-2">
    <div class="container d-flex flex-wrap justify-content-between align-items-center">
        <div>
            <span>{{ $siteSettings['organization_line'] ?? '' }}</span>
            @if(!empty($siteSettings['topbar_phone']))
                <span class="ml-3"><i class="fas fa-phone"></i> {{ $siteSettings['topbar_phone'] }}</span>
            @endif
            @if(!empty($siteSettings['topbar_email']))
                <span class="ml-3"><i class="fas fa-envelope"></i> {{ $siteSettings['topbar_email'] }}</span>
            @endif
        </div>
        <div>{{ $siteSettings['topbar_location'] ?? '' }}</div>
    </div>
</div>
