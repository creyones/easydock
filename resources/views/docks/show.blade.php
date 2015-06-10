@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-3 col-md-2">
			@include('partials.sidebar', array('active' => 'docks'))
		</div>
		<div class="col-sm-9 col-md-10">
			<!-- Main Content -->
			@if (Auth::user()->hasRole('owner') || Auth::user()->hasRole('admin'))
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
						<div class="col-sm-6">
							<p><i class="fa fa-file-text-o"></i> <strong>{{trans('models.fields.code')}}</strong></p>
							<p> {{$dock->get('codigo')}} </p>
							<p><i class="fa fa-file-text-o"></i> <strong>{{trans('models.fields.name')}}</strong></p>
							<p> {{$dock->get('name')}} </p>
							<p><i class="fa fa-file-text-o"></i> <strong>{{trans('models.fields.details')}}</strong></p>
							<p> {{$dock->get('detailText')}} </p>
							<p><i class="fa fa-money"></i> <strong>{{trans('models.fields.price')}}</strong></p>
							<p> {{$dock->get('precio')}} {{trans('messages.price_per_day')}}</p>
							<p><i class="fa fa-calendar"></i> <strong>{{trans('models.fields.available')}}</strong></p>
							<p>{{trans('models.fields.from')}}: <span>{{$dock->get('fechaInicio')->format('d/m/Y')}}</span></p>
							<p>{{trans('models.fields.until')}}: <span>{{$dock->get('fechaFinal')->format('d/m/Y')}}</span></p>
						</div>
						<div class="col-sm-3">
							<p><i class="fa fa-file-text-o"></i> <strong>{{trans('models.fields.properties')}}</strong></p>
							<ul class="list-unstyled">
								<li>{{trans('models.fields.beam')}}:{{$dock->get('manga')}}</li>
								<li>{{trans('models.fields.length')}}:{{$dock->get('eslora')}}</li>
								<li>{{trans('models.fields.draft')}}:{{$dock->get('calado')}}</li>
							</ul>
							<p><i class="fa fa-list"></i> <strong>{{trans('models.fields.services')}}</strong></p>
							<ul class="list-unstyled">
								<li>{{trans('models.fields.water')}}:{{$dock->get('agua') ? trans('messages.yes') : trans('messages.no') }}</li>
								<li>{{trans('models.fields.power')}}:{{$dock->get('electricidad') ? trans('messages.yes') : trans('messages.no') }}</li>
								<li>{{trans('models.fields.gas')}}:{{$dock->get('gasolinera') ? trans('messages.yes') : trans('messages.no') }}</li>
								<li>{{trans('models.fields.accomodation')}}:{{$dock->get('hoteles') ? trans('messages.yes') : trans('messages.no') }}</li>
								<li>{{trans('models.fields.naval')}}:{{$dock->get('marineros') ? trans('messages.yes') : trans('messages.no') }}</li>
								<li>{{trans('models.fields.radio')}}:{{$dock->get('radio') ? trans('messages.yes') : trans('messages.no') }}</li>
								<li>{{trans('models.fields.restaurant')}}:{{$dock->get('restaurantes') ? trans('messages.yes') : trans('messages.no') }}</li>
								<li>{{trans('models.fields.locker-room')}}:{{$dock->get('vestuarios') ? trans('messages.yes') : trans('messages.no') }}</li>
								<li>{{trans('models.fields.surveillance')}}:{{$dock->get('vigilancia') ? trans('messages.yes') : trans('messages.no') }}</li>
								<li>{{trans('models.fields.wifi')}}:{{$dock->get('wifi') ? trans('messages.yes') : trans('messages.no') }}</li>
							</ul>
						</div>
						<div class="col-sm-3">
							<div class="thumbnail"><img src={{$dock->get('image')->getURL()}} class="img-rounded" alt="Image"></div>
							<p><i class="fa fa-ship"></i> <strong>{{trans('models.port')}}</strong></p>
							<p> {{$port->get('name')}} ({{$port->get('province')}}) </p>
							<p><i class="fa fa-user"></i> <strong>{{trans('models.user')}}</strong></p>
							<p> {{$provider->get('username')}} </p>
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
					<p class="alert alert-info">{{trans('message.no_bookings')}}</p>
					@endif
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><i class="fa fa-bookmark-o"></i> {{trans('models.products')}} </h3>
				</div>
				<div class="panel-body">
					@if (count($products) > 0)
					<!-- Table -->
					<table class="table table-striped table-hover">
						<thead>
							<tr>
								<th>{{strtolower(trans('models.fields.date'))}}</th>
								<th>{{strtolower(trans('models.fields.price'))}}</th>
								<th>{{strtolower(trans('models.fields.booked'))}}</th>
								<th>{{strtolower(trans('models.fields.confirmed'))}}</th>
								<th>{{strtolower(trans('models.fields.created'))}}</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($products as $product)
							<tr>
								<td>{{ $product->get('fecha')->format('Y-m-d') }}</td>
								<td>{{ $product->get('precio') }}€</td>
								<td>{{ $product->get('reservado') ? trans('messages.yes') : trans('messages.no')  }}</td>
								<td>{{ $product->get('confirmado') ? trans('messages.yes') : trans('messages.no') }}</td>
								<td class="small">{{ $product->getCreatedAt()->format('Y-m-d H:i:s') }}</td>
							</tr>
							@endforeach
						</tbody>
					</table>
					@else
					<p class="alert alert-info">{{trans('message.no_docks')}}</p>
					@endif
				</div>
			</div>
			@endif

			@include('partials.deletemodal', ['model' => 'dock', 'controller' => 'DocksController', 'id' => $dock->getObjectId()])

			@else
			<div class="col-sm-8 col-sm-offset-2">
				<p class="lead">{{trans('messages.accessforbidden')}}</p>
			</div>
			@endif
			<!-- End Main Content -->
		</div>
	</div>
</div>
@endsection
