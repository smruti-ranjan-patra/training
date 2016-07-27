@extends('layouts.app')

@section('title', 'Dashboard')

@section('paging')
<li>{!! Html::link('/logout', 'Log out') !!}</li>
@endsection

@section('content')
	<div class="container">
		<h2><strong>Welcome {{ $name }}</strong></h2>
	</div>
@endsection
