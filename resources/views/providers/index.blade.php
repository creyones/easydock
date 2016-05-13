@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-3 col-md-2">
			@include('partials.sidebar', array('active' => 'providers'))
		</div>
		<div class="col-sm-9 col-md-10">
			@include('partials.flash')
			<!-- Main Content -->
			<div class="row">
				@if (Auth::user()->hasRole('owner') || Auth::user()->hasRole('admin'))
				<div class="col-sm-12">
					<p class="lead"><i class="fa fa-building fa-2x"></i> <span class="text-success"> {{count($providers)}} </span> {{trans('models.providers')}}  <a class="btn btn-default pull-right" href={{route('providers.create')}}>{{trans('views.create_provider')}}</a></p>
				</div>
				<div class="col-sm-12">
					<table id="data-table" class="table table-striped table-hover ">
						<thead>
							<tr>
								<th>{{strtolower(trans('models.fields.username'))}}</th>
								<th>{{strtolower(trans('models.fields.email'))}}</th>
								<th>{{strtolower(trans('models.fields.created'))}}</th>
								<th>{{strtolower(trans('actions.actions'))}}</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($providers as $provider)
							<tr>
								<td>{{ $provider->get('username') }}</td>
								<td>{{ $provider->get('email') }}</td>
								<td>{{ $provider->getCreatedAt()->format('Y-m-d H:i:s') }}</td>
								<td>
									<ul class="list-inline">
										<li><a class="btn btn-xs btn-success" href={{ route('providers.show', array('id' => $provider->getObjectId())) }}><i class="fa fa-eye"></i></a></li>
										<li><a class="btn btn-xs btn-primary" href={{ route('providers.edit', array('id' => $provider->getObjectId())) }}><i class="fa fa-pencil-square-o"></i></a></li>
										<li><button type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#deleteModal" data-id={{$provider->getObjectId()}} data-whatever={{ route('providers.destroy', array('id' => $provider->getObjectId())) }}><i class="fa fa-trash-o"></i></button></li>
									</ul>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
					@include('errors.list')
				</div>

				@include('partials.deletemodal', ['model' => 'provider', 'controller' => 'ProvidersController', 'id' => ''])

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
