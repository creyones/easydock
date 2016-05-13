@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-3 col-md-2">
			@include('partials.sidebar', ['active' => 'users'])
		</div>
		<div class="col-sm-9 col-md-10">
			<!-- Main Content -->
			<div class="row">
				@include('errors.list')
				@if (Auth::user()->hasRole('owner') || Auth::user()->hasRole('admin'))
				<div class="col-sm-12">
					<p class="lead"><i class="fa fa-plus-square fa-lg"></i> {{trans('views.create_user')}}</p></li>
					{!! Form::open(['action' => 'UsersController@store', 'class' => 'form-horizontal','role'=>'form']) !!}
					<div class="form-group">
						{!!Form::Label('username', trans('models.fields.username'), ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-8">
							{!! Form::text('username','', ['class'=>'form-control']) !!}
						</div>
					</div>
					<div class="form-group">
						{!!Form::Label('email', trans('models.fields.email'), ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-8">
							{!! Form::email('email', '', ['class'=>'form-control']) !!}
						</div>
					</div>
					<div class="form-group">
						{!!Form::Label('password', trans('models.fields.password'), ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-8">
							{!! Form::password('password', ['class'=>'form-control']) !!}
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-8 col-sm-offset-2">
							{!!Form::submit(trans('actions.save'),['class' => 'btn btn-success']) !!}
							<a href={{route('users.index')}} class="btn btn-default">{{trans('actions.cancel')}}</a>
						</div>
					</div>
					{!! Form::close() !!}
				</div>

				@else
				<div class="col-sm-8 col-sm-offset-2">
					<p class="lead">{{trans('messages.access-forbidden')}}</p>
				</div>
				@endif
				<!-- End Main Content -->
			</div>
		</div>
	</div>
</div>
@endsection
