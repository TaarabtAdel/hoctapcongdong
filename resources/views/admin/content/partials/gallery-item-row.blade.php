<div class="border rounded p-2 mb-2 gallery-item-row">
    <input type="hidden" name="gallery_items[{{ $idx }}][id]" value="{{ $gi['id'] ?? '' }}">
    <div class="form-row">
        <div class="col-md-2">
            <select name="gallery_items[{{ $idx }}][type]" class="form-control form-control-sm">
                <option value="image" @selected(($gi['type'] ?? 'image') === 'image')>Ảnh</option>
                <option value="video" @selected(($gi['type'] ?? '') === 'video')>Video</option>
            </select>
        </div>
        <div class="col-md-3">
            <input type="number" name="gallery_items[{{ $idx }}][media_id]" class="form-control form-control-sm gallery-media-id" placeholder="Media ID" value="{{ $gi['media_id'] ?? '' }}">
        </div>
        <div class="col-md-4">
            <input type="url" name="gallery_items[{{ $idx }}][video_url]" class="form-control form-control-sm" placeholder="URL video (YouTube…)" value="{{ $gi['video_url'] ?? '' }}">
        </div>
        <div class="col-md-2">
            <input type="text" name="gallery_items[{{ $idx }}][caption]" class="form-control form-control-sm" placeholder="Chú thích" value="{{ $gi['caption'] ?? '' }}">
        </div>
        <div class="col-md-1">
            <button type="button" class="btn btn-sm btn-link text-danger gallery-remove-row">&times;</button>
        </div>
    </div>
    <button type="button" class="btn btn-link btn-sm p-0 mt-1" data-media-picker data-target=".gallery-item-row:last .gallery-media-id">Chọn ảnh</button>
</div>
