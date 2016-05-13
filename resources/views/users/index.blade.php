@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-3 col-md-2">
			@include('partials.sidebar', ['active' => 'users'])
		</div>
		<div class="col-sm-9 col-md-10">
			@include('partials.flash')
			<!-- Main Content -->
			<div class="row">
				@if (Auth::user()->hasRole('owner') || Auth::user()->hasRole('admin'))
				<div class="col-sm-12">
					<p class="lead"><i class="fa fa-users fa-2x"></i> <span class="text-success"> {{count($users)}} </span> {{trans('models.users')}} <a class="btn btn-default pull-right" href={{route('users.create')}}>{{trans('views.create_user')}}</a></p>
				</div>
				<div class="col-sm-12">
					<table id="data-table" class="table table-striped table-hover ">
						<thead>
							<tr>
								<th>{{strtolower(trans('models.fields.username'))}}</th>
								<th>{{strtolower(trans('models.fields.email'))}}</th>
								<th>{{strtolower(trans('models.fields.profile'))}}</th>
								<th>{{strtolower(trans('models.fields.created'))}}</th>
								<th>{{strtolower(trans('actions.actions'))}}</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($users as $user)
							<tr>
								<td>{{ $user->get('username') }}</td>
								<td>{{ $user->get('email') }}</td>
								@if ($user->get('profile'))
									<td><small><i class="fa fa-list-alt"></i> {{ $user->get('profile')['name'] }} ...</small></td>
								@else
								  <td>...</td>
								@endif
								<td><small>{{ $user->getCreatedAt()->format('Y-m-d H:i:s') }}</small></td>
								<td>
									<ul class="list-inline">
										<li><a class="btn btn-xs btn-success" href={{ route('users.show', array('id' => $user->getObjectId())) }}><i class="fa fa-eye"></i></a></li>
										<li><a class="btn btn-xs btn-primary" href={{ route('users.edit', array('id' => $user->getObjectId())) }}><i class="fa fa-pencil-square-o"></i></a></li>
										<li><button type="button" class="btn btn-xs btn-danger" data-toggle="modal" data-target="#deleteModal" data-id={{$user->getObjectId()}} data-whatever={{ route('users.destroy', array('id' => $user->getObjectId())) }}><i class="fa fa-trash-o"></i></button></li>
									</ul>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>

				@include('partials.deletemodal', ['model' => 'user', 'controller' => 'UsersController', 'id' => ''])

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
