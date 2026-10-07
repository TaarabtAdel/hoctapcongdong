@extends('admin.layouts.app')
@section('title', __('admin.menu.media'))
@section('content')
<form method="post" action="{{ route('admin.media.store') }}" enctype="multipart/form-data" class="mb-3">@csrf<input type="file" name="files[]" multiple><button class="btn btn-primary btn-sm ml-2">Tải lên</button></form>
<div class="row">@foreach($media as $m)<div class="col-md-2 mb-3"><div class="postbox p-2 text-center small">{{ $m->original_filename }}</div></div>@endforeach</div>
{{ $media->links() }}
@endsection
