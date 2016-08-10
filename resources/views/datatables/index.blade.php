@extends('layouts.app')

@section('title', 'Home')

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

	<!-- Details Modal -->
	<div class="modal fade" id="myModal" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h3 class="modal-title">Personal Details :-</h3>
				</div>
				<div class="modal-body">
				<div id="profile_pic"></div>
				<strong style="color:blue">Name : </strong><br>
				<div id="name"></div><br>
				<strong style="color:blue">Employment : </strong><br>
				<div id="employment"></div><br>
				<strong style="color:blue">Employer : </strong><br>
				<div id="employer"></div><br>
				<strong style="color:blue">Residence Address : </strong><br>
				<div id="res_add"></div><br>
				<strong style="color:blue">Office Address : </strong><br>
				<div id="off_add"></div><br>
				<strong style="color:blue">Medium of Communication : </strong><br>
				<div id="comm_medium"></div><br>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Twitter Modal -->
	<div class="modal fade" id="twitter_modal" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title"></h4>
				</div>
				<div id="tweet_selector">
					<select id="select_tweet_num">
						<option value="1" selected>1</option>
						<option value="2">2</option>
						<option value="4">4</option>
						<option value="6">6</option>
						<option value="8">8</option>
					</select>
				</div>
				<div class="modal-body">
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('js-css')
	<!-- jQuery -->
	<script src="//code.jquery.com/jquery.js"></script>
	<!-- DataTables -->
	<script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
	<!-- Bootstrap JavaScript -->
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
	<!-- Custom JavaScript to display details -->
	<script src="{{ url('js/details.js') }}"></script>
@endsection