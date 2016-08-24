@extends('layouts.app')

@section('title', 'Registration')

<?php

	$id = 0;
	$edit = 0;
	$first_name = '';
	$middle_name = '';
	$last_name = '';
	$email = '';
	$twitter_name = '';
	$prefix_1 = true;
	$prefix_2 = '';
	$prefix_3 = '';
	$gender_1 = true;
	$gender_2 = '';
	$gender_3 = '';
	$dob = '';
	$marital_status_1 = true;
	$marital_status_2 = '';
	$employment_1 = true;
	$employment_2 = '';
	$employer = '';
	$r_street = '';
	$r_city = '';
	$r_state = '';
	$r_zip = '';
	$r_phone = '';
	$r_fax = '';
	$o_street = '';
	$o_city = '';
	$o_state = '';
	$o_zip = '';
	$o_phone = '';
	$o_fax = '';
	$photo = '';
	$notes = '';

	$emp_comm_medium = [];

	if (isset($emp_data) && !empty($emp_data))
	{
		$id = $emp_data[0]->id;
		$edit = 1;
		$first_name = $emp_data[0]->first_name;
		$middle_name = $emp_data[0]->middle_name;
		$last_name = $emp_data[0]->last_name;
		$email = $emp_data[0]->email;
		$twitter_name = $emp_data[0]->twitter_name;
		$email = $emp_data[0]->email;
		$prefix_2 = ($emp_data[0]->prefix == 'ms');
		$prefix_3 = ($emp_data[0]->prefix == 'mrs');
		$gender_2 = ($emp_data[0]->gender == 'female');
		$gender_3 = ($emp_data[0]->gender == 'others');
		$dob = $emp_data[0]->dob;
		$marital_status_2 = ($emp_data[0]->marital_status == 'married');
		$employment_2 = ($emp_data[0]->employment == 'unemployed');
		$employer = $emp_data[0]->employer;
		$r_street = $emp_data[0]->address[0]->street;
		$r_city = $emp_data[0]->address[0]->city;
		$r_state = $emp_data[0]->address[0]->state;
		$r_zip = ($emp_data[0]->address[0]->zip == 0) ? '' : $emp_data[0]->address[0]->zip;
		$r_phone = ($emp_data[0]->address[0]->phone == 0) ? '' : $emp_data[0]->address[0]->phone;
		$r_fax = ($emp_data[0]->address[0]->fax == 0) ? '' : $emp_data[0]->address[0]->fax;
		$o_street = $emp_data[0]->address[1]->street;
		$o_city = $emp_data[0]->address[1]->city;
		$o_state = $emp_data[0]->address[1]->state;
		$o_zip = ($emp_data[0]->address[1]->zip == 0) ? '' : $emp_data[0]->address[1]->zip ;
		$o_phone = ($emp_data[0]->address[1]->phone == 0) ? '' : $emp_data[0]->address[1]->phone;
		$o_fax = ($emp_data[0]->address[1]->fax == 0) ? '' : $emp_data[0]->address[1]->fax;
		$notes = $emp_data[0]->extra_note;
		$photo = $emp_data[0]->photo;
		$emp_comm_medium = explode(" ", $emp_data[0]->comm_id);
	}

?>

@section('content')
	<div class="container">
		<div class="col-sm-offset-2 col-sm-8">
			<div class="panel panel-default">
				<div class="panel-heading">
					Registration
				</div>

				<div class="panel-body">
					<!-- Display Validation Errors -->
					@include('common.errors')

					<!-- New Task Form -->
					{!! Form::open(array('url' => route('do-register'), 'method' => 'POST', 'class' => 'form-horizontal', 'id' => 'registration_form', 'files' => 'true')) !!}

						<!-- ID (hidden field) -->
						{!! Form::hidden('id', $id) !!}

						<!-- Names -->
						<div class="row form-group">
							{!! Form::label('first_name', 'First name :', array('class' => 'col-xs-12 col-sm-4 col-md-4 col-lg-3 control-label')) !!}

							<div class="col-xs-12 col-sm-8 col-md-8 col-lg-9">
								{!! Form::text('first_name', $first_name, array('id' => 'first_name', 'value' => old('first_name'), 'class' => 'form-control' )) !!}
							</div>
						</div>

						<div class="row form-group">
							{!! Form::label('middle_name', 'Middle name :', array('class' => 'col-xs-12 col-sm-4 col-md-4 col-lg-3 control-label')) !!}

							<div class="col-xs-12 col-sm-8 col-md-8 col-lg-9">
								{!! Form::text('middle_name', $middle_name, array('id' => 'middle_name', 'value' => old('middle_name'), 'class' => 'form-control' )) !!}
							</div>
						</div>

						<div class="row form-group">
							{!! Form::label('last_name', 'Last name :', array('class' => 'col-xs-12 col-sm-4 col-md-4 col-lg-3 control-label')) !!}

							<div class="col-xs-12 col-sm-8 col-md-8 col-lg-9">
								{!! Form::text('last_name', $last_name, array('id' => 'last_name', 'value' => old('last_name'), 'class' => 'form-control' )) !!}
							</div>
						</div>

						<!-- Email -->
						<div class="row form-group">
							{!! Form::label('email', 'Email ID :', array('class' => 'col-xs-12 col-sm-4 col-md-4 col-lg-3 control-label')) !!}

							<div class="col-xs-12 col-sm-8 col-md-8 col-lg-9">
								{!! Form::email('email', $email, array('id' => 'email', 'value' => old('email'), 'placeholder' => 'example@abc.com', 'class' => 'form-control' )) !!}
							</div>
						</div>

						<!-- Password -->
						<div class="row form-group">
							{!! Form::label('password', 'Password :', array('class' => 'col-xs-12 col-sm-4 col-md-4 col-lg-3 control-label')) !!}

							<div class="col-xs-12 col-sm-8 col-md-8 col-lg-9">
								{!! Form::password('password', array('id' => 'password', 'value' => old('password'), 'placeholder' => '*********', 'class' => 'form-control' )) !!}
							</div>
						</div>

						@if(! (Auth::check() && Auth::user()->role_id == 1))
							<!-- Twitter Account -->
							<div class="row form-group">
								{!! Form::label('twitter', 'Twitter name :', array('class' => 'col-xs-12 col-sm-4 col-md-4 col-lg-3 control-label')) !!}

								<div class="col-xs-12 col-sm-8 col-md-8 col-lg-9">
									{!! Form::text('twitter_name', $twitter_name, array('id' => 'twitter', 'value' => old('twitter'), 'placeholder' => 'iamfree', 'class' => 'form-control' )) !!}
								</div>
							</div>

							<!-- Prefix -->
							<div class="row form-group">
								{!! Form::label('prefix', 'Prefix :', array('class' => 'col-xs-12 col-sm-4 col-md-4 col-lg-3 control-label')) !!}

								<div class="col-xs-12 col-sm-8 col-md-8 col-lg-9">
									{!! Form::radio('prefix','mr', $prefix_1, array('id' => 'mr')) !!}
									{!! Form::label('mr','Mr')!!}&nbsp;

									{!! Form::radio('prefix','ms', $prefix_2, array('id' => 'ms')) !!}
									{!! Form::label('ms','Ms')!!}&nbsp;

									{!! Form::radio('prefix','mrs', $prefix_3, array('id' => 'mrs')) !!}
									{!! Form::label('mrs','Mrs')!!}
								</div>
							</div>

							<!-- Gender -->
							<div class="row form-group">
								{!! Form::label('gender', 'Gender :', array('class' => 'col-xs-12 col-sm-4 col-md-4 col-lg-3 control-label')) !!}

								<div class="col-xs-12 col-sm-8 col-md-8 col-lg-9">
									{!! Form::radio('gender','male', $gender_1, array('id' => 'male')) !!}
									{!! Form::label('male','Male') !!}&nbsp;

									{!! Form::radio('gender','female', $gender_2, array('id' => 'female')) !!}
									{!! Form::label('female','Female') !!}&nbsp;

									{!! Form::radio('gender','others', $gender_3, array('id' => 'others')) !!}
									{!! Form::label('others','Others') !!}
								</div>
							</div>

							<!-- DOB -->
							<div class="row form-group">
								{!! Form::label('dob', 'DOB :', array('class' => 'col-xs-12 col-sm-4 col-md-4 col-lg-3 control-label')) !!}

								<div class="col-xs-12 col-sm-8 col-md-8 col-lg-9">
									{{ Form::date('dob', $dob, ['class' => 'form-control'])}}
								</div>
							</div>

							<!-- Marital Status -->
							<div class="row form-group">
								{!! Form::label('marital_status', 'Marital Status :', array('class' => 'col-xs-12 col-sm-4 col-md-4 col-lg-3 control-label')) !!}

								<div class="col-xs-12 col-sm-8 col-md-8 col-lg-9">
									{!! Form::radio('marital_status','single', $marital_status_1, array('id' => 'single')) !!}
									{!! Form::label('single', 'Single') !!}&nbsp;

									{!! Form::radio('marital_status','married', $marital_status_2, array('id' => 'married')) !!}
									{!! Form::label('married', 'Married') !!}
								</div>
							</div>

							<!-- Employment -->
							<div class="row form-group">
								{!! Form::label('employment', 'Employment :', array('class' => 'col-xs-12 col-sm-4 col-md-4 col-lg-3 control-label')) !!}

								<div class="col-xs-12 col-sm-8 col-md-8 col-lg-9">
									{!! Form::radio('employment','employed', $employment_1, array('id' => 'employed')) !!}
									{!! Form::label('employed','Employed') !!}&nbsp;

									{!! Form::radio('employment','unemloyed', $employment_2, array('id' => 'unemployed')) !!}
									{!! Form::label('unemployed','Unemployed') !!}
								</div>
							</div>

							<!-- Employer -->
							<div class="row form-group">
								{!! Form::label('employer', 'Employer :', array('class' => 'col-xs-12 col-sm-4 col-md-4 col-lg-3 control-label')) !!}

								<div class="col-xs-12 col-sm-8 col-md-8 col-lg-9">
									{!! Form::text('employer', $employer, array('id' => 'employer', 'value' => old('employer'), 'placeholder' => 'Organization', 'class' => 'form-control' )) !!}
								</div>
							</div>

							<!-- Address -->
							<div class="row form-group">
								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
									<h4><u>Residence Address :-</u></h4>

										<div class="row form-group">
											{!! Form::label('r_street', 'Street :', array('class' => 'col-xs-12 col-sm-3 col-md-3 col-lg-3 control-label')) !!}

											<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
												{!! Form::text('r_street', $r_street, array('id' => 'r_street', 'value' => old('r_street'), 'class' => 'form-control' )) !!}
											</div>
										</div>

										<div class="row form-group">
											{!! Form::label('r_city', 'City :', array('class' => 'col-xs-12 col-sm-3 col-md-3 col-lg-3 control-label')) !!}

											<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
												{!! Form::text('r_city', $r_city, array('id' => 'r_city', 'value' => old('r_city'), 'class' => 'form-control' )) !!}
											</div>
										</div>

										<div class="row form-group">
											{!! Form::label('r_state', 'State :', array('class' => 'col-xs-12 col-sm-3 col-md-3 col-lg-3 control-label')) !!}

											<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
												{!! Form::select('r_state', $state_list, $r_state, ['class' => 'form-control']) !!}
											</div>
										</div>

										<div class="row form-group">
											{!! Form::label('r_zip', 'Zip :', array('class' => 'col-xs-12 col-sm-3 col-md-3 col-lg-3 control-label')) !!}

											<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
												{!! Form::text('r_zip', $r_zip, array('id' => 'r_zip', 'value' => old('r_zip'), 'class' => 'form-control' )) !!}
											</div>
										</div>

										<div class="row form-group">
											{!! Form::label('r_phone', 'Phone :', array('class' => 'col-xs-12 col-sm-3 col-md-3 col-lg-3 control-label')) !!}

											<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
												{!! Form::text('r_phone', $r_phone, array('id' => 'r_phone', 'value' => old('r_phone'), 'class' => 'form-control' )) !!}
											</div>
										</div>

										<div class="row form-group">
											{!! Form::label('r_fax', 'Fax :', array('class' => 'col-xs-12 col-sm-3 col-md-3 col-lg-3 control-label')) !!}

											<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
												{!! Form::text('r_fax', $r_fax, array('id' => 'r_fax', 'value' => old('r_fax'), 'class' => 'form-control' )) !!}
											</div>
										</div>
								</div>

								<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
									<h4><u>Office Address :-</u></h4>

										<div class="row form-group">
											{!! Form::label('o_street', 'Street :', array('class' => 'col-xs-12 col-sm-3 col-md-3 col-lg-3 control-label')) !!}

											<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
												{!! Form::text('o_street', $o_street, array('id' => 'o_street', 'value' => old('o_street'), 'class' => 'form-control' )) !!}
											</div>
										</div>

										<div class="row form-group">
											{!! Form::label('o_city', 'City :', array('class' => 'col-xs-12 col-sm-3 col-md-3 col-lg-3 control-label')) !!}

											<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
												{!! Form::text('o_city', $o_city, array('id' => 'o_city', 'value' => old('o_city'), 'class' => 'form-control' )) !!}
											</div>
										</div>

										<div class="row form-group">
											{!! Form::label('o_state', 'State :', array('class' => 'col-xs-12 col-sm-3 col-md-3 col-lg-3 control-label')) !!}

											<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
												{!! Form::select('o_state', $state_list, $o_state, ['class' => 'form-control']) !!}
											</div>
										</div>

										<div class="row form-group">
											{!! Form::label('o_zip', 'Zip :', array('class' => 'col-xs-12 col-sm-3 col-md-3 col-lg-3 control-label')) !!}

											<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
												{!! Form::text('o_zip', $o_zip, array('id' => 'o_zip', 'value' => old('o_zip'), 'class' => 'form-control' )) !!}
											</div>
										</div>

										<div class="row form-group">
											{!! Form::label('o_phone', 'Phone :', array('class' => 'col-xs-12 col-sm-3 col-md-3 col-lg-3 control-label')) !!}

											<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
												{!! Form::text('o_phone', $o_phone, array('id' => 'o_phone', 'value' => old('o_phone'), 'class' => 'form-control' )) !!}
											</div>
										</div>

										<div class="row form-group">
											{!! Form::label('o_fax', 'Fax :', array('class' => 'col-xs-12 col-sm-3 col-md-3 col-lg-3 control-label')) !!}

											<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
												{!! Form::text('o_fax', $o_fax, array('id' => 'o_fax', 'value' => old('o_fax'), 'class' => 'form-control' )) !!}
											</div>
										</div>
								</div>
							</div>

							<!-- Personal Info :- --> 
							<!-- Photo -->
							<h4><u>Personal Info :-</u></h4>
							<div class="row form-group">
								{!! Form::label('pic', 'Photo :', array('class' => 'col-xs-12 col-sm-4 col-md-4 col-lg-3 control-label')) !!}

								<div class="col-xs-12 col-sm-8 col-md-8 col-lg-9">
									{!! Form::file('pic', array('id' => 'pic', 'class' => 'form-control' )) !!}
								</div>
							</div>

							@if($photo != null)
								<div class="form-group">
									<div class="col-xs-12 col-sm-4 col-md-4 col-lg-3">
									</div>
									<div class="class' => 'col-xs-12 col-sm-8 col-md-8 col-lg-9">
										{!! Html::image(asset('images/profile_pic' . '/' . $photo) , 'No image found', array( 'width' => 300, 'height' => 300, 'class' => 'user_pic')) !!}
									</div>									
								</div>
							@endif
							
							<!-- Extra Notes -->
							<div class="row form-group">
								{!! Form::label('notes', 'Extra Notes :', array('class' => 'col-xs-12 col-sm-4 col-md-4 col-lg-3 control-label')) !!}

								<div class="col-xs-12 col-sm-8 col-md-8 col-lg-9">
								{!! Form::textarea('notes', $notes, array('id' => 'notes', 'class' => 'form-control', 'placeholder' => 'Something about you')) !!}
								</div>
							</div>

							<!-- Preferred Communication -->
							<div class="row form-group">
								{!! Form::label('comm', 'Preferred Communication Medium :', array('class' => 'col-xs-12 col-sm-4 col-md-4 col-lg-3 control-label')) !!}

								<div class="col-xs-12 col-sm-8 col-md-8 col-lg-9">

									@foreach($comm_medium as $medium)
										<?php

											$checked = in_array($medium['id'], $emp_comm_medium) ? true : null;

										?>

										{!! Form::checkbox('comm[]', $medium['id'], $checked, ['id' => 'comm_' . $medium['type'], 'value' => $medium['id']]) !!}
										{!! Form::label('comm_' . $medium['type'], $medium['type']) !!}&nbsp;
									@endforeach

								</div>
							</div>
						@endif

						<!-- Submit Button -->
						<div class="form-group text-center">

							@if($edit == 0)
								{!! Form::submit('Register', ['class' => 'btn btn-primary']) !!}
							@else
								{!! Form::submit('Update', ['class' => 'btn btn-primary']) !!}
							@endif

							{!! Form::reset('Reset', ['class' => 'btn btn-danger']) !!}

						</div>
						
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
@endsection

@section('js-css')

	<style type="text/css">
		.user_pic
		{
			border-radius:20%;
		}
	</style>

@endsection
