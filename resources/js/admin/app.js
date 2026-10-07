import $ from 'jquery';
import 'bootstrap/dist/js/bootstrap.bundle';
import 'select2';
import Swal from 'sweetalert2';
import flatpickr from 'flatpickr';
import Sortable from 'sortablejs';

window.$ = window.jQuery = $;
window.Swal = Swal;
window.flatpickr = flatpickr;

let mediaPickerTarget = null;
let mediaPickerPreview = null;

function adminBase() {
    const meta = document.querySelector('meta[name="admin-base"]');
    return meta ? meta.content.replace(/\/$/, '') : '/admin';
}

function loadMediaGrid(search = '') {
    const url = new URL(`${adminBase()}/ajax/media`, window.location.origin);
    if (search) url.searchParams.set('s', search);
    fetch(url, { headers: { Accept: 'application/json' } })
        .then(r => r.json())
        .then(data => {
            const grid = document.getElementById('media-modal-grid');
            if (!grid) return;
            grid.innerHTML = (data.items || []).map(item => {
                const thumb = item.url || `/storage/${item.path}`;
                return `<div class="col-6 col-md-3 mb-3">
                    <button type="button" class="btn btn-light p-0 w-100 border media-pick" data-id="${item.id}" data-url="${thumb}">
                        <img src="${thumb}" alt="" class="img-fluid" style="height:100px;object-fit:cover;width:100%">
                        <div class="small text-truncate p-1">${item.original_filename || item.id}</div>
                    </button>
                </div>`;
            }).join('');
        });
}

function bindMediaPicker() {
    document.body.addEventListener('click', e => {
        const btn = e.target.closest('[data-media-picker]');
        if (!btn) return;
        e.preventDefault();
        const targetSel = btn.getAttribute('data-target');
        mediaPickerTarget = targetSel.startsWith('.') ? document.querySelector(targetSel) : document.querySelector(targetSel);
        mediaPickerPreview = btn.getAttribute('data-preview') ? document.querySelector(btn.getAttribute('data-preview')) : null;
        loadMediaGrid();
        $('#mediaLibraryModal').modal('show');
    });

    document.body.addEventListener('click', e => {
        const pick = e.target.closest('.media-pick');
        if (!pick || !mediaPickerTarget) return;
        const id = pick.dataset.id;
        const url = pick.dataset.url;
        if (mediaPickerTarget.tagName === 'INPUT') {
            mediaPickerTarget.value = id;
        }
        if (mediaPickerPreview && url) {
            mediaPickerPreview.innerHTML = `<img src="${url}" class="img-fluid rounded" style="max-height:120px" alt="">`;
        }
        $('#mediaLibraryModal').modal('hide');
    });

    const searchEl = document.getElementById('media-modal-search');
    if (searchEl) {
        searchEl.addEventListener('input', () => loadMediaGrid(searchEl.value));
    }

    const uploadEl = document.getElementById('media-modal-upload');
    if (uploadEl) {
        uploadEl.addEventListener('change', () => {
            const fd = new FormData();
            [...uploadEl.files].forEach(f => fd.append('files[]', f));
            fetch(`${adminBase()}/media`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    Accept: 'application/json',
                },
                body: fd,
            }).then(r => r.json()).then(() => {
                uploadEl.value = '';
                loadMediaGrid(searchEl?.value || '');
            });
        });
    }
}

function initGalleryRows() {
    const list = document.getElementById('gallery-items-list');
    const tpl = document.getElementById('gallery-item-template');
    const addBtn = document.getElementById('gallery-add-row');
    if (!list || !tpl || !addBtn) return;

    let index = list.querySelectorAll('.gallery-item-row').length;
    addBtn.addEventListener('click', () => {
        list.insertAdjacentHTML('beforeend', tpl.innerHTML.replace(/__INDEX__/g, String(index++)));
    });
    list.addEventListener('click', e => {
        if (e.target.classList.contains('gallery-remove-row')) {
            e.target.closest('.gallery-item-row')?.remove();
        }
    });
    Sortable.create(list, { handle: '.gallery-item-row', animation: 150 });
}

function initQuickEdit() {
    document.querySelectorAll('[data-quick-edit]').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.id;
            const title = prompt('Tiêu đề mới:', btn.dataset.title || '');
            if (title === null) return;
            const status = prompt('Trạng thái (draft/published/pending/scheduled/private):', btn.dataset.status || 'draft');
            if (status === null) return;
            const form = document.getElementById('quick-edit-form');
            if (!form) return;
            form.querySelector('[name=id]').value = id;
            form.querySelector('[name=title]').value = title;
            form.querySelector('[name=status]').value = status;
            form.submit();
        });
    });
}

document.addEventListener('DOMContentLoaded', () => {
    $('.select2').select2({ width: '100%' });
    flatpickr('.datetime-picker', { enableTime: true, dateFormat: 'Y-m-d H:i' });
    flatpickr('.flatpickr-date', { dateFormat: 'Y-m-d' });

    const editorEl = document.querySelector('#content-editor');
    if (editorEl && window.tinymce) {
        window.tinymce.init({
            target: editorEl,
            height: 420,
            menubar: false,
            plugins: 'link lists code table fullscreen wordcount media',
            toolbar: 'undo redo | styles | bold italic underline | alignleft aligncenter alignright | bullist numlist | link media medialibrary | table code fullscreen',
            branding: false,
            license_key: 'gpl',
            base_url: '/vendor/tinymce',
            suffix: '.min',
            setup(editor) {
                editor.ui.registry.addButton('medialibrary', {
                    text: 'Media',
                    onAction() {
                        mediaPickerTarget = { tagName: 'TINYMCE', editor };
                        loadMediaGrid();
                        $('#mediaLibraryModal').modal('show');
                    },
                });
            },
        });
    }

    document.body.addEventListener('click', e => {
        const pick = e.target.closest('.media-pick');
        if (!pick || !mediaPickerTarget) return;
        const url = pick.dataset.url;
        if (mediaPickerTarget.tagName === 'TINYMCE' && mediaPickerTarget.editor) {
            mediaPickerTarget.editor.insertContent(`<img src="${url}" alt="">`);
            $('#mediaLibraryModal').modal('hide');
            mediaPickerTarget = null;
            return;
        }
    });

    bindMediaPicker();
    initGalleryRows();
    initQuickEdit();

    function initMenuSortable() {
        document.querySelectorAll('#menu-tree-root, .menu-tree-children').forEach(el => {
            if (el.dataset.sortableBound) return;
            el.dataset.sortableBound = '1';
            Sortable.create(el, {
                group: 'menu-nested',
                animation: 150,
                handle: '.menu-tree-handle',
                fallbackOnBody: true,
                swapThreshold: 0.65,
            });
        });
    }
    window.initMenuSortable = initMenuSortable;

    const menuTreeRoot = document.getElementById('menu-tree-root');
    if (menuTreeRoot) {
        initMenuSortable();
        const tpl = document.getElementById('menu-node-template');
        menuTreeRoot.addEventListener('click', e => {
            const addChild = e.target.closest('[data-add-child]');
            if (!addChild || !tpl) return;
            e.preventDefault();
            const parentLi = addChild.closest('[data-menu-node]');
            const childUl = parentLi.querySelector(':scope > .menu-tree-children');
            const uid = 'new-' + Date.now();
            childUl.insertAdjacentHTML('beforeend', tpl.innerHTML.replace(/__NODE_ID__/g, uid).replace(/__LABEL__/g, 'Mục con').replace(/__URL__/g, '#'));
            initMenuSortable();
        });
    }

    const autosaveForm = document.querySelector('[data-autosave]');
    const autosaveUrl = autosaveForm?.dataset.autosave;
    if (autosaveForm && autosaveUrl) {
        setInterval(() => {
            const formData = new FormData(autosaveForm);
            fetch(autosaveUrl, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
                body: formData,
            }).then(r => r.json()).then(data => {
                const el = document.getElementById('autosave-status');
                if (el && data.saved_at) el.textContent = `Đã lưu tự động lúc ${data.saved_at}`;
            });
        }, 60000);
    }
});
