@extends('front.common.main')
@section('contents')
<div class="payment-page">
<div class="container">
    @if(Session::has('success_message'))
    <p class="alert alert-success">{{ Session::get('success_message') }}</p>
    @endif
	<h5>Scan to make payment</h5>
	<div class="row">
		<div class="col-md-4 offset-md-4">
			<img src="images/qrscan.png">
		</div>
	</div>
</div>
</div>
@endsection