@php $rp = $routePrefix ?? ''; @endphp

@if($rp === 'admin.news')
    <div class="postbox mt-3">
        <div class="postbox-header">Danh mục & thẻ</div>
        <div class="inside">
            <label class="small font-weight-bold">Danh mục</label>
            <select name="category_ids[]" class="form-control select2 mb-2" multiple>
                @foreach($newsCategories ?? [] as $cat)
                    <option value="{{ $cat->id }}" @selected(in_array($cat->id, old('category_ids', $selectedCategories ?? [])))>{{ $cat->name }}</option>
                @endforeach
            </select>
            <label class="small font-weight-bold">Thẻ (chọn)</label>
            <select name="tag_ids[]" class="form-control select2 mb-2" multiple>
                @foreach($tags ?? [] as $tag)
                    <option value="{{ $tag->id }}" @selected(in_array($tag->id, old('tag_ids', $selectedTags ?? [])))>{{ $tag->name }}</option>
                @endforeach
            </select>
            <label class="small font-weight-bold">Thẻ mới (phân cách bằng dấu phẩy)</label>
            <input type="text" name="tag_names" class="form-control" value="{{ old('tag_names') }}" placeholder="học tập, cộng đồng">
        </div>
    </div>
@endif

@if($rp === 'admin.events')
    <div class="postbox mt-3">
        <div class="postbox-header">Thông tin sự kiện</div>
        <div class="inside">
            <input type="text" name="start_at" class="form-control datetime-picker mb-2" placeholder="Bắt đầu" value="{{ old('start_at', optional($item->start_at)->format('Y-m-d H:i')) }}">
            <input type="text" name="end_at" class="form-control datetime-picker mb-2" placeholder="Kết thúc" value="{{ old('end_at', optional($item->end_at)->format('Y-m-d H:i')) }}">
            <input type="text" name="location" class="form-control mb-2" placeholder="Địa điểm" value="{{ old('location', $item->location ?? '') }}">
            <input type="text" name="audience" class="form-control mb-2" placeholder="Đối tượng" value="{{ old('audience', $item->audience ?? '') }}">
            <input type="url" name="registration_url" class="form-control" placeholder="Link đăng ký" value="{{ old('registration_url', $item->registration_url ?? '') }}">
        </div>
    </div>
@endif

@if($rp === 'admin.announcements')
    <div class="postbox mt-3">
        <div class="postbox-header">Thông báo</div>
        <div class="inside">
            <div class="custom-control custom-checkbox mb-2">
                <input type="checkbox" class="custom-control-input" id="is_pinned" name="is_pinned" value="1" @checked(old('is_pinned', $item->is_pinned ?? false))>
                <label class="custom-control-label" for="is_pinned">Ghim lên đầu</label>
            </div>
            <input type="text" name="expires_at" class="form-control datetime-picker" placeholder="Hết hạn (tuỳ chọn)" value="{{ old('expires_at', optional($item->expires_at ?? null)->format('Y-m-d H:i')) }}">
        </div>
    </div>
@endif

@if($rp === 'admin.documents')
    <div class="postbox mt-3">
        <div class="postbox-header">Văn bản</div>
        <div class="inside">
            <select name="document_level_id" class="form-control mb-2">
                <option value="">— Cấp ban hành —</option>
                @foreach($documentLevels ?? [] as $level)
                    <option value="{{ $level->id }}" @selected(old('document_level_id', $item->document_level_id ?? '') == $level->id)>{{ $level->name }}</option>
                @endforeach
            </select>
            <input type="text" name="document_number" class="form-control mb-2" placeholder="Số hiệu" value="{{ old('document_number', $item->document_number ?? '') }}">
            <input type="text" name="issued_at" class="form-control mb-2 flatpickr-date" placeholder="Ngày ban hành" value="{{ old('issued_at', optional($item->issued_at ?? null)->format('Y-m-d')) }}">
            <input type="text" name="issuing_agency" class="form-control mb-2" placeholder="Cơ quan ban hành" value="{{ old('issuing_agency', $item->issuing_agency ?? '') }}">
            <label class="small">Tệp đính kèm (ID media)</label>
            <div class="input-group mb-2">
                <input type="number" name="file_media_id" id="file_media_id" class="form-control" value="{{ old('file_media_id', $item->file_media_id ?? '') }}">
                <div class="input-group-append">
                    <button type="button" class="btn btn-outline-secondary" data-media-picker data-target="#file_media_id">Chọn</button>
                </div>
            </div>
        </div>
    </div>
@endif

@if($rp === 'admin.library-items')
    <div class="postbox mt-3">
        <div class="postbox-header">Thư viện số</div>
        <div class="inside">
            <select name="library_type_id" class="form-control mb-2">
                <option value="">— Loại tài liệu —</option>
                @foreach($libraryTypes ?? [] as $type)
                    <option value="{{ $type->id }}" @selected(old('library_type_id', $item->library_type_id ?? '') == $type->id)>{{ $type->name }}</option>
                @endforeach
            </select>
            <input type="text" name="author_name" class="form-control mb-2" placeholder="Tác giả" value="{{ old('author_name', $item->author_name ?? '') }}">
            <input type="text" name="duration" class="form-control mb-2" placeholder="Thời lượng" value="{{ old('duration', $item->duration ?? '') }}">
            <input type="url" name="external_url" class="form-control mb-2" placeholder="Link ngoài" value="{{ old('external_url', $item->external_url ?? '') }}">
            <div class="input-group">
                <input type="number" name="file_media_id" id="library_file_media_id" class="form-control" value="{{ old('file_media_id', $item->file_media_id ?? '') }}" placeholder="ID file media">
                <div class="input-group-append">
                    <button type="button" class="btn btn-outline-secondary" data-media-picker data-target="#library_file_media_id">Chọn</button>
                </div>
            </div>
        </div>
    </div>
@endif

@if($rp === 'admin.pages')
    <div class="postbox mt-3">
        <div class="postbox-header">Thuộc tính trang</div>
        <div class="inside">
            <select name="parent_id" class="form-control mb-2">
                <option value="">— Trang cha —</option>
                @foreach($pages ?? [] as $page)
                    <option value="{{ $page->id }}" @selected(old('parent_id', $item->parent_id ?? '') == $page->id)>{{ $page->title }}</option>
                @endforeach
            </select>
            <select name="template" class="form-control mb-2">
                @foreach(['default' => 'Mặc định', 'full-width' => 'Toàn chiều rộng', 'contact' => 'Liên hệ', 'about' => 'Giới thiệu'] as $val => $label)
                    <option value="{{ $val }}" @selected(old('template', $item->template ?? 'default') === $val)>{{ $label }}</option>
                @endforeach
            </select>
            <input type="number" name="menu_order" class="form-control" placeholder="Thứ tự menu" value="{{ old('menu_order', $item->menu_order ?? 0) }}">
        </div>
    </div>
@endif

@if($rp === 'admin.role-models')
    <div class="postbox mt-3">
        <div class="postbox-header">Gương học tập</div>
        <div class="inside">
            <input type="text" name="person_name" class="form-control mb-2" placeholder="Họ tên / tên gia đình" value="{{ old('person_name', $item->person_name ?? '') }}">
            <select name="model_type" class="form-control mb-2">
                @foreach(['individual' => 'Cá nhân', 'family' => 'Gia đình', 'clan' => 'Dòng họ', 'community' => 'Cộng đồng'] as $val => $label)
                    <option value="{{ $val }}" @selected(old('model_type', $item->model_type ?? '') === $val)>{{ $label }}</option>
                @endforeach
            </select>
            <input type="text" name="address" class="form-control" placeholder="Địa chỉ" value="{{ old('address', $item->address ?? '') }}">
        </div>
    </div>
@endif

@if(in_array($rp, ['admin.learning-models', 'admin.programs'], true))
    <div class="postbox mt-3">
        <div class="postbox-header">Hiển thị</div>
        <div class="inside">
            <input type="text" name="icon" class="form-control mb-2" placeholder="Icon FA (vd: fas fa-book)" value="{{ old('icon', $item->icon ?? '') }}">
            <input type="text" name="color" class="form-control mb-2" placeholder="#0b57c9" value="{{ old('color', $item->color ?? '') }}">
            @if($rp === 'admin.programs')
                <input type="text" name="schedule_note" class="form-control" placeholder="Lịch học (ghi chú)" value="{{ old('schedule_note', $item->schedule_note ?? '') }}">
            @else
                <textarea name="criteria" class="form-control" rows="3" placeholder="Tiêu chí">{{ old('criteria', $item->criteria ?? '') }}</textarea>
            @endif
        </div>
    </div>
@endif

@if($rp === 'admin.galleries')
    <div class="postbox mt-3">
        <div class="postbox-header">Ảnh / video trong album</div>
        <div class="inside" id="gallery-items-list">
            @php
                $defaultGalleryRows = isset($galleryItems) && $galleryItems instanceof \Illuminate\Support\Collection
                    ? $galleryItems->map(fn ($gi) => $gi->only(['id','type','media_id','video_url','caption','sort_order']))->all()
                    : [];
            @endphp
            @foreach(old('gallery_items', $defaultGalleryRows) as $idx => $gi)
                @include('admin.content.partials.gallery-item-row', ['idx' => $idx, 'gi' => $gi])
            @endforeach
        </div>
        <button type="button" class="btn btn-sm btn-outline-primary m-2" id="gallery-add-row">+ Thêm mục</button>
    </div>
    <template id="gallery-item-template">
        @include('admin.content.partials.gallery-item-row', ['idx' => '__INDEX__', 'gi' => []])
    </template>
@endif
