@extends('admin.layouts.app')

@section('title', $singularLabel)

@section('title_actions')
    <a href="{{ route($routePrefix.'.create') }}" class="btn btn-primary btn-sm">{{ __('admin.actions.add_new') }}</a>
@endsection

@section('content')
<div class="d-flex justify-content-end mb-2">
    <button class="btn btn-link btn-sm" type="button" data-toggle="collapse" data-target="#screen-options-panel" aria-expanded="false">
        {{ __('admin.screen_options.title') }}
    </button>
</div>
<div id="screen-options-panel" class="collapse mb-3">
    <form method="post" action="{{ route('admin.screen-options.update') }}" class="postbox">
        @csrf
        @method('PUT')
        <input type="hidden" name="context" value="{{ $screenContext }}">
        <div class="inside">
            <p class="small text-muted mb-2">{{ __('admin.screen_options.help') }}</p>
            @foreach(['author' => 'Tác giả', 'status' => 'Trạng thái', 'date' => 'Ngày'] as $key => $label)
                <div class="custom-control custom-checkbox">
                    <input type="hidden" name="columns[{{ $key }}]" value="0">
                    <input type="checkbox" class="custom-control-input" id="col_{{ $key }}" name="columns[{{ $key }}]" value="1" @checked($columns[$key] ?? true)>
                    <label class="custom-control-label" for="col_{{ $key }}">{{ $label }}</label>
                </div>
            @endforeach
            <button type="submit" class="btn btn-sm btn-secondary mt-2">{{ __('admin.screen_options.apply') }}</button>
        </div>
    </form>
</div>

<ul class="nav nav-tabs mb-3">
    @foreach(['all' => __('admin.list.all'), 'published' => __('admin.list.published'), 'draft' => __('admin.list.draft'), 'pending' => __('admin.list.pending'), 'scheduled' => __('admin.list.scheduled'), 'trash' => __('admin.list.trash')] as $key => $label)
        <li class="nav-item">
            <a class="nav-link {{ ($status ?? 'all') === $key ? 'active' : '' }}" href="{{ route($routePrefix.'.index', ['status' => $key]) }}">
                {{ $label }} ({{ $counts[$key] ?? 0 }})
            </a>
        </li>
    @endforeach
</ul>

<form method="get" class="mb-3 form-inline">
    <input type="hidden" name="status" value="{{ $status ?? 'all' }}">
    <input type="search" name="s" value="{{ request('s') }}" class="form-control form-control-sm mr-2" placeholder="{{ __('admin.actions.search') }}">
    <button class="btn btn-sm btn-secondary">{{ __('admin.actions.search') }}</button>
</form>

<form method="post" action="{{ route($routePrefix.'.bulk') }}">
    @csrf
    <div class="mb-2 d-flex">
        <select name="action" class="form-control form-control-sm mr-2">
            <option value="">{{ __('admin.actions.bulk_actions') }}</option>
            <option value="publish">Đăng</option>
            <option value="draft">Chuyển nháp</option>
            <option value="trash">Thùng rác</option>
            <option value="restore">Khôi phục</option>
            <option value="force_delete">Xóa vĩnh viễn</option>
        </select>
        <button class="btn btn-sm btn-secondary">{{ __('admin.actions.apply') }}</button>
    </div>
    <table class="table table-striped bg-white">
        <thead>
        <tr>
            <th><input type="checkbox" onclick="document.querySelectorAll('.row-check').forEach(c=>c.checked=this.checked)"></th>
            <th>Tiêu đề</th>
            @if($columns['author'] ?? true)<th>Tác giả</th>@endif
            @if($columns['status'] ?? true)<th>Trạng thái</th>@endif
            @if($columns['date'] ?? true)<th>Ngày</th>@endif
        </tr>
        </thead>
        <tbody>
        @foreach($items as $item)
            <tr>
                <td><input class="row-check" type="checkbox" name="ids[]" value="{{ $item->id }}"></td>
                <td>
                    <a href="{{ route($routePrefix.'.edit', $item) }}"><strong>{{ $item->title }}</strong></a>
                    @if($item->status?->value === 'draft') — {{ __('content.status.draft') }} @endif
                    <div class="row-actions small">
                        <a href="{{ route($routePrefix.'.edit', $item) }}">{{ __('admin.actions.edit') }}</a> |
                        <button type="button" class="btn btn-link btn-sm p-0" data-quick-edit data-id="{{ $item->id }}" data-title="{{ $item->title }}" data-status="{{ $item->status?->value }}">Sửa nhanh</button> |
                        <form action="{{ route($routePrefix.'.destroy', $item) }}" method="post" class="d-inline" onsubmit="return confirm('Xác nhận?')">@csrf @method('DELETE')<button class="btn btn-link btn-sm p-0">{{ __('admin.actions.trash') }}</button></form>
                    </div>
                </td>
                @if($columns['author'] ?? true)<td>{{ $item->author?->name }}</td>@endif
                @if($columns['status'] ?? true)<td>{{ $item->status?->label() }}</td>@endif
                @if($columns['date'] ?? true)<td>{{ $item->published_at?->format('d/m/Y H:i') ?? $item->updated_at?->format('d/m/Y H:i') }}</td>@endif
            </tr>
        @endforeach
        </tbody>
    </table>
</form>
{{ $items->links() }}

<form id="quick-edit-form" method="post" action="{{ route($routePrefix.'.quick-edit') }}" class="d-none">
    @csrf
    <input type="hidden" name="id">
    <input type="hidden" name="title">
    <input type="hidden" name="status">
</form>
@endsection
