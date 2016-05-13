@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-3 col-md-2">
			@include('partials.sidebar', array('active' => 'docks'))
		</div>
		<div class="col-sm-9 col-md-10">
			<!-- Main Content -->
			<div class="row">
				@include('errors.list')
				@if (Auth::user()->hasRole('owner') || Auth::user()->hasRole('admin') || Auth::user()->hasRole('provider'))
				<div class="col-sm-12">
					<p class="lead"><i class="fa fa-plus-square fa-lg"></i> {{trans('views.create_dock')}}</p></li>
					{!! Form::open(['action' => 'DocksController@store', 'class' => 'form-horizontal', 'role'=>'form', 'files' => true]) !!}
					@if (Auth::user()->hasRole('provider'))
					<div class="form-group">
						{!!Form::Label('provider', trans('models.provider'), ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-8">
							{!! Form::text('provider', $provider->get('username'), ['class'=>'form-control', 'disabled' => 'disabled']) !!}
						</div>
					</div>
					<div class="form-group">
						{!!Form::Label('port', trans('models.port'), ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-8">
							{!! Form::text('port', $port->get('name'), ['class'=>'form-control', 'disabled' => 'disabled']) !!}
						</div>
					</div>
					@else
					<div class="form-group">
						{!!Form::Label('provider', trans('models.provider'), ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-8">
							{!! Form::select('provider', $providers, '', ['class'=>'form-control']) !!}
						</div>
					</div>
					<div class="form-group">
						{!!Form::Label('port', trans('models.port'), ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-8">
							{!! Form::select('port', $ports, '', ['class'=>'form-control']) !!}
						</div>
					</div>
					@endif
					<hr/>
					<div class="form-group">
						{!!Form::Label('name', trans('models.fields.code'), ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-8">
							{!! Form::text('code', '', ['class'=>'form-control']) !!}
						</div>
					</div>
					<div class="form-group">
						{!!Form::Label('name', trans('models.fields.name'), ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-8">
							{!! Form::text('name', '', ['class'=>'form-control']) !!}
						</div>
					</div>
					<div class="form-group">
						{!!Form::Label('details', trans('models.fields.details'), ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-8">
							{!! Form::textarea('details', '', ['class'=>'form-control']) !!}
						</div>
					</div>
					<hr/>
					@if (false)
					<div class="form-group">
						{!!Form::Label('image', trans('models.fields.image'), ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-8">
							<input id="image" name="image" type="file" class="file" data-show-preview="false">
						</div>
					</div>
					<hr/>
					@endif
					<div class="form-group">
						{!!Form::Label('price', trans('models.fields.price') . " (". trans('messages.price-per-day') .")", ['class'=>'col-sm-2 control-label']) !!}
						<div class="col-sm-8">
							{!! Form::text('price', '', ['class'=>'form-control']) !!}
						</div>
					</div>
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
						<label class="col-sm-2 control-label">
							{{trans("models.fields.services")}}
						</label>
						<div class="col-sm-8">
							<div class="alert alert-info">{{trans('messages.docks.default-services')}}</div>
							<label for="water" class="col-sm-3 control-label control-label-left">
								{!!Form::checkbox('water', 1, null, ['disabled' => 'disabled']) !!} {{trans('models.fields.water')}}
							</label>
							<label for="power" class="col-sm-3 control-label control-label-left">
								{!!Form::checkbox('power', 1, null, ['disabled' => 'disabled']) !!} {{trans('models.fields.power')}}
							</label>
							<label for="gas" class="col-sm-3 control-label control-label-left">
								{!!Form::checkbox('gas', 1, null, ['disabled' => 'disabled']) !!} {{trans('models.fields.gas')}}
							</label>
							<label for="naval" class="col-sm-3 control-label control-label-left">
								{!!Form::checkbox('naval', 1, null, ['disabled' => 'disabled']) !!} {{trans('models.fields.naval')}}
							</label>
							<label for="radio" class="col-sm-3 control-label control-label-left">
								{!!Form::checkbox('radio', 1, null, ['disabled' => 'disabled']) !!} {{trans('models.fields.radio')}}
							</label>
							<label for="restaurant" class="col-sm-3 control-label control-label-left">
								{!!Form::checkbox('restaurant', 1, null, ['disabled' => 'disabled']) !!} {{trans('models.fields.restaurant')}}
							</label>
							<label for="locker" class="col-sm-3 control-label control-label-left">
								{!!Form::checkbox('locker', 1, null, ['disabled' => 'disabled']) !!} {{trans('models.fields.locker')}}
							</label>
							<label for="lockerroom" class="col-sm-3 control-label control-label-left">
								{!!Form::checkbox('lockerroom', 1, null, ['disabled' => 'disabled']) !!} {{trans('models.fields.locker-room')}}
							</label>
							<label for="accomodation" class="col-sm-3 control-label control-label-left">
								{!!Form::checkbox('accomodation', 1, null, ['disabled' => 'disabled']) !!} {{trans('models.fields.accomodation')}}
							</label>
							<label for="surveillance" class="col-sm-3 control-label control-label-left">
								{!!Form::checkbox('surveillance', 1, null, ['disabled' => 'disabled']) !!} {{trans('models.fields.surveillance')}}
							</label>
							<label for="wifi" class="col-sm-3 control-label control-label-left">
								{!!Form::checkbox('wifi', 1, null, ['disabled' => 'disabled']) !!} {{trans('models.fields.wifi')}}
							</label>
						</div>
					</div>
					<hr/>
					<div class="form-group">
						<div class="col-sm-8 col-sm-offset-2">
							{!!Form::submit(trans('actions.save'),['class' => 'btn btn-success']) !!}
							<a href={{ route('docks.index') }} class="btn btn-default">{{ trans('actions.cancel') }}</a>
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
@include('partials.daterange', array('from' => '#from', "until" => "#until", "past" => false))
@include('partials.fileinput', array('item' => 'image'))
@endsection
