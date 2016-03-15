@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-3 col-md-2">
			@include('partials.sidebar', array('active' => 'docks'))
		</div>
		<div class="col-sm-9 col-md-10">
			<!-- Main Content -->
			<div class="row">
				@include('errors.list')
				@if (Auth::user()->hasRole('owner') || Auth::user()->hasRole('admin') || Auth::user()->hasRole('provider'))
				<div class="col-sm-12">
					<p class="lead"><i class="fa fa-edit fa-lg"></i> {{trans('views.edit_dock')}}</p></li>
					{!! Form::model($dock, ['method'=> 'PATCH', 'action' => ['DocksController@update', $dock->getObjectId()], 'class' =>'form-horizontal','role'=>'form', 'files' => true]) !!}
					<div class="form-group">
						{!!Form::Label('created', trans('models.fields.created'), ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-3">
							{!! Form::text('created', $dock->getCreatedAt()->format('Y-m-d H:i:s'), ['class'=>'form-control', 'disabled' => 'disabled']) !!}
						</div>
						{!!Form::Label('updated', trans('models.fields.updated'), ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-3">
							{!! Form::text('updated', $dock->getUpdatedAt()->format('Y-m-d H:i:s'), ['class'=>'form-control', 'disabled' => 'disabled']) !!}
						</div>
					</div>
					<div class="form-group">
						{!!Form::Label('id', trans('models.fields.id'), ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-3">
							{!! Form::text('id', $dock->getObjectId(), ['class'=>'form-control', 'disabled' => 'disabled']) !!}
						</div>
						{!!Form::Label('provider', trans('models.provider'), ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-3">
							{!! Form::select('provider', $providers, $provider->get('username'), ['class'=>'form-control']) !!}
						</div>
					</div>
					<hr/>
					@if (!Auth::user()->hasRole('provider'))
					<div class="form-group">
						{!!Form::Label('port', trans('models.port'), ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-8">
							{!! Form::select('port', $ports, $port->get('name'), ['class'=>'form-control']) !!}
						</div>
					</div>
					<hr/>
					@endif
					<div class="form-group">
						{!!Form::Label('name', trans('models.fields.code'), ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-8">
							{!! Form::text('code', $dock->get('codigo'), ['class'=>'form-control']) !!}
						</div>
					</div>
					<div class="form-group">
						{!!Form::Label('name', trans('models.fields.name'), ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-8">
							{!! Form::text('name', $dock->get('name'), ['class'=>'form-control']) !!}
						</div>
					</div>
					<div class="form-group">
						{!!Form::Label('details', trans('models.fields.details'), ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-8">
							{!! Form::textarea('details', $dock->get('detailText'), ['class'=>'form-control']) !!}
						</div>
					</div>
					<hr/>
					<div class="form-group">
						{!!Form::Label('beam', trans('models.fields.beam'), ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-2">
							{!! Form::text('beam', $dock->get('manga'), ['class'=>'form-control']) !!}
						</div>
						{!!Form::Label('length', trans('models.fields.length'), ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-2">
							{!! Form::text('length', $dock->get('eslora'), ['class'=>'form-control']) !!}
						</div>
					</div>
					<div class="form-group">
						{!!Form::Label('draft', trans('models.fields.draft'), ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-2">
							{!! Form::text('draft', $dock->get('calado'), ['class'=>'form-control']) !!}
						</div>
					</div>
					<hr/>
					<div class="form-group">
						{!!Form::Label('image', trans('models.fields.image'), ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-8">
							<input name="image" id="image" type="file" class="file" data-show-preview="true">
						</div>
					</div>
					<hr/>
					<div class="form-group">
						<label class="col-sm-2 control-label">
							{{trans("models.fields.services")}}
						</label>
						<div class="col-sm-8">
							<label for="water" class="col-sm-3 control-label control-label-left">
								{!!Form::checkbox('water', 1, $dock->get('agua')) !!} {{trans('models.fields.water')}}
							</label>
							<label for="power" class="col-sm-3 control-label control-label-left">
								{!!Form::checkbox('power', 1, $dock->get('electricidad')) !!} {{trans('models.fields.power')}}
							</label>
							<label for="gas" class="col-sm-3 control-label control-label-left">
								{!!Form::checkbox('gas', 1, $dock->get('gasolinera')) !!} {{trans('models.fields.gas')}}
							</label>
							<label for="naval" class="col-sm-3 control-label control-label-left">
								{!!Form::checkbox('naval', 1, $dock->get('marineros')) !!} {{trans('models.fields.naval')}}
							</label>
							<label for="radio" class="col-sm-3 control-label control-label-left">
								{!!Form::checkbox('radio', 1, $dock->get('radio')) !!} {{trans('models.fields.radio')}}
							</label>
							<label for="restaurant" class="col-sm-3 control-label control-label-left">
								{!!Form::checkbox('restaurant', 1, $dock->get('restaurantes')) !!} {{trans('models.fields.restaurant')}}
							</label>
							<label for="locker" class="col-sm-3 control-label control-label-left">
								{!!Form::checkbox('locker', 1, $dock->get('taquillas')) !!} {{trans('models.fields.locker')}}
							</label>
							<label for="lockerroom" class="col-sm-3 control-label control-label-left">
								{!!Form::checkbox('lockerroom', 1, $dock->get('vestuarios')) !!} {{trans('models.fields.locker-room')}}
							</label>
							<label for="accomodation" class="col-sm-3 control-label control-label-left">
								{!!Form::checkbox('accomodation', 1, $dock->get('hoteles')) !!} {{trans('models.fields.accomodation')}}
							</label>
							<label for="surveillance" class="col-sm-3 control-label control-label-left">
								{!!Form::checkbox('surveillance', 1, $dock->get('vigilancia')) !!} {{trans('models.fields.surveillance')}}
							</label>
							<label for="wifi" class="col-sm-3 control-label control-label-left">
								{!!Form::checkbox('wifi', 1, $dock->get('wifi')) !!} {{trans('models.fields.wifi')}}
							</label>
						</div>
					</div>
					<hr/>
					<div class="form-group">
						{!!Form::Label('price', trans('models.fields.price') . " (". trans('messages.price-per-day') .")", ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-3">
							{!! Form::text('price',  $dock->get('precio'), ['class'=>'form-control']) !!}
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-2 control-label"><p>{{ trans('models.fields.available') }}</p></div>
						<div class="col-sm-4">
							{!! Form::Label('from', trans('models.fields.from'), ['class'=>'control-label sr-only']) !!}
							{!! Form::text('from', $dock->get('fechaInicio')->format('d/m/Y'), ['class'=>'form-control', 'placeholder' => trans('models.fields.from') ]) !!}
						</div>
						<div class="col-sm-4">
							{!! Form::Label('until', trans('models.fields.until'), ['class'=>'control-label sr-only']) !!}
							{!! Form::text('until', $dock->get('fechaFinal')->format('d/m/Y'), ['class'=>'form-control', 'placeholder' => trans('models.fields.until') ]) !!}
						</div>
					</div>
					<hr/>
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title"><i class="fa fa-calendar-o"></i> {{trans('models.bookings')}} </h3>
						</div>
						<div class="panel-body">
							@if (count($bookings) > 0)
							<!-- Table -->
							<table class="table table-striped table-hover">
								<thead>
									<tr>
										<th>{{strtolower(trans('models.fields.from'))}}</th>
										<th>{{strtolower(trans('models.fields.until'))}}</th>
										<th>{{strtolower(trans('models.fields.price'))}}</th>
										<th>{{strtolower(trans('models.fields.confirmed'))}}</th>
										<th>{{strtolower(trans('models.fields.created'))}}</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($bookings as $booking)
									<tr>
										<td>{{ $booking->get('fechaInicio')->format('Y-m-d') }}</td>
										<td>{{ $booking->get('fechaFinal')->format('Y-m-d') }}</td>
										<td>{{ $booking->get('precioTotal') }}€</td>
										<td>{{ $booking->get('confirmado') ? trans('messages.yes') : trans('messages.no') }}</td>
										<td class="small">{{ $booking->getCreatedAt()->format('Y-m-d H:i:s') }}</td>
										<td><a class="btn btn-xs btn-primary" href={{ route('bookings.edit', $booking->getObjectId()) }}><i class="fa fa-pencil-square-o"></i></a></td>
									</tr>
									@endforeach
								</tbody>
							</table>
							@else
							<p class="alert alert-info">{{trans('messages.docks.no-bookings')}}</p>
							@endif
						</div>
					</div>
					<hr/>
					<div class="form-group">
						<div class="col-sm-8 col-sm-offset-2">
							{!!Form::submit(trans('actions.save'),['class' => 'btn btn-success']) !!}
							<a href={{ route('docks.index') }} class="btn btn-default">{{ trans('actions.cancel') }}</a>
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
@include('partials.daterange')
@include('partials.fileinput-preview', array('item' => 'image', 'preview' => $dock->get('image')->getURL(), 'caption' => trans('models.fields.image')))
@endsection
