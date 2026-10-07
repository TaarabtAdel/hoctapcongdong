<footer class="site-footer pt-5 pb-3 mt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4">
                <h5>Liên kết nhanh</h5>
                <ul class="list-unstyled">
                    <li><a href="{{ route('home') }}">Trang chủ</a></li>
                    <li><a href="{{ route('front.registration.create') }}">{{ __('front.menu.register') }}</a></li>
                    <li><a href="{{ route('front.learning-models.index') }}">{{ __('front.menu.lifelong') }}</a></li>
                </ul>
            </div>
            <div class="col-md-4 mb-4">
                <h5>Thông tin trung tâm</h5>
                <p class="mb-1">{{ $siteSettings['address'] ?? '' }}</p>
                <p class="mb-1">{{ $siteSettings['topbar_phone'] ?? '' }}</p>
                <p class="mb-1">{{ $siteSettings['person_in_charge'] ?? '' }}</p>
            </div>
            <div class="col-md-4 mb-4">
                <h5>Vị trí trụ sở</h5>
                @if(!empty($siteSettings['map_embed_url']))
                    <div class="embed-responsive embed-responsive-16by9 mb-2">
                        <iframe class="embed-responsive-item" src="{{ $siteSettings['map_embed_url'] }}" loading="lazy" title="Bản đồ"></iframe>
                    </div>
                @endif
                @if(!empty($siteSettings['map_link']))
                    <a class="btn btn-outline-light btn-sm" href="{{ $siteSettings['map_link'] }}" target="_blank" rel="noopener">Xem bản đồ</a>
                @endif
            </div>
        </div>
        <div class="border-top border-secondary pt-3 text-center small">
            {{ $siteSettings['copyright'] ?? '' }}
        </div>
    </div>
</footer>
