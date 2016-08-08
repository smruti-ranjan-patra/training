@extends('layouts.app')

@section('title', 'Dashboard')

@section('paging')
	<li>{!! Html::link('/details', 'Details') !!}</li>	

	@if( Auth::user()->role_id == 1 )
		<li>{!! Html::link('/add_user', 'Add User') !!}</li>
		<li>{!! Html::link('/permission', 'Permission Manager') !!}</li>
	@endif

	<li>{!! Html::link('/logout', 'Log out') !!}</li>
@endsection

@section('content')
	<div class="container">

		@include('common.errors')

		<div style="text-align:center; margin-top:100px">
			<h2><strong>Welcome {{ $name }}</strong></h2>
		</div>
	</div>
@endsection
