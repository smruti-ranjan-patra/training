@if (count($errors) > 0)
	<!-- Form Error List -->
	<div class="alert alert-danger">
		<strong>Whoops! Something went wrong!</strong>

		<br><br>

		<ul>
			@foreach ($errors->all() as $error)
				<li>{{ $error }}</li>
			@endforeach
		</ul>
	</div>
@endif

@if ( Session::has('redirect_error'))
	<div class="alert alert-danger">
		<p>{{ Session::get('redirect_error') }}</p>
	</div>
@endif

@if ( Session::has('db_insert_error'))
	<div class="alert alert-danger">
		<p>{{ Session::get('db_insert_error') }}</p>
	</div>
@endif

