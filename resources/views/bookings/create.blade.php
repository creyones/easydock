@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-3 col-md-2">
			@include('partials.sidebar', array('active' => 'bookings'))
		</div>
		<div class="col-sm-9 col-md-10">
			<!-- Main Content -->
			<div class="row">
				@include('errors.list')
				@if (Auth::user()->hasRole('owner') || Auth::user()->hasRole('admin'))
				<div class="col-sm-12">
					<p class="lead"><i class="fa fa-plus-square fa-lg"></i> {{trans('views.create_booking')}}</p></li>
					{!! Form::open(['action' => 'BookingsController@store', 'class' => 'form-horizontal', 'role'=>'form', 'files' => true]) !!}
					<div class="form-group">
						{!!Form::Label('users', trans('models.user'), ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-8">
							{!! Form::select('users', $users, '', ['class'=>'form-control']) !!}
						</div>
					</div>
					<div class="form-group">
						{!!Form::Label('bookings', trans('models.dock'), ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-8">
							{!! Form::select('docks', $docks, '', ['class'=>'form-control']) !!}
						</div>
					</div>
					<hr/>
					<div class="form-group">
						<div class="col-sm-2 control-label"><p>{{ trans('models.fields.available') }}</p></div>
						<div class="col-sm-4">
							{!! Form::Label('from', trans('models.fields.from'), ['class'=>'control-label sr-only']) !!}
							{!! Form::text('from', '', ['class'=>'form-control', 'placeholder' => trans('models.fields.from') ]) !!}
						</div>
						<div class="col-sm-4">
							{!! Form::Label('until', trans('models.fields.until'), ['class'=>'control-label sr-only']) !!}
							{!! Form::text('until', '', ['class'=>'form-control', 'placeholder' => trans('models.fields.until') ]) !!}
						</div>
					</div>
					<hr/>
					<div class="form-group">
						{!!Form::Label('beam', trans('models.fields.beam'), ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-8">
							{!! Form::text('beam', '', ['class'=>'form-control']) !!}
						</div>
					</div>
					<div class="form-group">
						{!!Form::Label('length', trans('models.fields.length'), ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-8">
							{!! Form::text('length', '', ['class'=>'form-control']) !!}
						</div>
					</div>
					<div class="form-group">
						{!!Form::Label('draft', trans('models.fields.draft'), ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-8">
							{!! Form::text('draft', '', ['class'=>'form-control']) !!}
						</div>
					</div>
					<hr/>
					<div class="form-group">
						<div class="col-sm-8 col-sm-offset-2">
							{!!Form::submit(trans('actions.save'),['class' => 'btn btn-success']) !!}
							<a href={{ route('bookings.index') }} class="btn btn-default">{{ trans('actions.cancel') }}</a>
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
@include('partials.daterange')
<script type="text/javascript">
	$("#image").fileinput({
		uploadUrl: "{{url("/")}}/tmp/", // server upload action
    uploadAsync: true,
		minFileCount: 1,
		maxFileSize: 800,
		allowedFileExtensions: ["jpg", "gif", "png"]
	});
</script>
@endsection
