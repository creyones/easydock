@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-3 col-md-2">
			@include('partials.sidebar', array('active' => 'ports'))
		</div>
		<div class="col-sm-9 col-md-10">
			@include('partials.flash')
			<!-- Main Content -->
			<div class="row">
				@if (Auth::user()->hasRole('owner') || Auth::user()->hasRole('admin') || Auth::user()->hasRole('provider'))
				<div class="col-sm-12">
					<p class="lead"><i class="fa fa-ship fa-2x"></i> <span class="text-success"> {{count($ports)}} </span> {{trans('models.ports')}}
					@if (!Auth::user()->hasRole('provider'))
						<a class="btn btn-default pull-right" href={{route('ports.create')}}>{{trans('views.create_port')}}</a>
					@endif
					</p>
				</div>
				<div class="col-sm-12">
					<table id="data-table" class="table table-striped table-hover ">
						<thead>
							<tr>
								<th>{{strtolower(trans('models.fields.name'))}}</th>
								<th>{{strtolower(trans('models.fields.province'))}}</th>
								<th>{{strtolower(trans('models.fields.created'))}}</th>
								<th>{{strtolower(trans('actions.actions'))}}</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($ports as $port)
							<tr>
								<td>{{ $port->get('name') }}</td>
								<td>{{ $port->get('province') }}</td>
								<td><small>{{ $port->getCreatedAt()->format('Y-m-d H:i:s') }}</small></td>
								<td>
									<ul class="list-inline">
										<li><a class="btn btn-xs btn-success" href={{ route('ports.show', array('id' => $port->getObjectId())) }}><i class="fa fa-eye"></i></a></li>
										<li><a class="btn btn-xs btn-primary" href={{ route('ports.edit', array('id' => $port->getObjectId())) }}><i class="fa fa-pencil-square-o"></i></a></li>
										@if (!Auth::user()->hasRole('provider'))
											<li><button type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#deleteModal" data-id={{$port->getObjectId()}} data-whatever={{ route('ports.destroy', array('id' => $port->getObjectId())) }}><i class="fa fa-trash-o"></i></button></li>
										@endif
									</ul>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
					@include('errors.list')
				</div>

				@include('partials.deletemodal', ['model' => 'port', 'controller' => 'PortsController', 'id' => ''])

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
