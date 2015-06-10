@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-3 col-md-2">
			@include('partials.sidebar', array('active' => 'ports'))
		</div>
		<div class="col-sm-9 col-md-10">
			<!-- Main Content -->
			@if (Auth::user()->hasRole('owner') || Auth::user()->hasRole('admin'))
			@include('errors.list')
			@if(!$errors->any())
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title"><i class="fa fa-ship"></i> {{trans('models.port')}} <span class="label label-default">{{$port->getObjectId()}}</span></h3>
				</div>
				<div class="panel-body">
					<div class="row">
						<div class="col-sm-3">
							<p><i class="fa fa-calendar"></i> <strong>{{trans('models.fields.created')}}</strong></p>
							<p> {{$port->getCreatedAt()->format('Y-m-d H:i:s')}} </p>
						</div>
						<div class="col-sm-3">
							<p><i class="fa fa-calendar"></i> <strong>{{trans('models.fields.updated')}}</strong></p>
							<p> {{$port->getUpdatedAt()->format('Y-m-d H:i:s')}} </p>
						</div>
					</div>
					<div class="row">
						<hr/>
						<div class="col-sm-3">
							<p><i class="fa fa-ship"></i> <strong>{{trans('models.fields.name')}}</strong></p>
							<p> {{$port->get('name')}} </p>
						</div>
						<div class="col-sm-3">
							<p><i class="fa fa-globe"></i> <strong>{{trans('models.fields.province')}}</strong></p>
							<p> {{$port->get('province')}} </p>
						</div>
						<div class="col-sm-3">
							<p><i class="fa fa-map-marker"></i> <strong>{{trans('models.fields.latitude')}}</strong></p>
							<p> {{$port->get('latitude')}} </p>
						</div>
						<div class="col-sm-3">
							<p><i class="fa fa-map-marker"></i> <strong>{{trans('models.fields.longitude')}}</strong></p>
							<p> {{$port->get('longitude')}} </p>
						</div>
					</div>
				</div>
				<div class="panel-footer">
					<div class="row">
						<div class="col-sm-12">
							<div class="pull-right">
							<a class="btn btn-sm btn-primary" href={{ route('ports.edit', array('id' => $port->getObjectId())) }}><i class="fa fa-pencil-square-o"></i> {{trans('actions.edit')}}</a>
							<button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteModal" data-id={{$port->getObjectId()}} data-whatever={{ route('ports.destroy', array('id' => $port->getObjectId())) }}><i class="fa fa-trash-o"></i> {{trans('actions.delete')}} </button>
							<a href={{ route('ports.index') }} class="btn btn-sm btn-default">{{ trans('actions.back') }}</a>
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
								<th>{{strtolower(trans('models.fields.username'))}}</th>
								<th>{{strtolower(trans('models.fields.created'))}}</th>
								<th></th>
							</tr>
						</thead>
						<tbody>
							@foreach ($docks as $dock)
							<tr>
								<td>{{ $dock->get('name') }}</td>
								<td class="small">{{ str_limit($dock->get('detailText'), 50, '...') }}</td>
								<td>{{ $dock->get('precio') }}{{trans('messages.price_per_day')}}</td>
								<td>{{ $dock->get('vendedorRelation')->getQuery()->find()[0]->get('username') }}</td>
								<td>{{ $dock->getCreatedAt()->format('Y-m-d H:i:s') }}</td>
								<td><a class="btn btn-xs btn-primary" href={{ route('docks.edit', $dock->getObjectId()) }}><i class="fa fa-pencil-square-o"></i></a></td>
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

			@include('partials.deletemodal', ['model' => 'port', 'controller' => 'PortsController', 'id' => $port->getObjectId()])

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
