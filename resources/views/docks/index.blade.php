@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-3 col-md-2">
			@include('partials.sidebar', array('active' => 'docks'))
		</div>
		<div class="col-sm-9 col-md-10">
			@include('partials.flash')
			<!-- Main Content -->
			@if (Auth::user()->hasRole('owner') || Auth::user()->hasRole('admin') || Auth::user()->hasRole('provider'))
			<div class="row">
				<div class="col-sm-12">
					<p class="lead">
						<i class="fa fa-anchor fa-2x"></i> <span class="text-success"> {{count($docks)}} </span> {{trans('models.docks')}}
						<a class="btn btn-default pull-right" href={{route('docks.create')}}>{{trans('views.create_dock')}}</a>
					</p>
				</div>
				<div class="col-sm-12">
					<table id="data-table" class="table table-striped table-hover ">
						<thead>
							<tr>
								<th>{{strtolower(trans('models.fields.name'))}}</th>
								<th>{{strtolower(trans('models.port'))}}</th>
								<th>{{strtolower(trans('models.provider'))}}</th>
								<th>{{strtolower(trans('models.fields.created'))}}</th>
								<th>{{strtolower(trans('actions.actions'))}}</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($docks as $dock)
							<tr>
								<td>{{ $dock->get('name') }}</td>
								<td>{{ $dock->get('puertoRelation') ? $dock->get('puertoRelation')->getQuery()->find()[0]->get('name') : '--' }}</td>
								<td>{{ $dock->get('vendedorRelation') ? $dock->get('vendedorRelation')->getQuery()->find()[0]->get('username') : '--' }}</td>
								<td><small>{{ $dock->getCreatedAt()->format('Y-m-d H:i:s') }}</small></td>
								<td>
									<ul class="list-inline">
										<li><a class="btn btn-xs btn-success" href={{ route('docks.show', array('id' => $dock->getObjectId())) }}><i class="fa fa-eye"></i></a></li>
										<li><a class="btn btn-xs btn-primary" href={{ route('docks.edit', array('id' => $dock->getObjectId())) }}><i class="fa fa-pencil-square-o"></i></a></li>
										<li><button type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#deleteModal" data-id={{$dock->getObjectId()}} data-whatever={{ route('docks.destroy', array('id' => $dock->getObjectId())) }}><i class="fa fa-trash-o"></i></button></li>
									</ul>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
					@include('errors.list')
				</div>

				@include('partials.deletemodal', ['model' => 'dock', 'controller' => 'DocksController', 'id' => ''])

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
@include('partials.datatables')

@include('partials.flashdelay')

@include('partials.deletescript')

@endsection
