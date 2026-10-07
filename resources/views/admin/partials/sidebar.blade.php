<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ route('admin.dashboard') }}" class="brand-link">
        <span class="brand-text font-weight-light pl-3">{{ $siteSettings['site_name'] ?? config('app.name') }}</span>
    </a>
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>{{ __('admin.dashboard') }}</p>
                    </a>
                </li>

                <li class="nav-header">Nội dung</li>
                @foreach([
                    ['admin.news.*', 'admin.news.index', 'admin.menu.news', 'fa-newspaper'],
                    ['admin.announcements.*', 'admin.announcements.index', 'admin.menu.announcements', 'fa-bullhorn'],
                    ['admin.events.*', 'admin.events.index', 'admin.menu.events', 'fa-calendar-alt'],
                    ['admin.programs.*', 'admin.programs.index', 'admin.menu.programs', 'fa-graduation-cap'],
                    ['admin.learning-models.*', 'admin.learning-models.index', 'admin.menu.learning_models', 'fa-users'],
                    ['admin.library-items.*', 'admin.library-items.index', 'admin.menu.library', 'fa-book'],
                    ['admin.documents.*', 'admin.documents.index', 'admin.menu.documents', 'fa-file-alt'],
                    ['admin.galleries.*', 'admin.galleries.index', 'admin.menu.galleries', 'fa-images'],
                    ['admin.pages.*', 'admin.pages.index', 'admin.menu.pages', 'fa-file'],
                ] as [$pattern, $route, $label, $icon])
                    <li class="nav-item">
                        <a href="{{ route($route) }}" class="nav-link {{ request()->routeIs($pattern) ? 'active' : '' }}">
                            <i class="nav-icon fas {{ $icon }}"></i>
                            <p>{{ __($label) }}</p>
                        </a>
                    </li>
                @endforeach

                <li class="nav-header">Tương tác</li>
                @foreach([
                    ['admin.registrations.*', 'admin.registrations.index', 'admin.menu.registrations', 'fa-clipboard-list'],
                    ['admin.contacts.*', 'admin.contacts.index', 'admin.menu.contacts', 'fa-envelope'],
                ] as [$pattern, $route, $label, $icon])
                    <li class="nav-item">
                        <a href="{{ route($route) }}" class="nav-link {{ request()->routeIs($pattern) ? 'active' : '' }}">
                            <i class="nav-icon fas {{ $icon }}"></i>
                            <p>{{ __($label) }}</p>
                        </a>
                    </li>
                @endforeach

                <li class="nav-header">Giao diện & media</li>
                @foreach([
                    ['admin.media.*', 'admin.media.index', 'admin.menu.media', 'fa-photo-video'],
                    ['admin.menus.*', 'admin.menus.index', 'admin.menu.menus', 'fa-sitemap'],
                    ['admin.sliders.*', 'admin.sliders.index', 'admin.menu.sliders', 'fa-sliders-h'],
                    ['admin.banners.*', 'admin.banners.index', 'admin.menu.banners', 'fa-ad'],
                    ['admin.widgets.*', 'admin.widgets.index', 'admin.menu.widgets', 'fa-th-large'],
                ] as [$pattern, $route, $label, $icon])
                    <li class="nav-item">
                        <a href="{{ route($route) }}" class="nav-link {{ request()->routeIs($pattern) ? 'active' : '' }}">
                            <i class="nav-icon fas {{ $icon }}"></i>
                            <p>{{ __($label) }}</p>
                        </a>
                    </li>
                @endforeach

                <li class="nav-header">Hệ thống</li>
                @foreach([
                    ['admin.redirects.*', 'admin.redirects.index', 'admin.menu.redirects', 'fa-random'],
                    ['admin.activity.*', 'admin.activity.index', 'admin.menu.activity', 'fa-history'],
                    ['admin.users.*', 'admin.users.index', 'admin.menu.users', 'fa-user-friends'],
                    ['admin.roles.*', 'admin.roles.index', 'admin.menu.roles', 'fa-user-shield'],
                    ['admin.settings.*', 'admin.settings.edit', 'admin.menu.settings', 'fa-cogs'],
                ] as [$pattern, $route, $label, $icon])
                    <li class="nav-item">
                        <a href="{{ route($route) }}" class="nav-link {{ request()->routeIs($pattern) ? 'active' : '' }}">
                            <i class="nav-icon fas {{ $icon }}"></i>
                            <p>{{ __($label) }}</p>
                        </a>
                    </li>
                @endforeach
            </ul>
        </nav>
    </div>
</aside>
