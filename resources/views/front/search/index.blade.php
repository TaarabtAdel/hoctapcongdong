@extends('front.layouts.app')
@section('content')
<div class="container py-4"><h1 class="h3">Tìm kiếm: {{ $q }}</h1>
@forelse($groups as $label => $results)
@if($results->count())<h2 class="h5 mt-3">{{ $label }}</h2><ul>@foreach($results as $r)<li>{{ $r->title }}</li>@endforeach</ul>@endif
@empty
<p>Không có kết quả.</p>
@endforelse
</div>
@endsection
