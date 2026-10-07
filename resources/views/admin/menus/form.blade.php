@extends('admin.layouts.app')
@section('title', $menu->exists ? 'Sửa menu' : 'Thêm menu')
@section('content')
<form method="post" action="{{ $menu->exists ? route('admin.menus.update', $menu) : route('admin.menus.store') }}" id="menu-editor-form">
    @csrf
    @if($menu->exists) @method('PUT') @endif
    <input type="hidden" name="items_tree" id="items_tree" value="">

    <input name="name" class="form-control mb-2" value="{{ old('name', $menu->name) }}" placeholder="Tên menu">
    <input name="location" class="form-control mb-2" value="{{ old('location', $menu->location) }}" placeholder="primary / footer">

    @if($menu->exists)
        <div class="d-flex justify-content-between align-items-center mt-3 mb-2">
            <h2 class="h6 mb-0">Cấu trúc menu (kéo thả, lồng mục con)</h2>
            <button type="button" class="btn btn-sm btn-outline-primary" id="menu-add-root">{{ __('admin.menu.add_item') }}</button>
        </div>
        <p class="small text-muted">Kéo mục sang phải để làm con; kéo lên/xuống để sắp xếp.</p>

        <ul id="menu-tree-root" class="menu-tree list-unstyled mb-3" data-menu-id="{{ $menu->id }}">
            @foreach($menu->items as $item)
                @include('admin.menus.partials.tree-node', ['node' => $item])
            @endforeach
        </ul>

        <template id="menu-node-template">
            @include('admin.menus.partials.tree-node', ['node' => null])
        </template>
    @endif

    <button class="btn btn-primary">{{ __('admin.actions.save') }}</button>
</form>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('menu-editor-form');
    const root = document.getElementById('menu-tree-root');
    if (!form || !root) return;

    const menuId = root.dataset.menuId;
    const tpl = document.getElementById('menu-node-template');

    function bindRemove() {
        root.querySelectorAll('[data-remove-node]').forEach(btn => {
            btn.onclick = () => {
                if (!confirm('Xóa mục menu này?')) return;
                const id = btn.closest('[data-menu-node]')?.dataset?.id;
                if (id && !String(id).startsWith('new-')) {
                    fetch(`${document.querySelector('meta[name="admin-base"]').content}/menus/${menuId}/items/${id}`, {
                        method: 'DELETE',
                        headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content, Accept: 'application/json' },
                    });
                }
                btn.closest('[data-menu-node]')?.remove();
            };
        });
    }

    document.getElementById('menu-add-root')?.addEventListener('click', () => {
        const uid = 'new-' + Date.now();
        const html = tpl.innerHTML.replace(/__NODE_ID__/g, uid).replace(/__LABEL__/g, 'Mục mới').replace(/__URL__/g, '#');
        root.insertAdjacentHTML('beforeend', html);
        bindRemove();
        window.initMenuSortable?.();
    });

    function serializeList(ul) {
        const nodes = [];
        ul.querySelectorAll(':scope > li[data-menu-node]').forEach((li, order) => {
            const id = li.dataset.id;
            const node = {
                id: String(id).startsWith('new-') ? null : parseInt(id, 10),
                label: li.querySelector('[data-field=label]')?.value || '',
                url: li.querySelector('[data-field=url]')?.value || '',
                icon: li.querySelector('[data-field=icon]')?.value || '',
                sort_order: order,
                children: [],
            };
            const childUl = li.querySelector(':scope > ul.menu-tree-children');
            if (childUl) node.children = serializeList(childUl);
            nodes.push(node);
        });
        return nodes;
    }

    form.addEventListener('submit', () => {
        document.getElementById('items_tree').value = JSON.stringify(serializeList(root));
    });

    bindRemove();
});
</script>
@endpush
