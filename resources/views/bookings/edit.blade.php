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
				@if (Auth::user()->hasRole('owner') || Auth::user()->hasRole('admin') || Auth::user()->hasRole('provider'))
				<div class="col-sm-12">
					<p class="lead"><i class="fa fa-edit fa-lg"></i> {{trans('views.edit_booking')}}</p></li>
					{!! Form::model($booking, ['method'=> 'PATCH', 'action' => ['BookingsController@update', $booking->getObjectId()], 'class' =>'form-horizontal','role'=>'form']) !!}
					<div class="form-group">
					  {!!Form::Label('created', trans('models.fields.created'), ['class'=>'col-sm-2 control-label']) !!}
					  <div class="col-sm-3">
					    {!! Form::text('created', $booking->getCreatedAt()->format('Y-m-d H:i:s'), ['class'=>'form-control', 'disabled' => 'disabled']) !!}
					  </div>
					  {!!Form::Label('updated', trans('models.fields.updated'), ['class'=>'col-sm-2 control-label']) !!}
					  <div class="col-sm-3">
					    {!! Form::text('updated', $booking->getUpdatedAt()->format('Y-m-d H:i:s'), ['class'=>'form-control', 'disabled' => 'disabled']) !!}
					  </div>
					</div>
					<div class="form-group">
					  {!!Form::Label('id', trans('models.fields.id'), ['class'=>'col-sm-2 control-label']) !!}
					  <div class="col-sm-8">
					    {!! Form::text('id', $booking->getObjectId(), ['class'=>'form-control', 'disabled' => 'disabled']) !!}
					  </div>
					</div>
					<hr/>
					<div class="form-group">
					  {!!Form::Label('user', trans('models.user'), ['class'=>'col-sm-2 control-label']) !!}
					  <div class="col-sm-8">
					    {!! Form::text('user', $user->get('username'), ['class'=>'form-control', 'disabled' => 'true']) !!}
					  </div>
					</div>
					<div class="form-group">
					  {!!Form::Label('email', trans('models.fields.email'), ['class'=>'col-sm-2 control-label']) !!}
					  <div class="col-sm-8">
					    {!! Form::text('email', $user->get('email'), ['class'=>'form-control', 'disabled' => 'true']) !!}
					  </div>
					</div>
					<hr/>
					<div class="form-group">
					  {!!Form::Label('port', trans('models.port'), ['class'=>'col-sm-2 control-label']) !!}
					  <div class="col-sm-8">
					    {!! Form::text('port', $booking->get('nombrePuerto'), ['class'=>'form-control', 'disabled' => 'true']) !!}
					  </div>
					</div>
					<div class="form-group">
					  {!!Form::Label('dock', trans('models.dock'), ['class'=>'col-sm-2 control-label']) !!}
					  <div class="col-sm-8">
					    {!! Form::text('dock', $dock->get('name'), ['class'=>'form-control', 'disabled' => 'true']) !!}
					  </div>
					</div>
					<div class="form-group">
					  {!!Form::Label('code', trans('models.fields.code'), ['class'=>'col-sm-2 control-label']) !!}
					  <div class="col-sm-8">
					    {!! Form::text('code', $dock->get('codigo'), ['class'=>'form-control', 'disabled' => 'true']) !!}
					  </div>
					</div>
					<hr/>
					<div class="form-group">
					  <div class="col-sm-2 control-label"><p>{{ trans('models.fields.available') }}</p></div>
					  <div class="col-sm-4">
					    {!! Form::Label('from', trans('models.fields.from'), ['class'=>'control-label sr-only']) !!}
					    {!! Form::text('from', $booking->get('fechaInicio')->format('d/m/Y'), ['class'=>'form-control', 'placeholder' => trans('models.fields.from') ]) !!}
					  </div>
					  <div class="col-sm-4">
					    {!! Form::Label('until', trans('models.fields.until'), ['class'=>'control-label sr-only']) !!}
					    {!! Form::text('until', $booking->get('fechaFinal')->format('d/m/Y'), ['class'=>'form-control', 'placeholder' => trans('models.fields.until') ]) !!}
					  </div>
					</div>
					<div class="form-group">
					  {!!Form::Label('price', trans('models.fields.price_total') . ' (€)', ['class'=>'col-sm-2 control-label']) !!}
					  <div class="col-sm-4">
					    {!! Form::text('price', $booking->get('precioTotal'), ['class'=>'form-control']) !!}
					  </div>
					</div>
					<hr/>
					<div class="form-group">
					  {!!Form::Label('confirmed', trans('models.fields.confirmed'), ['class'=>'col-sm-2 control-label']) !!}
					  <div class="col-sm-4">
					    {!! Form::select('confirmed', [trans('messages.no'), trans('messages.yes')], ($booking->get('confirmado') ? 1 : 0), ['class'=>'form-control']) !!}
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
					<p class="lead">{{trans('messages.access-forbidden')}}</p>
				</div>
				@endif
				<!-- End Main Content -->
			</div>
		</div>
	</div>
</div>
@include('partials.daterange', array('from' => '#from', "until" => "#until", "past" => false))
@endsection
