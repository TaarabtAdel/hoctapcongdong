<div class="modal fade" id="mediaLibraryModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thư viện Media</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="d-flex mb-3">
                    <input type="search" id="media-modal-search" class="form-control form-control-sm mr-2" placeholder="Tìm file…">
                    <label class="btn btn-sm btn-outline-primary mb-0">
                        Tải lên <input type="file" id="media-modal-upload" multiple hidden accept="image/*,application/pdf">
                    </label>
                </div>
                <div id="media-modal-grid" class="row"></div>
            </div>
        </div>
    </div>
</div>
