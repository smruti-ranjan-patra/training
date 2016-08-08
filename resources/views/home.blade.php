@extends('layouts.app')

@section('title', 'Home')

@section('paging')

	@if(!(Auth::check()))
		<li>{!! Html::link('/login', 'Login') !!}</li>
		<li>{!! Html::link('/register', 'Register') !!}</li>
	@endif

	@if(Auth::check())
		<li>{!! Html::link('/dashboard', 'Dashboard') !!}</li>
		<li>{!! Html::link('/logout', 'Log out') !!}</li>
	@endif

@endsection

@section('content')
	<style type="text/css">
		body
		{
			background-image: url("images/home_background.jpg");
		}
	</style>
	<div class="container">
			<div style="text-align:center; margin-top:100px">
				<h1>Welcome to the Profile App</h1>
			</div>
	</div>
@endsection