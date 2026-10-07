<div id="adminmenuwrap">
    <a class="menu-top {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">{{ __('admin.dashboard') }}</a>
    <a class="menu-top {{ request()->routeIs('admin.news.*') ? 'active' : '' }}" href="{{ route('admin.news.index') }}">{{ __('admin.menu.news') }}</a>
    <a class="menu-top {{ request()->routeIs('admin.announcements.*') ? 'active' : '' }}" href="{{ route('admin.announcements.index') }}">{{ __('admin.menu.announcements') }}</a>
    <a class="menu-top {{ request()->routeIs('admin.events.*') ? 'active' : '' }}" href="{{ route('admin.events.index') }}">{{ __('admin.menu.events') }}</a>
    <a class="menu-top {{ request()->routeIs('admin.programs.*') ? 'active' : '' }}" href="{{ route('admin.programs.index') }}">{{ __('admin.menu.programs') }}</a>
    <a class="menu-top {{ request()->routeIs('admin.learning-models.*') ? 'active' : '' }}" href="{{ route('admin.learning-models.index') }}">{{ __('admin.menu.learning_models') }}</a>
    <a class="menu-top {{ request()->routeIs('admin.library-items.*') ? 'active' : '' }}" href="{{ route('admin.library-items.index') }}">{{ __('admin.menu.library') }}</a>
    <a class="menu-top {{ request()->routeIs('admin.documents.*') ? 'active' : '' }}" href="{{ route('admin.documents.index') }}">{{ __('admin.menu.documents') }}</a>
    <a class="menu-top {{ request()->routeIs('admin.galleries.*') ? 'active' : '' }}" href="{{ route('admin.galleries.index') }}">{{ __('admin.menu.galleries') }}</a>
    <a class="menu-top {{ request()->routeIs('admin.pages.*') ? 'active' : '' }}" href="{{ route('admin.pages.index') }}">{{ __('admin.menu.pages') }}</a>
    <a class="menu-top {{ request()->routeIs('admin.registrations.*') ? 'active' : '' }}" href="{{ route('admin.registrations.index') }}">{{ __('admin.menu.registrations') }}</a>
    <a class="menu-top {{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}" href="{{ route('admin.contacts.index') }}">{{ __('admin.menu.contacts') }}</a>
    <a class="menu-top {{ request()->routeIs('admin.media.*') ? 'active' : '' }}" href="{{ route('admin.media.index') }}">{{ __('admin.menu.media') }}</a>
    <a class="menu-top {{ request()->routeIs('admin.menus.*') ? 'active' : '' }}" href="{{ route('admin.menus.index') }}">{{ __('admin.menu.menus') }}</a>
    <a class="menu-top {{ request()->routeIs('admin.sliders.*') ? 'active' : '' }}" href="{{ route('admin.sliders.index') }}">{{ __('admin.menu.sliders') }}</a>
    <a class="menu-top {{ request()->routeIs('admin.banners.*') ? 'active' : '' }}" href="{{ route('admin.banners.index') }}">{{ __('admin.menu.banners') }}</a>
    <a class="menu-top {{ request()->routeIs('admin.widgets.*') ? 'active' : '' }}" href="{{ route('admin.widgets.index') }}">{{ __('admin.menu.widgets') }}</a>
    <a class="menu-top {{ request()->routeIs('admin.redirects.*') ? 'active' : '' }}" href="{{ route('admin.redirects.index') }}">{{ __('admin.menu.redirects') }}</a>
    <a class="menu-top {{ request()->routeIs('admin.activity.*') ? 'active' : '' }}" href="{{ route('admin.activity.index') }}">{{ __('admin.menu.activity') }}</a>
    <a class="menu-top {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">{{ __('admin.menu.users') }}</a>
    <a class="menu-top {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}" href="{{ route('admin.roles.index') }}">{{ __('admin.menu.roles') }}</a>
    <a class="menu-top {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}" href="{{ route('admin.settings.edit') }}">{{ __('admin.menu.settings') }}</a>
</div>
