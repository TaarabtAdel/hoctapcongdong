@extends('admin.layouts.app')

@section('title', __('admin.dashboard'))

@section('content')
<div class="row">
    @foreach($stats as $label => $count)
        <div class="col-md-4 mb-3">
            <div class="postbox"><div class="inside"><strong>{{ $count }}</strong> {{ $label }}</div></div>
        </div>
    @endforeach
</div>

<div class="postbox">
    <div class="postbox-header">Đăng ký học tập mới</div>
    <div class="inside">
        <table class="table table-sm mb-0">
            @foreach($recentRegistrations as $row)
                <tr>
                    <td>{{ $row->full_name }}</td>
                    <td>{{ $row->phone }}</td>
                    <td>{{ $row->created_at?->format('d/m/Y') }}</td>
                </tr>
            @endforeach
        </table>
    </div>
</div>

<form method="post" action="{{ route('admin.tools.clear-cache') }}" class="d-inline">@csrf<button class="btn btn-secondary btn-sm">Xóa cache</button></form>
<form method="post" action="{{ route('admin.tools.backup-database') }}" class="d-inline">@csrf<button class="btn btn-secondary btn-sm">Sao lưu CSDL</button></form>
@endsection
