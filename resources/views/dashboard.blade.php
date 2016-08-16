@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
	<div class="container">

		@include('common.errors')

		<div style="text-align:center; margin-top:100px">
			<h2><strong>Welcome {{ $name }}</strong></h2>
		</div>
	</div>
@endsection

@section('js-css')
	<!-- jQuery -->
	<script src="//code.jquery.com/jquery.js"></script>
@endsection
