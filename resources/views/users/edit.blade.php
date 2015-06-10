@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-3 col-md-2">
			@include('partials.sidebar', ['active' => 'users'])
		</div>
		<div class="col-sm-9 col-md-10">
			<!-- Main Content -->
			<div class="row">
				@include('errors.list')
				@if (Auth::user()->hasRole('owner') || Auth::user()->hasRole('admin'))
				<div class="col-sm-12">
					<p class="lead"><i class="fa fa-edit fa-lg"></i> {{trans('views.edit_user')}}</p></li>
					{!! Form::model($user, ['method'=> 'PATCH', 'action' => ['UsersController@update', $user->getObjectId()], 'class' => 'form-horizontal','role'=>'form']) !!}
					<div class="form-group">
						{!!Form::Label('created', trans('models.fields.created'), ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-8">
							{!! Form::text('created', $user->getCreatedAt()->format('Y-m-d H:i:s'), ['class'=>'form-control', 'disabled' => 'disabled']) !!}
						</div>
					</div>
					<div class="form-group">
						{!!Form::Label('updated', trans('models.fields.updated'), ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-8">
							{!! Form::text('updated', $user->getCreatedAt()->format('Y-m-d H:i:s'), ['class'=>'form-control', 'disabled' => 'disabled']) !!}
						</div>
					</div>
					<div class="form-group">
						{!!Form::Label('id', trans('models.fields.id'), ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-8">
							{!! Form::text('id', $user->getObjectId(), ['class'=>'form-control', 'disabled' => 'disabled']) !!}
						</div>
					</div>
					<hr/>
					<div class="form-group">
						{!!Form::Label('username', trans('models.fields.username'), ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-8">
							{!! Form::text('username', $user->get('username'), ['class'=>'form-control']) !!}
						</div>
					</div>
					<div class="form-group">
						{!!Form::Label('email', trans('models.fields.email'), ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-8">
							{!! Form::email('email', $user->get('email'), ['class'=>'form-control']) !!}
						</div>
					</div>
					<hr/>
					<div class="form-group">
						{!!Form::Label('beam', trans('models.fields.beam'), ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-4">
							{!! Form::text('beam', $user->get('manga'), ['class'=>'form-control']) !!}
						</div>
					</div>
					<div class="form-group">
						{!!Form::Label('length', trans('models.fields.length'), ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-4">
							{!! Form::text('length', $user->get('eslora'), ['class'=>'form-control']) !!}
						</div>
					</div>
					<div class="form-group">
						{!!Form::Label('draft', trans('models.fields.draft'), ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-4">
							{!! Form::text('draft', $user->get('calado'), ['class'=>'form-control']) !!}
						</div>
					</div>
					<hr/>
					<div class="form-group">
						<div class="col-sm-8 col-sm-offset-2">
							{!!Form::submit(trans('actions.save'),['class' => 'btn btn-success']) !!}
							<a href={{route('users.index')}} class="btn btn-default">{{trans('actions.cancel')}}</a>
						</div>
					</div>
					{!! Form::close() !!}
				</div>

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
@endsection
