@php
    $newLinks = config('htcd.admin_new_links', []);
    $notifications = app(\App\Services\Admin\AdminNotificationsService::class)->feed();
@endphp
<nav class="main-header navbar navbar-expand navbar-white navbar-light border-bottom">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ route('admin.dashboard') }}" class="nav-link">{{ __('admin.dashboard') }}</a>
        </li>
    </ul>

    <ul class="navbar-nav ml-auto align-items-center">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                <i class="fas fa-plus"></i> {{ __('admin.actions.add_new') }}
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                @foreach($newLinks as $link)
                    @if(Route::has($link['route']))
                        <a class="dropdown-item" href="{{ route($link['route']) }}">{{ __($link['label']) }}</a>
                    @endif
                @endforeach
            </div>
        </li>

        <li class="nav-item d-none d-md-inline-block">
            <a href="{{ route('home') }}" class="nav-link" target="_blank" rel="noopener">{{ __('admin.view_site') }}</a>
        </li>

        <li class="nav-item dropdown">
            <a class="nav-link position-relative" href="#" data-toggle="dropdown" aria-label="{{ __('admin.notifications.title') }}">
                <i class="far fa-bell"></i>
                @if($notifications['total'] > 0)
                    <span class="badge badge-danger navbar-badge admin-notify-badge">{{ $notifications['total'] > 99 ? '99+' : $notifications['total'] }}</span>
                @endif
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right admin-notify-menu">
                <span class="dropdown-item dropdown-header">{{ __('admin.notifications.title') }}</span>
                @forelse($notifications['items'] as $note)
                    <a class="dropdown-item" href="{{ $note->url }}">
                        {{ $note->label }}
                        <span class="d-block text-muted text-sm">{{ $note->at?->diffForHumans() }}</span>
                    </a>
                    <div class="dropdown-divider"></div>
                @empty
                    <span class="dropdown-item text-muted text-sm">{{ __('admin.notifications.empty') }}</span>
                @endforelse
                <a class="dropdown-item dropdown-footer" href="{{ route('admin.registrations.index') }}">{{ __('admin.menu.registrations') }}</a>
                <a class="dropdown-item dropdown-footer" href="{{ route('admin.contacts.index') }}">{{ __('admin.menu.contacts') }}</a>
            </div>
        </li>

        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-user"></i>
                <span class="d-none d-md-inline ml-1">{{ auth()->user()->name }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
                <span class="dropdown-item dropdown-header">{{ __('admin.howdy', ['name' => auth()->user()->name]) }}</span>
                <div class="dropdown-divider"></div>
                <a href="{{ route('admin.profile.edit') }}" class="dropdown-item">{{ __('admin.profile.title') }}</a>
                <div class="dropdown-divider"></div>
                <form action="{{ route('admin.logout') }}" method="post">
                    @csrf
                    <button type="submit" class="dropdown-item">{{ __('admin.logout') }}</button>
                </form>
            </div>
        </li>
    </ul>
</nav>
