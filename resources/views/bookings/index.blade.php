@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-3 col-md-2">
			@include('partials.sidebar', array('active' => 'bookings'))
		</div>
		<div class="col-sm-9 col-md-10">
			@include('partials.flash')
			<!-- Main Content -->
			<div class="row">
				@if (Auth::user()->hasRole('owner') || Auth::user()->hasRole('admin') || Auth::user()->hasRole('provider'))
				<div class="col-sm-12">
					<p class="lead"><i class="fa fa-anchor fa-2x"></i> <span class="text-success"> {{count($bookings)}} </span> {{trans('models.bookings')}} <a class="hidden btn btn-default pull-right" href={{route('bookings.create')}}>{{trans('views.create_booking')}}</a></p>
				</div>
				<div class="col-sm-12">
					<table id="data-table" class="table table-striped table-hover ">
						<thead>
							<tr>
								<th>{{strtolower(trans('models.port'))}}</th>
								<th>{{strtolower(trans('models.user'))}}</th>
								<th>{{strtolower(trans('models.fields.from'))}}</th>
								<th>{{strtolower(trans('models.fields.until'))}}</th>
								<th>{{strtolower(trans('models.fields.created'))}}</th>
								<th>{{strtolower(trans('actions.actions'))}}</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($bookings as $booking)
							<tr>
								<td>{{ $booking->get('nombrePuerto')}}</td>
								<td>{{ $booking->get('userRelation')->getQuery()->find()[0]->get('username') }}</td>
								<td><small>{{ $booking->get('fechaInicio')->format('d/m/Y') }}</small></td>
								<td><small>{{ $booking->get('fechaFinal')->format('d/m/Y') }}</small></td>
								<td><small>{{ $booking->getCreatedAt()->format('Y-m-d H:i:s') }}</small></td>
								<td>
									<ul class="list-inline">
										<li><a class="btn btn-xs btn-success" href={{ route('bookings.show', array('id' => $booking->getObjectId())) }}><i class="fa fa-eye"></i></a></li>
										<li><a class="btn btn-xs btn-primary" href={{ route('bookings.edit', array('id' => $booking->getObjectId())) }}><i class="fa fa-pencil-square-o"></i></a></li>
										@if (!Auth::user()->hasRole('provider'))
										<li><button type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#deleteModal" data-id={{$booking->getObjectId()}} data-whatever={{ route('bookings.destroy', array('id' => $booking->getObjectId())) }}><i class="fa fa-trash-o"></i></button></li>
										@endif
									</ul>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
					@include('errors.list')
				</div>

				@include('partials.deletemodal', ['model' => 'booking', 'controller' => 'BookingsController', 'id' => ''])

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
@include('partials.datatables')

@include('partials.flashdelay')

@include('partials.deletescript')

@endsection
