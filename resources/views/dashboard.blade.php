@extends('layouts.app')

@section('title', 'Dashboard')

@section('paging')
	<li>{!! Html::link('/details', 'Details') !!}</li>
	<li>{!! Html::link('/add_user', 'Add User') !!}</li>
	<li>{!! Html::link('/logout', 'Log out') !!}</li>
@endsection

@section('content')
	<div class="container">
		<div style="text-align:center; margin-top:100px">
			<h2><strong>Welcome {{ $name }}</strong></h2>
		</div>
	</div>
@endsection
