@extends('front.layouts.app')

@section('content')
<section class="py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <h1 class="display-4 font-weight-bold">
                    {{ $siteSettings['hero_title_1'] ?? 'Học tập suốt đời,' }}<br>
                    <span class="hero-title-accent">{{ $siteSettings['hero_title_2'] ?? 'ngay tại cộng đồng của bạn' }}</span>
                </h1>
                <p class="lead">{{ $siteSettings['hero_description'] ?? '' }}</p>
                <a href="{{ route('front.registration.create') }}" class="btn btn-primary btn-lg mr-2 mb-2">{{ __('front.menu.register') }}</a>
                <a href="{{ route('front.events.index') }}" class="btn btn-outline-primary btn-lg mb-2">{{ __('front.home.view_schedule') }}</a>
            </div>
            <div class="col-lg-6">
                <div class="card-soft overflow-hidden position-relative">
                    <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?w=900&q=80" class="img-fluid" alt="Hoạt động học tập" loading="lazy">
                    @if($blocks['heroSlides']->first()?->badge_text)
                        <span class="badge badge-primary position-absolute m-3 p-2">{{ $blocks['heroSlides']->first()->badge_text }}</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<section class="pb-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="h5 font-weight-bold mb-0">{{ __('front.home.announcements') }}</h2>
                    <a href="{{ route('front.announcements.index') }}">{{ __('front.home.view_all') }}</a>
                </div>
                @foreach($blocks['announcements'] as $item)
                    <article class="mb-3 d-flex">
                        @php $date = $item->published_at ?? $item->created_at; @endphp
                        <div class="date-box mr-3 flex-shrink-0">
                            <div class="day">{{ $date?->format('d') }}</div>
                            <div class="month">{{ $date?->format('m/Y') }}</div>
                        </div>
                        <div>
                            <h3 class="h6 mb-1"><a href="{{ route('front.announcements.show', $item->slug) }}">{{ $item->title }}</a></h3>
                            <p class="small text-muted mb-0">{{ $item->excerpt }}</p>
                        </div>
                    </article>
                @endforeach

                <h2 class="h5 font-weight-bold mt-4 mb-3">{{ __('front.home.events') }}</h2>
                @foreach($blocks['events'] as $event)
                    <article class="mb-3">
                        <div class="small text-muted">{{ $event->start_at?->format('d/m/Y') }}</div>
                        <h3 class="h6 mb-1">{{ $event->title }}</h3>
                        <div class="small"><i class="far fa-clock"></i> {{ $event->start_at?->format('H:i') }} @if($event->end_at) - {{ $event->end_at->format('H:i') }} @endif</div>
                        <div class="small"><i class="fas fa-map-marker-alt"></i> {{ $event->location }}</div>
                    </article>
                @endforeach
            </div>

            <div class="col-lg-4 mb-4">
                <h2 class="h5 font-weight-bold mb-3">{{ __('front.home.programs') }}</h2>
                <div class="row">
                    @foreach($blocks['programs'] as $program)
                        <div class="col-6 mb-3">
                            <a href="{{ route('front.programs.show', $program->slug) }}" class="program-card d-block text-white" style="background: {{ $program->color ?? '#0b57c9' }}">
                                @if($program->icon)<i class="{{ $program->icon }} d-block mb-2"></i>@endif
                                <span class="small">{{ $program->title }}</span>
                            </a>
                        </div>
                    @endforeach
                </div>

                <h2 class="h5 font-weight-bold mt-2 mb-3">{{ __('front.home.library') }}</h2>
                <div class="d-flex flex-wrap mb-3">
                    @foreach($blocks['libraryTypes'] as $type)
                        <div class="text-center mr-3 mb-2" style="width:72px">
                            <div class="rounded-circle d-inline-flex align-items-center justify-content-center text-white mb-1" style="width:48px;height:48px;background:{{ $type->color ?? '#0b57c9' }}">
                                <i class="{{ $type->icon ?? 'fas fa-book' }}"></i>
                            </div>
                            <div class="small">{{ $type->name }}</div>
                        </div>
                    @endforeach
                </div>
                <div class="card-soft p-3 bg-dark text-white text-center">
                    <div>{{ $siteSettings['library_banner_text'] ?? '' }}</div>
                    <a href="{{ url('/thu-vien-so') }}" class="btn btn-light btn-sm mt-2">Khám phá kho tư liệu mở</a>
                </div>
            </div>

            <div class="col-lg-4 mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="h5 font-weight-bold mb-0">{{ __('front.home.news') }}</h2>
                    <a href="{{ route('front.news.index') }}">{{ __('front.home.view_all') }}</a>
                </div>
                @foreach($blocks['news'] as $news)
                    <article class="mb-3 media">
                        <div class="media-body">
                            <div class="small text-muted">{{ $news->published_at?->format('d/m/Y') }}</div>
                            <h3 class="h6 mb-0"><a href="{{ route('front.news.show', $news->slug) }}">{{ $news->title }}</a></h3>
                        </div>
                    </article>
                @endforeach

                <div class="card-soft p-3 mb-3 mt-4">
                    <h2 class="h6 font-weight-bold">{{ __('front.home.role_models') }}</h2>
                    <p class="small mb-2">Gia đình học tập, dòng họ học tập, cộng đồng học tập và những mô hình tự học hiệu quả tại địa phương.</p>
                    <a href="{{ url('/guong-hoc-tap') }}" class="btn btn-outline-primary btn-sm">Xem các gương tiêu biểu</a>
                </div>

                <div class="card-soft p-4 text-white" style="background: var(--primary)">
                    <h2 class="h5 font-weight-bold">{{ __('front.menu.register') }}</h2>
                    <p class="small">{{ __('front.home.register_cta') }}</p>
                    <a href="{{ route('front.registration.create') }}" class="btn btn-light">{{ __('front.home.register_now') }} &rsaquo;</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section-muted py-5">
    <div class="container text-center">
        <h2 class="h4 font-weight-bold mb-2">{{ __('front.home.lifelong_title') }}</h2>
        <p class="text-muted mb-4">Bốn mô hình học tập suốt đời được triển khai tại địa phương.</p>
        <div class="row">
            @foreach($blocks['learningModels'] as $model)
                <div class="col-md-3 mb-3">
                    <div class="card-soft p-4 h-100">
                        <i class="{{ $model->icon ?? 'fas fa-star' }} fa-2x mb-3" style="color: {{ $model->color ?? '#0b57c9' }}"></i>
                        <h3 class="h6">{{ $model->title }}</h3>
                        <p class="small text-muted">{{ $model->excerpt }}</p>
                        <a href="{{ route('front.learning-models.show', $model->slug) }}">Tiêu chí</a>
                    </div>
                </div>
            @endforeach
        </div>
        <a href="{{ route('front.learning-models.index') }}" class="btn btn-primary mt-2">Tìm hiểu tiêu chuẩn các mô hình học tập &rarr;</a>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mb-4">
                <h2 class="h5 font-weight-bold mb-3">{{ __('front.home.documents') }}</h2>
                @foreach($blocks['documents'] as $doc)
                    <div class="d-flex align-items-start mb-3">
                        @if($doc->documentLevel)
                            <span class="badge mr-2" style="background: {{ $doc->documentLevel->color ?? '#6c757d' }}">{{ $doc->documentLevel->name }}</span>
                        @endif
                        <div class="flex-grow-1">
                            <div class="font-weight-bold">{{ $doc->title }}</div>
                            <div class="small text-muted">{{ $doc->document_number }} · {{ $doc->issued_at?->format('d/m/Y') }}</div>
                        </div>
                        <a href="{{ route('front.documents.download', $doc->slug) }}" class="btn btn-sm btn-outline-secondary"><i class="fas fa-download"></i></a>
                    </div>
                @endforeach
            </div>
            <div class="col-lg-6 mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2 class="h5 font-weight-bold mb-0">{{ __('front.home.gallery') }}</h2>
                    <a href="{{ route('front.gallery.index') }}">{{ __('front.home.view_all') }}</a>
                </div>
                @php $homeGallery = $blocks['galleries']->first(); @endphp
                <div class="row">
                    @if($homeGallery)
                        @foreach($homeGallery->items->take(6) as $gi)
                            <div class="col-4 mb-2">
                                @if($gi->media)
                                    <a href="{{ route('front.gallery.show', $homeGallery->slug) }}" class="d-block card-soft overflow-hidden" style="height:90px;background:url('{{ $gi->media->url('thumb') }}') center/cover"></a>
                                @endif
                            </div>
                        @endforeach
                    @else
                        <p class="small text-muted col-12">Chưa có album.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
