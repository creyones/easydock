@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-3 col-md-2">
			@include('partials.sidebar', array('active' => 'docks'))
		</div>
		<div class="col-sm-9 col-md-10">
			<!-- Main Content -->
			@if (Auth::user()->hasRole('owner') || Auth::user()->hasRole('admin') || Auth::user()->hasRole('provider'))
			@include('errors.list')
			@if(!$errors->any())
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><i class="fa fa-ship"></i> {{trans('models.dock')}} <span class="label label-default">{{$dock->getObjectId()}}</span></h3>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-sm-3">
							<p><i class="fa fa-calendar"></i> <strong>{{trans('models.fields.created')}}</strong></p>
							<p> {{$dock->getCreatedAt()->format('Y-m-d H:i:s')}} </p>
						</div>
						<div class="col-sm-3">
							<p><i class="fa fa-calendar"></i> <strong>{{trans('models.fields.updated')}}</strong></p>
							<p> {{$dock->getUpdatedAt()->format('Y-m-d H:i:s')}} </p>
						</div>
					</div>
					<div class="row">
						<hr/>
						<div class="col-sm-4">
							<div class="thumbnail"><img src={{$dock->get('image')->getURL()}} class="img-rounded" alt="Image"></div>
						</div>
						<div class="col-sm-4">
							<p><i class="fa fa-file-text-o"></i> <strong>{{trans('models.fields.code')}}</strong></p>
							<p> {{$dock->get('codigo')}} </p>
							<p><i class="fa fa-file-text-o"></i> <strong>{{trans('models.fields.name')}}</strong></p>
							<p> {{$dock->get('name')}} </p>
							<p><i class="fa fa-file-text-o"></i> <strong>{{trans('models.fields.details')}}</strong></p>
							<p> {{$dock->get('detailText')}} </p>
						</div>
						<div class="col-sm-4">
							<p><i class="fa fa-ship"></i> <strong>{{trans('models.port')}}</strong></p>
							<p> {{$port->get('name')}} ({{$port->get('province')}}) </p>
							<p><i class="fa fa-user"></i> <strong>{{trans('models.user')}}</strong></p>
							<p> {{$provider->get('username')}} </p>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-4">
							<p><i class="fa fa-file-text-o"></i> <strong>{{trans('models.fields.properties')}}</strong></p>
							<ul class="list-unstyled">
								<li>{{trans('models.fields.beam')}}:{{$dock->get('manga')}}</li>
								<li>{{trans('models.fields.length')}}:{{$dock->get('eslora')}}</li>
								<li>{{trans('models.fields.draft')}}:{{$dock->get('calado')}}</li>
							</ul>
						</div>
						<div class="col-sm-4">
							<p><i class="fa fa-calendar"></i> <strong>{{trans('models.fields.available')}}</strong></p>
							<p>{{trans('models.fields.from')}}: <span>{{$dock->get('fechaInicio')->format('d/m/Y')}}</span></p>
							<p>{{trans('models.fields.until')}}: <span>{{$dock->get('fechaFinal')->format('d/m/Y')}}</span></p>
						</div>
						<div class="col-sm-4">
							<p><i class="fa fa-money"></i> <strong>{{trans('models.fields.price')}}</strong></p>
							<p> {{$dock->get('precio')}} {{trans('messages.price-per-day')}}</p>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<p><i class="fa fa-list"></i> <strong>{{trans('models.fields.services')}}</strong></p>
							<ul class="list-unstyled list-inline">
								<li>{{trans('models.fields.water')}}: {{$dock->get('agua') ? trans('messages.yes') : trans('messages.no') }}</li>
								<li>{{trans('models.fields.power')}}: {{$dock->get('electricidad') ? trans('messages.yes') : trans('messages.no') }}</li>
								<li>{{trans('models.fields.gas')}}: {{$dock->get('gasolinera') ? trans('messages.yes') : trans('messages.no') }}</li>
								<li>{{trans('models.fields.accomodation')}}: {{$dock->get('hoteles') ? trans('messages.yes') : trans('messages.no') }}</li>
								<li>{{trans('models.fields.naval')}}: {{$dock->get('marineros') ? trans('messages.yes') : trans('messages.no') }}</li>
								<li>{{trans('models.fields.radio')}}: {{$dock->get('radio') ? trans('messages.yes') : trans('messages.no') }}</li>
								<li>{{trans('models.fields.restaurant')}}: {{$dock->get('restaurantes') ? trans('messages.yes') : trans('messages.no') }}</li>
								<li>{{trans('models.fields.locker-room')}}: {{$dock->get('vestuarios') ? trans('messages.yes') : trans('messages.no') }}</li>
								<li>{{trans('models.fields.surveillance')}}: {{$dock->get('vigilancia') ? trans('messages.yes') : trans('messages.no') }}</li>
								<li>{{trans('models.fields.wifi')}}: {{$dock->get('wifi') ? trans('messages.yes') : trans('messages.no') }}</li>
							</ul>
						</div>
						<div class="col-sm-12">
							<p><i class="fa fa-file-text-o"></i> <strong>{{trans('models.fields.offer')}}</strong></p>
							<p> {{$dock->get('oferta')}} </p>
						</div>
					</div>
				</div>
				<div class="panel-footer">
					<div class="row">
						<div class="col-sm-12">
							<div class="pull-right">
							<a class="btn btn-sm btn-primary" href={{ route('docks.edit', array('id' => $dock->getObjectId())) }}><i class="fa fa-pencil-square-o"></i> {{trans('actions.edit')}}</a>
							<button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal" data-id={{$dock->getObjectId()}} data-whatever={{ route('docks.destroy', array('id' => $dock->getObjectId())) }}><i class="fa fa-trash-o"></i> {{trans('actions.delete')}} </button>
							<a href={{ route('docks.index') }} class="btn btn-sm btn-default">{{ trans('actions.back') }}</a>
						</div>
						</div>
					</div>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><i class="fa fa-calendar-o"></i> {{trans('views.calendar')}} </h3>
				</div>
				<div class="panel-body small">
					<div id='calendar'></div>
				</div>
				<div class="panel-footer">
					<div class="row">
						<div class="col-sm-12">
							<div class="pull-right">
								{!! Form::model($dock, ['method'=> 'PATCH', 'action' => ['DocksController@block', $dock->getObjectId()], 'class' =>'form-inline','role'=>'form', 'name' => 'form-calendar']) !!}
								{!! Form::text('block-from', '', ['class'=>'hidden']) !!}
								{!! Form::text('block-until', '', ['class'=>'hidden']) !!}
								{!! Form::submit(trans('actions.block'),['class' => 'btn btn-sm btn-default', 'id' => 'block']) !!}
								{!! Form::submit(trans('actions.unblock'),['class' => 'btn btn-sm btn-default', 'id' => 'unblock']) !!}
								{!! Form::close() !!}
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><i class="fa fa-bookmark-o"></i> {{trans('models.bookings')}} </h3>
				</div>
				<div class="panel-body">
					@if (count($bookings) > 0)
					<!-- Table -->
					<table class="table table-striped table-hover small">
						<thead>
							<tr>
								<th>{{strtolower(trans('models.fields.id'))}}</th>
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
								<td>{{ $booking->getObjectId() }}</td>
								<td>{{ $booking->get('fechaInicio')->format('Y-m-d') }}</td>
								<td>{{ $booking->get('fechaFinal')->format('Y-m-d') }}</td>
								<td>{{ $booking->get('precioTotal') }}€</td>
								<td>{{ $booking->get('confirmado') ? trans('messages.yes') : trans('messages.no') }}</td>
								<td class="small">{{ $booking->getCreatedAt()->format('Y-m-d H:i') }}</td>
							</tr>
							@endforeach
						</tbody>
					</table>
					@else
					<p class="alert alert-info">{{trans('messages.docks.no-bookings')}}</p>
					@endif
				</div>
			</div>
			@endif

			@include('partials.deletemodal', ['model' => 'dock', 'controller' => 'DocksController', 'id' => $dock->getObjectId()])

			@else
			<div class="col-sm-8 col-sm-offset-2">
				<p class="lead">{{trans('messages.access-forbidden')}}</p>
			</div>
			@endif
			<!-- End Main Content -->
		</div>
	</div>
</div>

<script>
	$(document).ready(function() {
		@foreach ($bookings as $booking)
		var newEvent = {
			allDay: true,
			start: moment('{{$booking->get("fechaInicio")->format("d/m/Y")}}', 'DD/MM/YYYY'),
			end: moment('{{$booking->get("fechaFinal")->format("d/m/Y")}}', 'DD/MM/YYYY').add(1, 'days'),
			title: '{{$booking->getObjectId()}}',
			@if ($booking->get('confirmado'))
			color: '#18bc9c',
			backgroundColor: '#18bc9c',
			@else
			color: '#f0ad4e',
			backgroundColor: '#f0ad4e',
			@endif
		};
		$('#calendar').fullCalendar('renderEvent', newEvent , 'stick');
		//console.log(newEvent);
		@endforeach
	});
</script>

<script>
	$(document).ready(function() {
		@foreach ($products as $product)
			@if ($product->get('bloqueado'))
				var newEvent = {
					start: moment('{{$product->get("fecha")->format("d/m/Y")}}', 'DD/MM/YYYY'),
					allDay: true,
					title: '{{trans("models.fields.blocked")}}',
					color: '#e74c3c',
					backgroundColor: '#e74c3c',
        };
				$('#calendar').fullCalendar( 'renderEvent', newEvent , 'stick');
			@else
			var newEvent = {
				start: moment('{{$product->get("fecha")->format("d/m/Y")}}', 'DD/MM/YYYY'),
				allDay: true,
				title: '{{trans("models.fields.available")}}',
				rendering: 'background',
				color: '#ddd',
				backgroundColor: '#ddd',
			};
			$('#calendar').fullCalendar( 'renderEvent', newEvent , 'stick');
			@endif
		@endforeach
	});
</script>

@include('partials.fullcalendar-block')
@endsection
