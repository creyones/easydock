@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-3 col-md-2">
			@include('partials.sidebar', array('active' => 'providers'))
		</div>
		<div class="col-sm-9 col-md-10">
			<!-- Main Content -->
			<div class="row">
				@include('errors.list')
				@if (Auth::user()->hasRole('owner') || Auth::user()->hasRole('admin'))
				<div class="col-sm-12">
					<p class="lead"><i class="fa fa-plus-square fa-lg"></i> {{trans('views.create_provider')}}</p></li>
					{!! Form::open(['action' => 'ProvidersController@store', 'class' => 'form-horizontal','role'=>'form']) !!}
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
					<hr/>
					<div class="form-group">
						{!!Form::Label('firstname', trans('models.fields.firstname'), ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-8">
							{!! Form::text('firstname', '', ['class'=>'form-control']) !!}
						</div>
					</div>
					<div class="form-group">
						{!!Form::Label('lastname', trans('models.fields.lastname'), ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-8">
							{!! Form::text('lastname', '', ['class'=>'form-control']) !!}
						</div>
					</div>
					<div class="form-group">
						{!!Form::Label('phone', trans('models.fields.phone'), ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-8">
							{!! Form::text('phone', '', ['class'=>'form-control']) !!}
						</div>
					</div>
					<div class="form-group">
						{!!Form::Label('mobile', trans('models.fields.mobile'), ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-8">
							{!! Form::text('mobile', '', ['class'=>'form-control']) !!}
						</div>
					</div>
					<div class="form-group">
						{!!Form::Label('address', trans('models.fields.address'), ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-8">
							{!! Form::textarea('address', '', ['class'=>'form-control']) !!}
						</div>
					</div>
					<div class="form-group">
						{!!Form::Label('city', trans('models.fields.city'), ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-8">
							{!! Form::text('city', '', ['class'=>'form-control']) !!}
						</div>
					</div>
					<div class="form-group">
						{!!Form::Label('postalcode', trans('models.fields.postalcode'), ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-8">
							{!! Form::text('postalcode', '', ['class'=>'form-control']) !!}
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-8 col-sm-offset-2">
							{!!Form::submit(trans('actions.save'),['class' => 'btn btn-success']) !!}
							<a href={{route('providers.index')}} class="btn btn-default">{{trans('actions.cancel')}}</a>
						</div>
					</div>
					{!! Form::close() !!}
				</div>

				@else
				<div class="col-sm-8 col-sm-offset-2">
					<p class="lead">{{trans('messages.accessforbidden')}}</p>
				</div>
				@endif
				<!-- End Main Content -->
			</div>
		</div>
	</div>
</div>
@endsection
