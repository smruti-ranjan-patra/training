@extends('layouts.app')

@section('title', 'Login')

@section('content')

	<div class="table-responsive">
		<table class="table table-bordered table-hover">
			<thead>
				<tr>
					<th>Role</th>
					<th>Resource</th>

					@foreach($permissions as $permission)
						<th>
						{{ ucfirst($permission->permission_name) }}
						</th>
					@endforeach

				</tr>
			</thead>
			<tbody>					

				@foreach($roles as $role)

					@foreach($resources as $resource)
						<tr>
						<td> {{ $role->role_name }} </td>
						<td> {{ $resource->resource_name }} </td>

						@foreach ($permissions as $permission)
							
							<?php

								$checked = '';

							?>

							@if (isset($selected_permission[$role['id'] . '-' . $resource['id'] . '-' . $permission['id']]))
								
								<?php
									
									$checked = ' checked="checked"';

								?>

							@endif

							<td>
							<input type="checkbox" class="permission-check" id="{{ $role->id . '-' . $resource->id . '-' . $permission->id }}" {{ $checked }} >
							</td>
						@endforeach

						</tr>
					@endforeach

				@endforeach
				
			</tbody>
		</table>
	</div>

@endsection

@section('js-css')
	<!-- jQuery -->
	<script src="//code.jquery.com/jquery.js"></script>
	<!-- Bootstrap JavaScript -->
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
	<!-- Custom JavaScript to change permission details -->
	<script src="{{ url('js/change_permission.js') }}"></script>
@endsection