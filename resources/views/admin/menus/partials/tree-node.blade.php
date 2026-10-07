@php
    $id = $node?->id ?? '__NODE_ID__';
    $label = $node?->label ?? '__LABEL__';
    $url = $node?->url ?? '__URL__';
    $icon = $node?->icon ?? '';
    $children = $node ? ($node->relationLoaded('children') ? $node->children : collect()) : collect();
@endphp
<li class="menu-tree-node border rounded bg-white p-2 mb-2" data-menu-node data-id="{{ $id }}">
    <div class="d-flex align-items-start menu-tree-handle" style="cursor:move">
        <span class="text-muted mr-2 mt-1"><i class="fas fa-grip-vertical"></i></span>
        <div class="flex-grow-1">
            <input data-field="label" class="form-control form-control-sm mb-1" value="{{ $label }}" placeholder="Nhãn">
            <input data-field="url" class="form-control form-control-sm mb-1" value="{{ $url }}" placeholder="URL">
            <input data-field="icon" class="form-control form-control-sm" value="{{ $icon }}" placeholder="Icon (fas fa-home)">
        </div>
        <button type="button" class="btn btn-link btn-sm text-danger ml-1" data-remove-node aria-label="Xóa">&times;</button>
    </div>
    <ul class="menu-tree-children list-unstyled ml-4 mt-2">
        @foreach($children as $child)
            @include('admin.menus.partials.tree-node', ['node' => $child])
        @endforeach
    </ul>
    <button type="button" class="btn btn-link btn-sm p-0 mt-1" data-add-child>+ Mục con</button>
</li>
