@extends('front/common/main')
@section('contents')
<section class="page-title">
<div class="container">
    <h1>{{$page->title}}</h1>
</div>
</section>
<section class="page-detail" id="PageDetail">
	<div class="container">
		@if($page->media)
		{{$page->media->get_attachment()}}
		@endif
		{!!$page->detail!!}
	</div>
</section>
@endsection