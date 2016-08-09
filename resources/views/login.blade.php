@extends('layouts.app')

@section('title', 'Login')

@section('paging')
	<li>{!! Html::link(route('home'), 'Home') !!}</li>
	<li>{!! Html::link('/register', 'Register') !!}</li>
@endsection

@section('content')
	<div class="container">
		<div class="col-sm-offset-2 col-sm-8">
			<div class="panel panel-default">
				<div class="panel-heading">
					Login
				</div>

				<div class="panel-body">
					<!-- Display Validation Errors -->
					@include('common.errors')

					<!-- Normal Login Form -->
					{!! Form::open(array('url' => route('do-login'), 'method' => 'POST', 'class' => 'form-horizontal','id'=>'login')) !!}

						<!-- Email -->
						<div class="form-group">
							{!! Form::label('email', 'Email :', array('class' => 'col-sm-3 control-label')) !!}
							
							<div class="col-sm-6">
								{!! Form::email('email', null, array('id' => 'email', 'value' => old('email'), 'placeholder' => 'example@abc.com', 'class' => 'form-control' )) !!}
							</div>
						</div>

						<!-- Password -->
						<div class="form-group">
							{!! Form::label('passwrd', 'Password :', array('class' => 'col-sm-3 control-label')) !!}
							
							<div class="col-sm-6">
								{!! Form::password('password', array('id' => 'password', 'value' => old('password'), 'placeholder' => '*********', 'class' => 'form-control' )) !!}
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-3">
							</div>
							
							{!! HTML::link('/reset-password', 'Reset Password', array('id' => 'reset_password', 'class' => 'col-sm-6')) !!}
							
						</div>

						<!-- Login Button -->
						<div class="form-group text-center">
								{!! Form::submit('Login', ['class' => 'btn btn-primary']) !!}
						</div>

					{!! Form::close() !!}
				</div>

				<hr>

				<div class="panel-body">

					<!-- Login from LinkedIn -->
					{!! Form::open(array('url' => route('home'), 'method' => 'GET', 'class' => 'form-horizontal','id'=>'linkedin_login')) !!}

						<!-- Login Button -->
						<div class="form-group text-center">
								{!! Form::submit('Login through LinkedIn', ['class' => 'btn btn-primary']) !!}
						</div>

					{!! Form::close() !!}

				</div>
			</div>
		</div>
	</div>
@endsection
