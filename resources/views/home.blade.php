@extends('layouts.app')

@section('title', 'Home')

@section('content')
	<div class="container">
		<div style="text-align:center; margin-top:100px">
			<h1>Welcome to the Profile App</h1>
		</div>
	</div>
@endsection

@section('js-css')
	<!-- Background image -->
	<style type="text/css">
		body
		{
			background-image: url("images/home_background.jpg");
		}
	</style>
@endsection