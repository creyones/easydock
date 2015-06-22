@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-3 col-md-2">
			@include('partials.sidebar', array('active' => 'bookings'))
		</div>
		<div class="col-sm-9 col-md-10">
			<!-- Main Content -->
			@if (Auth::user()->hasRole('owner') || Auth::user()->hasRole('admin') || Auth::user()->hasRole('provider'))
			@include('errors.list')
			@if(!$errors->any())
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><i class="fa fa-ship"></i> {{trans('models.booking')}} <span class="label label-default">{{$booking->getObjectId()}}</span></h3>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-sm-3">
							<p><i class="fa fa-calendar"></i> <strong>{{trans('models.fields.created')}}</strong></p>
							<p> {{$booking->getCreatedAt()->format('Y-m-d H:i:s')}} </p>
						</div>
						<div class="col-sm-3">
							<p><i class="fa fa-calendar"></i> <strong>{{trans('models.fields.updated')}}</strong></p>
							<p> {{$booking->getUpdatedAt()->format('Y-m-d H:i:s')}} </p>
						</div>
					</div>
					<div class="row">
						<hr/>
						<div class="col-sm-3">
							<p><i class="fa fa-calendar"></i> <strong>{{trans('models.fields.from')}}</strong></p>
							<p> {{$booking->get('fechaInicio')->format('d/m/Y')}} </p>
							<p><i class="fa fa-calendar"></i> <strong>{{trans('models.fields.until')}}</strong></p>
							<p> {{$booking->get('fechaFinal')->format('d/m/Y')}} </p>
							<p><i class="fa fa-money"></i> <strong>{{trans('models.fields.price_total')}}</strong></p>
							<p> {{$booking->get('precioTotal')}} €</p>
						</div>
						<div class="col-sm-4">
							<p><i class="fa fa-ship"></i> <strong>{{trans('models.port')}}</strong></p>
							<p> {{$booking->get('nombrePuerto')}} </p>
							<p><i class="fa fa-anchor"></i> <strong>{{trans('models.dock')}}</strong></p>
							<p> {{$dock->get('name')}}  <span class="label label-default">{{$dock->get('codigo')}}</span></p>
							<ul class="list-unstyled">
								<li><strong>{{trans('models.fields.beam')}}: </strong> {{$dock->get('manga')}}</li>
								<li><strong>{{trans('models.fields.length')}}: </strong> {{$dock->get('eslora')}}</li>
								<li><strong>{{trans('models.fields.draft')}}: </strong> {{$dock->get('calado')}}</li>
							</ul>
						</div>
						<div class="col-sm-4">
							<p><i class="fa fa-user"></i> <strong>{{trans('models.user')}}</strong></p>
							<p> {{$user->get('username')}} </p>
							<p><i class="fa fa-envelope-o"></i> <strong>{{trans('models.fields.email')}}</strong></p>
							<p> {{$user->get('email')}} </p>
							<ul class="list-unstyled">
								<li><strong>{{trans('models.fields.beam')}}: </strong> {{$user->get('manga')}}</li>
								<li><strong>{{trans('models.fields.length')}}: </strong> {{$user->get('eslora')}}</li>
								<li><strong>{{trans('models.fields.draft')}}: </strong> {{$user->get('calado')}}</li>
							</ul>
						</div>
					</div>
					<div class="row">
						<hr/>
						<div class="col-sm-6">
							<p><i class="fa fa-user"></i> <strong>{{trans('models.fields.confirmed')}}</strong></p>
							<p><span class="label {{$booking->get('confirmado') ? 'label-success' : 'label-danger' }}">{{$booking->get('confirmado') ? trans('messages.yes') : trans('messages.no')}}</span></p>
						</div>
					</div>
				</div>
				<div class="panel-footer">
					<div class="row">
						<div class="col-sm-12">
							<div class="pull-right">
							<a class="btn btn-sm btn-primary" href={{ route('bookings.edit', array('id' => $booking->getObjectId())) }}><i class="fa fa-pencil-square-o"></i> {{trans('actions.edit')}}</a>
							<button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal" data-id={{$booking->getObjectId()}} data-whatever={{ route('bookings.destroy', array('id' => $booking->getObjectId())) }}><i class="fa fa-trash-o"></i> {{trans('actions.delete')}} </button>
							<a href={{ route('bookings.index') }} class="btn btn-sm btn-default">{{ trans('actions.cancel') }}</a>
						</div>
						</div>
					</div>
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
					<p class="alert alert-info">{{trans('message.no_bookings')}}</p>
					@endif
				</div>
			</div>
			@endif
			@include('partials.deletemodal', ['model' => 'booking', 'controller' => 'BookingsController', 'id' => $booking->getObjectId()])

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
