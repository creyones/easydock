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
					{!! Form::open(['action' => 'PortsController@store', 'class' => 'form-horizontal','role'=>'form', 'files' => true]) !!}
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
						<label class="col-sm-2 control-label">
							{{trans("models.fields.services")}}
						</label>
						<div class="col-sm-8">
							<label for="water" class="col-sm-3 control-label control-label-left">
								{!!Form::checkbox('water') !!} {{trans('models.fields.water')}}
							</label>
							<label for="power" class="col-sm-3 control-label control-label-left">
								{!!Form::checkbox('power') !!} {{trans('models.fields.power')}}
							</label>
							<label for="gas" class="col-sm-3 control-label control-label-left">
								{!!Form::checkbox('gas') !!} {{trans('models.fields.gas')}}
							</label>
							<label for="naval" class="col-sm-3 control-label control-label-left">
								{!!Form::checkbox('naval') !!} {{trans('models.fields.naval')}}
							</label>
							<label for="radio" class="col-sm-3 control-label control-label-left">
								{!!Form::checkbox('radio') !!} {{trans('models.fields.radio')}}
							</label>
							<label for="restaurant" class="col-sm-3 control-label control-label-left">
								{!!Form::checkbox('restaurant') !!} {{trans('models.fields.restaurant')}}
							</label>
							<label for="locker" class="col-sm-3 control-label control-label-left">
								{!!Form::checkbox('locker') !!} {{trans('models.fields.locker')}}
							</label>
							<label for="lockerroom" class="col-sm-3 control-label control-label-left">
								{!!Form::checkbox('lockerroom') !!} {{trans('models.fields.locker-room')}}
							</label>
							<label for="accomodation" class="col-sm-3 control-label control-label-left">
								{!!Form::checkbox('accomodation') !!} {{trans('models.fields.accomodation')}}
							</label>
							<label for="surveillance" class="col-sm-3 control-label control-label-left">
								{!!Form::checkbox('surveillance') !!} {{trans('models.fields.surveillance')}}
							</label>
							<label for="wifi" class="col-sm-3 control-label control-label-left">
								{!!Form::checkbox('wifi') !!} {{trans('models.fields.wifi')}}
							</label>
						</div>
					</div>
					<hr/>
					<?php $names = array('plan', 'image', 'image2', 'image3'); ?>
					@foreach ($names as $name)
						<div class="form-group">
							@if ($name == 'plan')
								{!!Form::Label($name, trans('models.fields.plan'), ['class'=>'col-sm-2 control-label']) !!}
							@else
								{!!Form::Label($name, trans('models.fields.image'), ['class'=>'col-sm-2 control-label']) !!}
							@endif
							<div class="col-sm-8">
								<input id="{{$name}}" name="{{$name}}" type="file" class="file" data-show-preview="false">
							</div>
						</div>
					@endforeach
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
@foreach ($names as $name)
	@include('partials.fileinput', array('item' => $name))
@endforeach
@endsection
