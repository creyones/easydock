@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-3 col-md-2">
			@include('partials.sidebar', array('active' => 'ports'))
		</div>
		<div class="col-sm-9 col-md-10">
			<!-- Main Content -->
			<div class="row">
				@include('errors.list')
				@if (Auth::user()->hasRole('owner') || Auth::user()->hasRole('admin'))
				<div class="col-sm-12">
					<p class="lead"><i class="fa fa-plus-square fa-lg"></i> {{trans('views.create_port')}}</p></li>
					{!! Form::open(['action' => 'PortsController@store', 'class' => 'form-horizontal','role'=>'form']) !!}
					<div class="form-group">
						{!!Form::Label('name', trans('models.fields.name'), ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-8">
							{!! Form::text('name', '', ['class'=>'form-control']) !!}
						</div>
					</div>
					<div class="form-group">
						{!!Form::Label('provinces', trans('models.fields.province'), ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-8">
							{!! Form::select('provinces', $provinces, '', ['class'=>'form-control']) !!}
						</div>
					</div>
					<div class="form-group">
						{!!Form::Label('latitude', trans('models.fields.latitude'), ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-8">
							{!! Form::text('latitude', '', ['class'=>'form-control']) !!}
						</div>
					</div>
					<div class="form-group">
						{!!Form::Label('longitude', trans('models.fields.longitude'), ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-8">
							{!! Form::text('longitude', '', ['class'=>'form-control']) !!}
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-8 col-sm-offset-2">
							{!!Form::submit(trans('actions.save'),['class' => 'btn btn-success']) !!}
							<a href={{ route('ports.index') }} class="btn btn-default">{{ trans('actions.cancel') }}</a>
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
