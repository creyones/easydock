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
					<p class="lead"><i class="fa fa-edit fa-lg"></i> {{trans('views.edit_port')}}</p></li>
					{!! Form::model($port, ['method'=> 'PATCH', 'action' => ['PortsController@update', $port->getObjectId()], 'class' =>'form-horizontal','role'=>'form']) !!}
					<div class="form-group">
						{!!Form::Label('created', trans('models.fields.created'), ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-4">
							{!! Form::text('created', $port->getCreatedAt()->format('Y-m-d H:i:s'), ['class'=>'form-control', 'disabled' => 'disabled']) !!}
						</div>
					</div>
					<div class="form-group">
						{!!Form::Label('updated', trans('models.fields.updated'), ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-4">
							{!! Form::text('updated', $port->getCreatedAt()->format('Y-m-d H:i:s'), ['class'=>'form-control', 'disabled' => 'disabled']) !!}
						</div>
					</div>
					<div class="form-group">
						{!!Form::Label('id', trans('models.fields.id'), ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-4">
							{!! Form::text('id', $port->getObjectId(), ['class'=>'form-control', 'disabled' => 'disabled']) !!}
						</div>
					</div>
					<div class="form-group">
						{!!Form::Label('name', trans('models.fields.name'), ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-8">
							{!! Form::text('name', $port->get('name'), ['class'=>'form-control']) !!}
						</div>
					</div>
					<div class="form-group">
						{!!Form::Label('province', trans('models.fields.province'), ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-8">
							{!! Form::select('provinces', $provinces, $port->get('province'), ['class'=>'form-control']) !!}
						</div>
					</div>
					<div class="form-group">
						{!!Form::Label('latitude', trans('models.fields.latitude'), ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-4">
							{!! Form::text('latitude', $port->get('latitude'), ['class'=>'form-control']) !!}
						</div>
					</div>
					<div class="form-group">
						{!!Form::Label('longitude', trans('models.fields.longitude'), ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-4">
							{!! Form::text('longitude', $port->get('longitude'), ['class'=>'form-control']) !!}
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-2 control-label">
							{{trans("models.fields.services")}}
						</label>
						<div class="col-sm-8">
							<label for="water" class="col-sm-3 control-label control-label-left">
								{!!Form::checkbox('water', 1, $port->get('agua')) !!} {{trans('models.fields.water')}}
							</label>
							<label for="power" class="col-sm-3 control-label control-label-left">
								{!!Form::checkbox('power', 1, $port->get('electricidad')) !!} {{trans('models.fields.power')}}
							</label>
							<label for="gas" class="col-sm-3 control-label control-label-left">
								{!!Form::checkbox('gas', 1, $port->get('gasolinera')) !!} {{trans('models.fields.gas')}}
							</label>
							<label for="naval" class="col-sm-3 control-label control-label-left">
								{!!Form::checkbox('naval', 1, $port->get('marineros')) !!} {{trans('models.fields.naval')}}
							</label>
							<label for="radio" class="col-sm-3 control-label control-label-left">
								{!!Form::checkbox('radio', 1, $port->get('radio')) !!} {{trans('models.fields.radio')}}
							</label>
							<label for="restaurant" class="col-sm-3 control-label control-label-left">
								{!!Form::checkbox('restaurant', 1, $port->get('restaurantes')) !!} {{trans('models.fields.restaurant')}}
							</label>
							<label for="locker" class="col-sm-3 control-label control-label-left">
								{!!Form::checkbox('locker', 1, $port->get('taquillas')) !!} {{trans('models.fields.locker')}}
							</label>
							<label for="lockerroom" class="col-sm-3 control-label control-label-left">
								{!!Form::checkbox('lockerroom', 1, $port->get('vestuarios')) !!} {{trans('models.fields.locker-room')}}
							</label>
							<label for="accomodation" class="col-sm-3 control-label control-label-left">
								{!!Form::checkbox('accomodation', 1, $port->get('hoteles')) !!} {{trans('models.fields.accomodation')}}
							</label>
							<label for="surveillance" class="col-sm-3 control-label control-label-left">
								{!!Form::checkbox('surveillance', 1, $port->get('vigilancia')) !!} {{trans('models.fields.surveillance')}}
							</label>
							<label for="wifi" class="col-sm-3 control-label control-label-left">
								{!!Form::checkbox('wifi', 1, $port->get('wifi')) !!} {{trans('models.fields.wifi')}}
							</label>
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
