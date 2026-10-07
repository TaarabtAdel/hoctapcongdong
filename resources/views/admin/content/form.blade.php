@extends('admin.layouts.app')

@push('scripts')
<script src="{{ asset('vendor/tinymce/tinymce.min.js') }}"></script>
@endpush

@section('title', $item->exists ? __('admin.actions.edit').': '.$item->title : __('admin.actions.add_new').' '.$singularLabel)

@section('content')
<form method="post" action="{{ $item->exists ? route($routePrefix.'.update', $item) : route($routePrefix.'.store') }}"
      data-autosave="{{ $item->exists ? route($routePrefix.'.autosave') : '' }}" id="content-form">
    @csrf
    @if($item->exists) @method('PUT') @endif
    <input type="hidden" name="id" value="{{ $item->id }}">

    <div class="row">
        <div class="col-lg-8">
            <input type="text" name="title" class="form-control form-control-lg mb-2" placeholder="Tiêu đề" value="{{ old('title', $item->title) }}" required>
            <div class="mb-2 small">
                Permalink: <code>{{ url('/.../') }}<input type="text" name="slug" value="{{ old('slug', $item->slug) }}" class="form-control form-control-sm d-inline-block w-auto"></code>
            </div>
            <textarea id="content-editor" name="content" class="form-control" rows="12">{{ old('content', $item->content) }}</textarea>
            <div id="autosave-status" class="small text-muted mt-1"></div>

            @include('admin.content.partials.module-fields')

            <div class="postbox mt-3">
                <div class="postbox-header">Tóm tắt</div>
                <div class="inside"><textarea name="excerpt" class="form-control" rows="3">{{ old('excerpt', $item->excerpt) }}</textarea></div>
            </div>

            <div class="postbox">
                <div class="postbox-header">SEO</div>
                <div class="inside">
                    <input type="text" name="seo_title" class="form-control mb-2" placeholder="Tiêu đề SEO" value="{{ old('seo_title', $item->seo_title) }}">
                    <textarea name="seo_description" class="form-control mb-2" rows="2" placeholder="Mô tả SEO">{{ old('seo_description', $item->seo_description) }}</textarea>
                    <input type="text" name="seo_keywords" class="form-control" placeholder="Từ khóa" value="{{ old('seo_keywords', $item->seo_keywords) }}">
                </div>
            </div>

            @if($item->exists && !empty($revisions) && $revisions->count())
                <div class="postbox mt-3">
                    <div class="postbox-header">Phiên bản gần đây</div>
                    <div class="inside">
                        <ul class="list-unstyled mb-0 small">
                            @foreach($revisions as $rev)
                                <li class="d-flex justify-content-between align-items-center mb-1">
                                    <span>{{ $rev->created_at?->format('d/m/Y H:i') }} — {{ $rev->user?->name ?? 'Hệ thống' }}</span>
                                    <form method="post" action="{{ route($routePrefix.'.restore-revision') }}" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="revision_id" value="{{ $rev->id }}">
                                        <button type="submit" class="btn btn-link btn-sm p-0" onclick="return confirm('Khôi phục phiên bản này?')">Khôi phục</button>
                                    </form>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
        </div>
        <div class="col-lg-4">
            <div class="postbox">
                <div class="postbox-header">Đăng</div>
                <div class="inside">
                    <select name="status" class="form-control mb-2">
                        @foreach(\App\Enums\ContentStatus::cases() as $st)
                            <option value="{{ $st->value }}" @selected(old('status', $item->status?->value ?? 'draft') === $st->value)>{{ $st->label() }}</option>
                        @endforeach
                    </select>
                    <input type="text" name="published_at" class="form-control datetime-picker mb-2" placeholder="Ngày đăng" value="{{ old('published_at', optional($item->published_at)->format('Y-m-d H:i')) }}">
                    @if($item->exists && !empty($signedPreviewUrl))
                        <a href="{{ $signedPreviewUrl }}" class="btn btn-outline-secondary btn-block btn-sm mb-2" target="_blank" rel="noopener">Xem trước (có chữ ký)</a>
                    @endif
                    @if(!empty($previewUrl) && ($item->status?->value ?? '') === 'published')
                        <a href="{{ $previewUrl }}" class="btn btn-link btn-sm btn-block mb-2" target="_blank">Xem trên site</a>
                    @endif
                    <button type="submit" class="btn btn-primary btn-block">{{ $item->exists ? __('admin.actions.update') : __('admin.actions.save') }}</button>
                </div>
            </div>
            <div class="postbox">
                <div class="postbox-header">Ảnh đại diện</div>
                <div class="inside">
                    <input type="hidden" name="featured_image_id" id="featured_image_id" value="{{ old('featured_image_id', $item->featured_image_id) }}">
                    <div id="featured-image-preview" class="mb-2">
                        @if($item->featuredImage)
                            <img src="{{ $item->featuredImage->url('thumb') }}" alt="" class="img-fluid rounded" style="max-height:120px">
                        @endif
                    </div>
                    <button type="button" class="btn btn-outline-primary btn-sm btn-block" data-media-picker data-target="#featured_image_id" data-preview="#featured-image-preview">Chọn ảnh</button>
                    <button type="button" class="btn btn-link btn-sm btn-block" onclick="document.getElementById('featured_image_id').value='';document.getElementById('featured-image-preview').innerHTML=''">Xóa ảnh</button>
                </div>
            </div>
        </div>
    </div>
</form>

@include('admin.partials.media-modal')
@endsection
