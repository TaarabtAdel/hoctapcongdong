@extends('admin.layouts.app')
@section('title', __('admin.menu.banners'))
@section('title_actions')
    <a href="{{ route('admin.banners.create') }}" class="btn btn-primary btn-sm">{{ __('admin.actions.add_new') }}</a>
@endsection
@section('content')
<div class="card">
    <div class="card-body p-0">
        <table class="table table-striped mb-0">
            <thead>
                <tr>
                    <th>Tên</th>
                    <th>Vị trí</th>
                    <th>Ảnh</th>
                    <th>Hiển thị</th>
                    <th class="text-right">Thao tác</th>
                </tr>
            </thead>
            <tbody>
            @forelse($items as $item)
                <tr>
                    <td>
                        <strong>{{ $item->name }}</strong>
                        @if($item->title)
                            <div class="small text-muted">{{ $item->title }}</div>
                        @endif
                    </td>
                    <td><code>{{ $item->location }}</code></td>
                    <td>
                        @if($item->image)
                            <img src="{{ $item->image->url('thumb') }}" alt="" class="img-thumbnail" style="max-height:48px">
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td>{{ $item->is_active ? '✓' : '—' }}</td>
                    <td class="text-right">
                        <a href="{{ route('admin.banners.edit', $item) }}" class="btn btn-sm btn-outline-primary">{{ __('admin.actions.edit') }}</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">Chưa có banner. Bấm «{{ __('admin.actions.add_new') }}» để tạo.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
