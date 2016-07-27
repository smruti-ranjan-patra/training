@extends('layouts.app')

@section('title', 'Registration')

@section('paging')
<li>{!! Html::link('/login', 'Login') !!}</li>
@endsection

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

						<!-- Names -->
						<div class="row form-group">
							{!! Form::label('first_name', 'First name :', array('class' => 'col-xs-12 col-sm-4 col-md-4 col-lg-3 control-label')) !!}

							<div class="col-xs-12 col-sm-8 col-md-8 col-lg-9">
								{!! Form::text('first_name', null, array('id' => 'first_name', 'value' => old('first_name'), 'class' => 'form-control' )) !!}
							</div>
						</div>

						<div class="row form-group">
							{!! Form::label('middle_name', 'Middle name :', array('class' => 'col-xs-12 col-sm-4 col-md-4 col-lg-3 control-label')) !!}

							<div class="col-xs-12 col-sm-8 col-md-8 col-lg-9">
								{!! Form::text('middle_name', null, array('id' => 'middle_name', 'value' => old('middle_name'), 'class' => 'form-control' )) !!}
							</div>
						</div>

						<div class="row form-group">
							{!! Form::label('last_name', 'Last name :', array('class' => 'col-xs-12 col-sm-4 col-md-4 col-lg-3 control-label')) !!}

							<div class="col-xs-12 col-sm-8 col-md-8 col-lg-9">
								{!! Form::text('last_name', null, array('id' => 'last_name', 'value' => old('last_name'), 'class' => 'form-control' )) !!}
							</div>
						</div>

						<!-- Email -->
						<div class="row form-group">
							{!! Form::label('email', 'Email ID :', array('class' => 'col-xs-12 col-sm-4 col-md-4 col-lg-3 control-label')) !!}

							<div class="col-xs-12 col-sm-8 col-md-8 col-lg-9">
								{!! Form::email('email', null, array('id' => 'email', 'value' => old('email'), 'placeholder' => 'example@abc.com', 'class' => 'form-control' )) !!}
							</div>
						</div>

						<!-- Password -->
						<div class="row form-group">
							{!! Form::label('password', 'Password :', array('class' => 'col-xs-12 col-sm-4 col-md-4 col-lg-3 control-label')) !!}

							<div class="col-xs-12 col-sm-8 col-md-8 col-lg-9">
								{!! Form::password('password', array('id' => 'password', 'value' => old('password'), 'placeholder' => '*********', 'class' => 'form-control' )) !!}
							</div>
						</div>

						<!-- Twitter Account -->
						<div class="row form-group">
							{!! Form::label('twitter', 'Twitter name :', array('class' => 'col-xs-12 col-sm-4 col-md-4 col-lg-3 control-label')) !!}

							<div class="col-xs-12 col-sm-8 col-md-8 col-lg-9">
								{!! Form::text('twitter_name', null, array('id' => 'twitter', 'value' => old('twitter'), 'placeholder' => 'iamfree', 'class' => 'form-control' )) !!}
							</div>
						</div>

						<!-- Prefix -->
						<div class="row form-group">
							{!! Form::label('prefix', 'Prefix :', array('class' => 'col-xs-12 col-sm-4 col-md-4 col-lg-3 control-label')) !!}

							<div class="col-xs-12 col-sm-8 col-md-8 col-lg-9">
								{!! Form::radio('prefix','mr', true, array('id' => 'mr')) !!}
								{!! Form::label('mr','Mr')!!}&nbsp;

								{!! Form::radio('prefix','ms', null, array('id' => 'ms')) !!}
								{!! Form::label('ms','Ms')!!}&nbsp;

								{!! Form::radio('prefix','mrs', null, array('id' => 'mrs')) !!}
								{!! Form::label('mrs','Mrs')!!}
							</div>
						</div>

						<!-- Gender -->
						<div class="row form-group">
							{!! Form::label('gender', 'Gender :', array('class' => 'col-xs-12 col-sm-4 col-md-4 col-lg-3 control-label')) !!}

							<div class="col-xs-12 col-sm-8 col-md-8 col-lg-9">
								{!! Form::radio('gender','male', true, array('id' => 'male')) !!}
								{!! Form::label('male','Male') !!}&nbsp;

								{!! Form::radio('gender','female', null, array('id' => 'female')) !!}
								{!! Form::label('female','Female') !!}&nbsp;

								{!! Form::radio('gender','others', null, array('id' => 'others')) !!}
								{!! Form::label('others','Others') !!}
							</div>
						</div>

						<!-- DOB -->
						<div class="row form-group">
							{!! Form::label('dob', 'DOB :', array('class' => 'col-xs-12 col-sm-4 col-md-4 col-lg-3 control-label')) !!}

							<div class="col-xs-12 col-sm-8 col-md-8 col-lg-9">
								{{ Form::date('dob', null, ['class' => 'form-control'])}}
							</div>
						</div>

						<!-- Marital Status -->
						<div class="row form-group">
							{!! Form::label('marital_status', 'Marital Status :', array('class' => 'col-xs-12 col-sm-4 col-md-4 col-lg-3 control-label')) !!}

							<div class="col-xs-12 col-sm-8 col-md-8 col-lg-9">
								{!! Form::radio('marital_status','single', true, array('id' => 'single')) !!}
								{!! Form::label('single', 'Single') !!}

								{!! Form::radio('marital_status','married', null, array('id' => 'married')) !!}
								{!! Form::label('married', 'Married') !!}
							</div>
						</div>

						<!-- Employment -->
						<div class="row form-group">
							{!! Form::label('employment', 'Employment :', array('class' => 'col-xs-12 col-sm-4 col-md-4 col-lg-3 control-label')) !!}

							<div class="col-xs-12 col-sm-8 col-md-8 col-lg-9">
								{!! Form::radio('employment','employed', true, array('id' => 'employed')) !!}
								{!! Form::label('employment','Employed') !!}

								{!! Form::radio('employment','unemloyed', null, array('id' => 'unemployed')) !!}
								{!! Form::label('employment','Unemployed') !!}
							</div>
						</div>

						<!-- Employer -->
						<div class="row form-group">
							{!! Form::label('employer', 'Employer :', array('class' => 'col-xs-12 col-sm-4 col-md-4 col-lg-3 control-label')) !!}

							<div class="col-xs-12 col-sm-8 col-md-8 col-lg-9">
								{!! Form::text('employer','', array('id' => 'employer', 'value' => old('employer'), 'placeholder' => 'Organization', 'class' => 'form-control' )) !!}
							</div>
						</div>

						<!-- Residence Address -->
						<div class="row form-group">
							<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
								<h4><u>Residence Address :-</u></h4>

									<div class="row form-group">
										{!! Form::label('r_street', 'Street :', array('class' => 'col-xs-12 col-sm-3 col-md-3 col-lg-3 control-label')) !!}

										<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
											{!! Form::text('r_street','', array('id' => 'r_street', 'value' => old('r_street'), 'class' => 'form-control' )) !!}
										</div>
									</div>

									<div class="row form-group">
										{!! Form::label('r_city', 'City :', array('class' => 'col-xs-12 col-sm-3 col-md-3 col-lg-3 control-label')) !!}

										<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
											{!! Form::text('r_city','', array('id' => 'r_city', 'value' => old('r_city'), 'class' => 'form-control' )) !!}
										</div>
									</div>

									<div class="row form-group">
										{!! Form::label('r_state', 'State :', array('class' => 'col-xs-12 col-sm-3 col-md-3 col-lg-3 control-label')) !!}

										<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
											{!! Form::select('r_state', $state_list, null, ['class' => 'form-control']) !!}
										</div>
									</div>

									<div class="row form-group">
										{!! Form::label('r_zip', 'Zip :', array('class' => 'col-xs-12 col-sm-3 col-md-3 col-lg-3 control-label')) !!}

										<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
											{!! Form::text('r_zip','', array('id' => 'r_zip', 'value' => old('r_zip'), 'class' => 'form-control' )) !!}
										</div>
									</div>

									<div class="row form-group">
										{!! Form::label('r_phone', 'Phone :', array('class' => 'col-xs-12 col-sm-3 col-md-3 col-lg-3 control-label')) !!}

										<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
											{!! Form::text('r_phone','', array('id' => 'r_phone', 'value' => old('r_phone'), 'class' => 'form-control' )) !!}
										</div>
									</div>

									<div class="row form-group">
										{!! Form::label('r_fax', 'Fax :', array('class' => 'col-xs-12 col-sm-3 col-md-3 col-lg-3 control-label')) !!}

										<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
											{!! Form::text('r_fax','', array('id' => 'r_fax', 'value' => old('r_fax'), 'class' => 'form-control' )) !!}
										</div>
									</div>
							</div>

							<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
								<h4><u>Office Address :-</u></h4>

									<div class="row form-group">
										{!! Form::label('o_street', 'Street :', array('class' => 'col-xs-12 col-sm-3 col-md-3 col-lg-3 control-label')) !!}

										<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
											{!! Form::text('o_street','', array('id' => 'o_street', 'value' => old('o_street'), 'class' => 'form-control' )) !!}
										</div>
									</div>

									<div class="row form-group">
										{!! Form::label('o_city', 'City :', array('class' => 'col-xs-12 col-sm-3 col-md-3 col-lg-3 control-label')) !!}

										<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
											{!! Form::text('o_city','', array('id' => 'o_city', 'value' => old('o_city'), 'class' => 'form-control' )) !!}
										</div>
									</div>

									<div class="row form-group">
										{!! Form::label('o_state', 'State :', array('class' => 'col-xs-12 col-sm-3 col-md-3 col-lg-3 control-label')) !!}

										<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
											{!! Form::select('o_state', $state_list, null, ['class' => 'form-control']) !!}
										</div>
									</div>

									<div class="row form-group">
										{!! Form::label('o_zip', 'Zip :', array('class' => 'col-xs-12 col-sm-3 col-md-3 col-lg-3 control-label')) !!}

										<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
											{!! Form::text('o_zip','', array('id' => 'o_zip', 'value' => old('o_zip'), 'class' => 'form-control' )) !!}
										</div>
									</div>

									<div class="row form-group">
										{!! Form::label('o_phone', 'Phone :', array('class' => 'col-xs-12 col-sm-3 col-md-3 col-lg-3 control-label')) !!}

										<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
											{!! Form::text('o_phone','', array('id' => 'o_phone', 'value' => old('o_phone'), 'class' => 'form-control' )) !!}
										</div>
									</div>

									<div class="row form-group">
										{!! Form::label('o_fax', 'Fax :', array('class' => 'col-xs-12 col-sm-3 col-md-3 col-lg-3 control-label')) !!}

										<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
											{!! Form::text('o_fax','', array('id' => 'o_fax', 'value' => old('o_fax'), 'class' => 'form-control' )) !!}
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
						
						<!-- Extra Notes -->
						<div class="row form-group">
							{!! Form::label('notes', 'Extra Notes :', array('class' => 'col-xs-12 col-sm-4 col-md-4 col-lg-3 control-label')) !!}

							<div class="col-xs-12 col-sm-8 col-md-8 col-lg-9">
							{!! Form::textarea('notes', null, array('id' => 'notes', 'class' => 'form-control')) !!}
							</div>
						</div>

						<!-- Preferred Communicatio -->
						<div class="row form-group">
							{!! Form::label('comm', 'Preferred Communication Medium :', array('class' => 'col-xs-12 col-sm-4 col-md-4 col-lg-3 control-label')) !!}

							<div class="col-xs-12 col-sm-8 col-md-8 col-lg-9">

							{!! Form::checkbox('comm[]','1', null, ['id' => 'comm_mail', 'value' => '1']) !!}
							{!! Form::label('comm_mail','Mail') !!}&nbsp;

							{!! Form::checkbox('comm[]','2', null, ['id' => 'comm_message', 'value' => '2']) !!}
							{!! Form::label('comm_message','Message') !!}&nbsp;

							{!! Form::checkbox('comm[]','3', null, ['id' => 'comm_phone', 'value' => '3']) !!}
							{!! Form::label('comm_phone','Phone') !!}&nbsp;

							{!! Form::checkbox('comm[]','4', null, ['id' => 'comm_any', 'value' => '4']) !!}
							{!! Form::label('comm_any','Any') !!}&nbsp;

							</div>
						</div>						

						<!-- Submit Button -->
						<div class="form-group text-center">
								{!! Form::submit('Register', ['class' => 'btn btn-primary']) !!}
						</div>
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
@endsection
