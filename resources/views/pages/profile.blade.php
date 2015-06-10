@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-3 col-md-2">
			@include('partials.sidebar', array('active' => 'users'))
		</div>
		<div class="col-sm-9 col-md-10">
			<!-- Main Content -->
			<div class="row">
        @include('partials.flash')
				@include('errors.list')
				<div class="col-sm-12">
					<p class="lead"><i class="fa fa-edit fa-lg"></i> {{trans('views.profile')}}</p></li>
          {!! Form::model($user, ['method'=> 'PATCH', 'action' => ['ProfileController@update'], 'class' =>'form-horizontal','role'=>'form']) !!}
					<div class="form-group">
						{!!Form::Label('username', trans('models.fields.username'), ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-8">
							{!! Form::text('username', null, ['class'=>'form-control', 'disabled' => 'true']) !!}
						</div>
					</div>
					<div class="form-group">
						{!!Form::Label('email', trans('models.fields.email'), ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-8">
							{!! Form::email('email', null, ['class'=>'form-control', 'disabled' => 'true']) !!}
						</div>
					</div>
					<div class="form-group">
						{!!Form::Label('password', trans('models.fields.password'), ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-8">
							{!! Form::text('password', '*******', ['class'=>'form-control', 'disabled' => 'true']) !!}
						</div>
					</div>
					<hr/>
					<div class="form-group">
						{!!Form::Label('firstname', trans('models.fields.firstname'), ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-8">
							{!! Form::text('firstname', null, ['class'=>'form-control']) !!}
						</div>
					</div>
					<div class="form-group">
						{!!Form::Label('lastname', trans('models.fields.lastname'), ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-8">
							{!! Form::text('lastname', null, ['class'=>'form-control']) !!}
						</div>
					</div>
					<div class="form-group">
						{!!Form::Label('phone', trans('models.fields.phone'), ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-8">
							{!! Form::text('phone', null, ['class'=>'form-control']) !!}
						</div>
					</div>
					<div class="form-group">
						{!!Form::Label('mobile', trans('models.fields.mobile'), ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-8">
							{!! Form::text('mobile', null, ['class'=>'form-control']) !!}
						</div>
					</div>
					<div class="form-group">
						{!!Form::Label('address', trans('models.fields.address'), ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-8">
							{!! Form::textarea('address', null, ['class'=>'form-control']) !!}
						</div>
					</div>
					<div class="form-group">
						{!!Form::Label('city', trans('models.fields.city'), ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-8">
							{!! Form::text('city', null, ['class'=>'form-control']) !!}
						</div>
					</div>
					<div class="form-group">
						{!!Form::Label('postalcode', trans('models.fields.postalcode'), ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-8">
							{!! Form::text('postalcode', null, ['class'=>'form-control']) !!}
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-8 col-sm-offset-2">
							{!!Form::submit(trans('actions.save'),['class' => 'btn btn-success']) !!}
							<a href={{ route('home') }} class="btn btn-default">{{ trans('actions.cancel') }}</a>
						</div>
					</div>
					{!! Form::close() !!}
				</div>
				<!-- End Main Content -->
			</div>
		</div>
	</div>
</div>
@endsection
