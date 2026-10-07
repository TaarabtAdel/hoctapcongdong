@php
    $newLinks = config('htcd.admin_new_links', []);
    $notifications = app(\App\Services\Admin\AdminNotificationsService::class)->feed();
@endphp
<div id="wpadminbar" class="d-flex align-items-center px-3 flex-wrap">
    <a href="{{ route('admin.dashboard') }}" class="text-white mr-3 font-weight-bold">{{ $siteSettings['site_name'] ?? '' }}</a>

    <div class="dropdown mr-3">
        <button class="btn btn-link btn-sm text-white dropdown-toggle p-0" type="button" id="adminNewDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            + {{ __('admin.actions.add_new') }}
        </button>
        <div class="dropdown-menu" aria-labelledby="adminNewDropdown">
            @foreach($newLinks as $link)
                @if(Route::has($link['route']))
                    <a class="dropdown-item" href="{{ route($link['route']) }}">{{ __($link['label']) }}</a>
                @endif
            @endforeach
        </div>
    </div>

    <a href="{{ route('home') }}" class="text-white mr-3" target="_blank" rel="noopener">{{ __('admin.view_site') }}</a>

    <div class="dropdown mr-3 ml-md-auto">
        <button class="btn btn-link btn-sm text-white position-relative p-0" type="button" id="adminNotifyDropdown" data-toggle="dropdown" aria-label="{{ __('admin.notifications.title') }}">
            <i class="fas fa-bell"></i>
            @if($notifications['total'] > 0)
                <span class="badge badge-danger badge-pill admin-notify-badge">{{ $notifications['total'] > 99 ? '99+' : $notifications['total'] }}</span>
            @endif
        </button>
        <div class="dropdown-menu dropdown-menu-right admin-notify-menu" aria-labelledby="adminNotifyDropdown">
            <h6 class="dropdown-header">{{ __('admin.notifications.title') }}</h6>
            @forelse($notifications['items'] as $note)
                <a class="dropdown-item small" href="{{ $note->url }}">
                    {{ $note->label }}
                    <span class="d-block text-muted">{{ $note->at?->diffForHumans() }}</span>
                </a>
            @empty
                <span class="dropdown-item text-muted small">{{ __('admin.notifications.empty') }}</span>
            @endforelse
            <div class="dropdown-divider"></div>
            <a class="dropdown-item small" href="{{ route('admin.registrations.index') }}">{{ __('admin.menu.registrations') }}</a>
            <a class="dropdown-item small" href="{{ route('admin.contacts.index') }}">{{ __('admin.menu.contacts') }}</a>
        </div>
    </div>

    <span class="text-white-50 small mr-2 d-none d-md-inline">{{ __('admin.howdy', ['name' => auth()->user()->name]) }}</span>
    <a href="{{ route('admin.profile.edit') }}" class="text-white mr-2 small">{{ __('admin.profile.title') }}</a>
    <form action="{{ route('admin.logout') }}" method="post" class="mb-0">@csrf<button class="btn btn-link btn-sm text-white p-0">{{ __('admin.logout') }}</button></form>
</div>
