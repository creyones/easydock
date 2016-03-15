@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-3 col-md-2">
			@include('partials.sidebar', array('active' => 'providers'))
		</div>
		<div class="col-sm-9 col-md-10">
			<!-- Main Content -->
			@if (Auth::user()->hasRole('owner') || Auth::user()->hasRole('admin'))
			@include('errors.list')
			@if(!$errors->any())
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><i class="fa fa-eur"></i> {{trans('models.provider')}} <span class="label label-default">{{$provider->getObjectId()}}</span></h3>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-sm-3">
							<p><i class="fa fa-calendar"></i> <strong>{{trans('models.fields.created')}}</strong></p>
							<p> {{$provider->getCreatedAt()->format('Y-m-d H:i:s')}} </p>
						</div>
						<div class="col-sm-3">
							<p><i class="fa fa-calendar"></i> <strong>{{trans('models.fields.updated')}}</strong></p>
							<p> {{$provider->getUpdatedAt()->format('Y-m-d H:i:s')}} </p>
						</div>
					</div>
					<div class="row">
						<hr/>
						<div class="col-sm-3">
							<p><i class="fa fa-user"></i> <strong>{{trans('models.fields.username')}}</strong></p>
							<p> {{$provider->get('username')}} </p>
						</div>
						<div class="col-sm-6">
							<p><i class="fa fa fa-envelope-o"></i> <strong>{{trans('models.fields.email')}}</strong></p>
							<p> {{$provider->get('email')}} </p>
						</div>
					</div>
					<div class="row">
						<hr/>
						@if ($profile)
						<div class="col-sm-3">
							<p><i class="fa fa-cogs"></i> <strong>{{trans('models.role')}}</strong></p>
							<p> {{$profile->roles()->first()->display_name}} </p>
						</div>
						@endif
						<div class="col-sm-6">
							<p><i class="fa fa fa-ship"></i> <strong>{{trans('models.port')}}</strong></p>
							<p> {{($port ? $port->get('name') : '')}} </p>
						</div>
					</div>

					@if ($profile)
					<div class="row">
						<hr/>
						<div class="col-sm-6">
							<div class="row">
								<div class="col-sm-12">
									<p><i class="fa fa-user"></i> <strong>{{trans('models.fields.name')}}</strong></p>
									<p> {{ $profile->firstname ." ". $profile->lastname }} </p>
								</div>
								<div class="col-sm-6">
									<p><i class="fa fa fa-phone"></i> <strong>{{trans('models.fields.phone')}}</strong></p>
								  <p> {{$profile->phone}} </p>
								</div>
								<div class="col-sm-6">
								  <p><i class="fa fa fa-phone"></i> <strong>{{trans('models.fields.mobile')}}</strong></p>
								  <p> {{$profile->mobile}} </p>
								</div>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="row">
								<div class="col-sm-12">
									<p><i class="fa fa-map-marker"></i> <strong>{{trans('models.fields.address')}}</strong></p>
									<p> {{$profile->address}} </p>
								</div>
								<div class="col-sm-6">
									<p><i class="fa fa-map-marker"></i> <strong>{{trans('models.fields.city')}}</strong></p>
									<p> {{$profile->city}} </p>
								</div>
								<div class="col-sm-6">
									<p><i class="fa fa-map-marker"></i> <strong>{{trans('models.fields.postalcode')}}</strong></p>
									<p> {{$profile->postalcode}} </p>
								</div>
							</div>
						</div>
					</div>
					@endif
				</div>
				<div class="panel-footer">
					<div class="row">
						<div class="col-sm-12">
							<div class="pull-right">
							<a class="btn btn-sm btn-primary" href={{ route('providers.edit', array('id' => $provider->getObjectId())) }}><i class="fa fa-pencil-square-o"></i> {{trans('actions.edit')}}</a>
							<button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal" data-id={{$provider->getObjectId()}} data-whatever={{ route('providers.destroy', array('id' => $provider->getObjectId())) }}><i class="fa fa-trash-o"></i> {{trans('actions.delete')}} </button>
							<a href={{ route('providers.index') }} class="btn btn-sm btn-default">{{ trans('actions.back') }}</a>
						</div>
						</div>
					</div>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><i class="fa fa-anchor"></i> {{trans('models.docks')}} </h3>
				</div>
				<div class="panel-body">
					@if (count($docks) > 0)
					<!-- Table -->
					<table class="table table-striped table-hover">
						<thead>
							<tr>
								<th>{{strtolower(trans('models.fields.name'))}}</th>
								<th>{{strtolower(trans('models.fields.details'))}}</th>
								<th>{{strtolower(trans('models.fields.price'))}}</th>
								<th>{{strtolower(trans('models.port'))}}</th>
								<th>{{strtolower(trans('models.fields.created'))}}</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							@foreach ($docks as $dock)
							<tr>
								<td>{{ $dock->get('name') }}</td>
								<td class="small">{{ $dock->get('detailText') }}</td>
								<td>{{ $dock->get('precio') }} {{trans('messages.price-per-day')}}</td>
								<td>{{ $dock->get('puertoRelation')->getQuery()->find()[0]->get('name') }}</td>
								<td>{{ $dock->getCreatedAt()->format('Y-m-d H:i:s') }}</td>
								<td><a class="btn btn-xs btn-primary" href={{ route('docks.edit', $dock->getObjectId()) }}><i class="fa fa-pencil-square-o"></i></a></td>
							</tr>
							@endforeach
						</tbody>
					</table>
					@else
					<p class="alert alert-info">{{trans('messages.providers.no-docks')}}</p>
					@endif
				</div>
			</div>
			@endif

			@include('partials.deletemodal', ['model' => 'provider', 'controller' => 'ProvidersController', 'id' => $provider->getObjectId()])

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
