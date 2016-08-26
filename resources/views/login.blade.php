@extends('layouts.app')

@section('title', 'Login')

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
							
							{!! Html::link('/reset-password', 'Reset Password', array('id' => 'reset_password', 'class' => 'col-sm-6')) !!}
							
						</div>

						<!-- Login Button -->
						<div class="form-group text-center">
								{!! Form::submit('Login', ['class' => 'btn btn-primary']) !!}
								{!! Form::reset('Reset', ['class' => 'btn btn-danger']) !!}
						</div>

					{!! Form::close() !!}
				</div>

				<div class="row">
					<div>
						<div class="col-xs-5"><hr></div>
						<div class="col-xs-2 form-group text-center" style="margin-top: 10px;">OR</div>
						<div class="col-xs-5"><hr></div>
					</div>
				</div>

				<!-- Login from LinkedIn -->
				<div class=" form-group text-center">
					<a class='btn btn-primary' href="{{ route('linkedin-login') }}"><i class="fa fa-linkedin" style="width:16px; height:20px"></i></a>
					<a class='btn btn-primary' href="{{ route('linkedin-login') }}" style="width:12em; height:37px;"> Sign in with LinkedIn</a>
				</div>

				<!-- Login from Twitter -->
				<div class=" form-group text-center">
					<a class='btn btn-info' href="{{ route('twitter-login') }}"><i class="fa fa-twitter" style="width:16px; height:20px"></i></a>
					<a class='btn btn-info' href="{{ route('twitter-login') }}" style="width:12em; height:37px;"> Sign in with Twitter</a>
				</div>

			</div>
		</div>
	</div>

@endsection

@section('js-css')
	<!-- Social media button -->
	<script src="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css"></script>
@endsection
