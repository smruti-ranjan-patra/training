@extends('layouts.app')

@section('title', 'Reset')

@section('content')
	<div class="container">
		<div class="col-sm-offset-2 col-sm-8">
			<div class="panel panel-default">
				<div class="panel-heading">
					Reset Password
				</div>

				<div class="panel-body">
					<!-- Display Validation Errors -->
					@include('common.errors')

					<!-- Reset Password Form -->
					 {!! Form::open(array('url' => 'do-reset-password', 'method' => 'POST', 'class' => 'form-horizontal','id'=>'reset')) !!}

						<!-- Email -->
						<div class="form-group">
							{!! Form::label('email', 'Email :', array('class' => 'col-sm-3 control-label')) !!}
							
							<div class="col-sm-6">
								{!! Form::email('email', null, array('id' => 'email', 'value' => old('email'), 'placeholder' => 'example@abc.com', 'class' => 'form-control' )) !!}
							</div>
						</div>

						<!-- Reset Button -->
						<div class="form-group text-center">
								{!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
						</div>

						{!! Form::close() !!}
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection
