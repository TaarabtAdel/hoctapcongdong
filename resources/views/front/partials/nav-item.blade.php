@php
    $depth = $depth ?? 0;
    $inDropdown = $inDropdown ?? false;
    $path = ltrim(parse_url($item->url ?? '', PHP_URL_PATH) ?? '', '/');
    $isActive = $path !== '' && request()->is($path.'*');
    $children = $item->relationLoaded('children') ? $item->children : collect();
@endphp

@if($inDropdown)
    <a class="dropdown-item {{ $isActive ? 'active' : '' }}" href="{{ $item->url ?? '#' }}" @if($item->target) target="{{ $item->target }}" @endif style="{{ $depth > 1 ? 'padding-left:'.(1 + $depth * 0.75).'rem' : '' }}">
        {{ $item->label }}
    </a>
    @foreach($children as $child)
        @include('front.partials.nav-item', ['item' => $child, 'inDropdown' => true, 'depth' => $depth + 1])
    @endforeach
@elseif($children->isNotEmpty())
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle {{ $isActive ? 'active font-weight-bold' : '' }}" href="#" id="nav-{{ $item->id }}" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            @if($item->icon)<i class="{{ $item->icon }} mr-1" aria-hidden="true"></i>@endif
            {{ $item->label }}
        </a>
        <div class="dropdown-menu" aria-labelledby="nav-{{ $item->id }}">
            @if($item->url)
                <a class="dropdown-item font-weight-bold" href="{{ $item->url }}">{{ $item->label }}</a>
                <div class="dropdown-divider"></div>
            @endif
            @foreach($children as $child)
                @include('front.partials.nav-item', ['item' => $child, 'inDropdown' => true, 'depth' => 1])
            @endforeach
        </div>
    </li>
@else
    <li class="nav-item">
        <a class="nav-link {{ $isActive ? 'active font-weight-bold' : '' }}" href="{{ $item->url ?? '#' }}" @if($item->target) target="{{ $item->target }}" @endif>
            @if($item->icon)<i class="{{ $item->icon }} mr-1" aria-hidden="true"></i>@endif
            {{ $item->label }}
        </a>
    </li>
@endif
