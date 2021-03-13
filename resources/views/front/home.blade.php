<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
	@include('front.includes.head')
	{{-- <script src="https://js.stripe.com/v3/"></script> --}}
	<script
    src="https://www.paypal.com/sdk/js?client-id=ATtPI_opQL6EWca1qGbTZiVFuGgPXs5RaHLzKayLxMF_Y7USXm0ts1u9wYtFMrZs1nBcGV9xnTgCRSC6"> </script>
	<title>WrDesigns</title>
</head>
<body class="wr-desing-details">
	<div id="wrapp"></div>
@include('front.includes.footer_js')
<script src="{{ asset(mix('js/app.js')) }}"></script>
</body>
</html>
{{-- @extends('front.layouts.default')
@section('title','WrDesigns')
@section('content')
<div id="wrapp">
	
</div>
@endsection
@section('scripts')
<script src="{{ mix('js/app.js') }}"></script>
@endsection --}}