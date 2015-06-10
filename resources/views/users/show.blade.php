@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-3 col-md-2">
			@include('partials.sidebar', ['active' => 'users'])
		</div>
		<div class="col-sm-9 col-md-10">
			<!-- Main Content -->
			@if (Auth::user()->hasRole('owner') || Auth::user()->hasRole('admin'))
			@include('errors.list')
			@if(!$errors->any())
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><i class="fa fa-user"></i> {{trans('models.user')}} <span class="label label-default">{{$user->getObjectId()}}</span></h3>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-sm-3">
							<p><i class="fa fa-calendar"></i> <strong>{{trans('models.fields.created')}}</strong></p>
							<p> {{$user->getCreatedAt()->format('Y-m-d H:i:s')}} </p>
						</div>
						<div class="col-sm-3">
							<p><i class="fa fa-calendar"></i> <strong>{{trans('models.fields.updated')}}</strong></p>
							<p> {{$user->getUpdatedAt()->format('Y-m-d H:i:s')}} </p>
						</div>
					</div>
					<div class="row">
						<hr/>
						<div class="col-sm-4">
							<p><i class="fa fa-user"></i> <strong>{{trans('models.fields.username')}}</strong></p>
							<p> {{$user->get('username')}} </p>
						</div>
						<div class="col-sm-8">
							<p><i class="fa fa fa-envelope-o"></i> <strong>{{trans('models.fields.email')}}</strong></p>
							<p> {{$user->get('email')}} </p>
						</div>
					</div>
					<div class="row">
						<hr/>
						<div class="col-sm-4">
							<p><i class="fa fa-arrows-h"></i> <strong>{{trans('models.fields.beam')}}</strong></p>
							<p> {{$user->get('manga')}} m.</p>
						</div>
						<div class="col-sm-4">
							<p><i class="fa fa-arrows-v"></i> <strong>{{trans('models.fields.length')}}</strong></p>
							<p> {{$user->get('eslora')}} m.</p>
						</div>
						<div class="col-sm-4">
							<p><i class="fa fa-arrow-down"></i> <strong>{{trans('models.fields.draft')}}</strong></p>
							<p> {{$user->get('calado')}} m.</p>
						</div>
					</div>
					@if ($user->get('profile') != null)
					<div class="row">
						<hr/>
						<div class="col-sm-12">
							<p><i class="fa fa-facebook-square fa-lg"></i> <strong>Facebook</strong> </p>
							<dl class="dl-horizontal small">
								@foreach ($user->get('profile') as $key => $value)
								<dt>{{$key}}</dt>
								<dd>{{$value}}</dd>
								@endforeach
							</dl>
						</div>
					</div>
					@endif
				</div>
				<div class="panel-footer">
					<div class="row">
						<div class="col-sm-12">
							<div class="pull-right">
								<a class="btn btn-sm btn-primary" href={{ route('users.edit', array('id' => $user->getObjectId())) }}><i class="fa fa-pencil-square-o"></i> {{trans('actions.edit')}}</a>
								<button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal" data-id={{$user->getObjectId()}} data-whatever={{ route('users.destroy', array('id' => $user->getObjectId())) }}><i class="fa fa-trash-o"></i> {{trans('actions.delete')}} </button>
								<a href={{ route('users.index') }} class="btn btn-sm btn-default">{{ trans('actions.back') }}</a>
							</div>
						</div>
					</div>
				</div>
			</div>
			@if (count($bookings) > 0)
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><i class="fa fa-anchor"></i> {{trans('models.bookings')}} </h3>
				</div>
				<div class="panel-body">
					<!-- Table -->
					<table class="table table-striped table-hover">
						<thead>
							<tr>
								<th>{{strtolower(trans('models.fields.status'))}}</th>
								<th>{{strtolower(trans('models.fields.booked'))}}</th>
								<th>{{strtolower(trans('models.fields.confirmed'))}}</th>
								<th>{{strtolower(trans('models.fields.date'))}}</th>
								<th>{{strtolower(trans('models.fields.created'))}}</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							@foreach ($bookings as $booking)
							<tr>
								<td>{{ $booking->get('estado') ? trans('messages.true') : trans('messages.false') }}</td>
								<td>{{ /*$booking->get('producto')->getQuery()->find()[0]->get('reservado') ? trans('messages.yes') : trans('messages.no')*/ trans('messages.yes') }} </td>
								<td>{{ /*$booking->get('producto')->getQuery()->find()[0]->get('confirmado') ? trans('messages.yes') : trans('messages.no')*/ trans('messages.yes') }}</td>
								<td>{{ /*$booking->get('producto')->getQuery()->find()[0]->get('fecha')->format('Y-m-d H:i:s')*/ '0000-00-00 00:00:00' }}</td>
								<td>{{ $booking->getCreatedAt()->format('Y-m-d H:i:s') }}</td>
								<td><a class="btn btn-xs btn-primary" href={{ route('bookings.edit', $booking->getObjectId()) }}><i class="fa fa-pencil-square-o"></i></a></td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
			@endif
			@else
			<div class="alert alert-info">
				{{trans('messages.no-related-items')}}
			</div>
			@endif

			@include('partials.deletemodal', ['model' => 'user', 'controller' => 'UsersController', 'id' => $user->getObjectId()])

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

@include('partials.deletescript')

@endsection
