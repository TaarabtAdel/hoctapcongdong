@php
    $primaryMenu = \App\Models\Menu::where('location', 'primary')->first();
    $menuItems = $primaryMenu
        ? $primaryMenu->items()->with(['children' => fn ($q) => $q->with('children')->orderBy('sort_order')])->orderBy('sort_order')->get()
        : collect();
@endphp
<nav class="main-nav navbar navbar-expand-lg navbar-dark" aria-label="{{ __('front.menu.main_nav') }}">
    <div class="container">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Menu">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav mr-auto">
                @foreach($menuItems as $item)
                    @include('front.partials.nav-item', ['item' => $item])
                @endforeach
            </ul>
            <form class="form-inline" action="{{ route('front.search') }}" method="get" role="search">
                <label for="nav-search" class="sr-only">{{ __('front.home.search_placeholder') }}</label>
                <input id="nav-search" class="form-control form-control-sm" type="search" name="q" placeholder="{{ __('front.home.search_placeholder') }}" value="{{ request('q') }}">
            </form>
        </div>
    </div>
</nav>
