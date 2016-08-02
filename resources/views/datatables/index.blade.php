@extends('layouts.app')

@section('title', 'Home')

@section('paging')
	<li>{!! Html::link('/dashboard', 'Dashboard') !!}</li>
	<li>{!! Html::link('/edit', 'Edit') !!}</li>
	<li>{!! Html::link('/logout', 'Log out') !!}</li>
@endsection

@section('content')
	<table class="table table-bordered" id="users-table">
			<thead>
					<tr>
							<th>Serial No.</th>
							<th>Prefix</th>
							<th>Name</th>
							<th>Email</th>
							<th>Gender</th>
							<th>DOB</th>
							<th>Action</th>
					</tr>
			</thead>
	</table>

	<!-- Modal -->
	<div class="modal fade" id="myModal" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"></h4>
				</div>
				<div class="modal-body">
				<div id="profile_pic"></div>
				<strong>Name : </strong><br>
				<div id="name"></div><br>
				<strong>Employment : </strong><br>
				<div id="employment"></div><br>
				<strong>Employer : </strong><br>
				<div id="employer"></div><br>
				<strong>Residence Address : </strong><br>
				<div id="res_add"></div><br>
				<strong>Office Address : </strong><br>
				<div id="off_add"></div><br>
				<strong>Medium of Communication : </strong><br>
				<div id="comm_medium"></div><br>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
@endsection

@push('scripts')
@endpush


@section('js-css')
	<!-- jQuery -->
	<script src="//code.jquery.com/jquery.js"></script>
	<!-- DataTables -->
	<script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
	<!-- Bootstrap JavaScript -->
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

	<script>
		$(function()
		{
			var t = $('#users-table').DataTable(
			{
				processing: true,
				serverSide: true,
				ajax: '{!! url('details') !!}',
				lengthMenu: [ 2, 5, 10, 25, 50, 75, 100 ],
				columns: [
						{ data: 'id', name: 'id' },
						{ data: 'prefix', name: 'prefix' },
						{ data: 'first_name', name: 'first_name' },					
						{ data: 'email', name: 'email' },
						{ data: 'gender', name: 'gender' },
						{ data: 'dob', name: 'dob' },
						{ data: 'action', name: 'first_name' }

				],
				columnDefs: [ { orderable: false, targets: [0,6] }],
				order: [],
			});

			$(document).on('click', '.view_details', function()
			{
				var id = $(this).attr('user_id');
				$.ajax(
				{
					url: '{!! url('view') !!}' + '?id=' + id,
					type: 'GET',
					dataType: 'json',

					success:function(response)
					{
						//$(".git_name").html('Github Profile of <strong>' + response.name + '</strong>');
						// $("#profile_pic").html('<img src="././images/profile_pic/' + response.photo + '" width="150px" height="150px">');

						$("#profile_pic").html('<div style="text-align: center"><img src="././images/profile_pic/' + response.photo + '" alt="No image found" style="border-radius:20%;width:120px;height:120px;"></div>');

						$("#name").html(response.full_name);
						$("#employment").html(response.employment);
						$("#employer").html(response.employer);
						$("#res_add").html(response.res_add);
						$("#off_add").html(response.off_add);
						$("#comm_medium").html(response.comm_medium);
						$("#myModal").modal({backdrop: 'static', keyboard: false, show: true});						
					}	
				});
			});

		});
	</script>
@endsection