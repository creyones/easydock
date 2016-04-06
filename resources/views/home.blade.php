@extends('app')

@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-3 col-md-2">
			@include('partials.sidebar', ['active' => 'home'])
		</div>
		<div class="col-sm-9 col-md-10">
			<!-- Main Content -->
			<div class="row">
				@if (Auth::user()->hasRole('owner') || Auth::user()->hasRole('admin'))
				<div class="col-sm-6"><div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">{{trans('views.users')}}</h3>
					</div>
					<div class="panel-body">
						<p class="lead"><i class="fa fa-users fa-2x"></i> <span class="text-success"> {{$users->count()}} </span> {{trans('models.users')}}</p>
					</div>
				</div></div>
				<div class="col-sm-6">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">{{trans('views.providers')}}</h3>
						</div>
						<div class="panel-body">
							<p class="lead"><i class="fa fa-eur fa-2x"></i> <span class="text-success"> {{$providers->count()}} </span> {{trans('models.providers')}}</p>
						</div>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">{{trans('views.ports')}}</h3>
						</div>
						<div class="panel-body">
							<p class="lead"><i class="fa fa-ship fa-2x"></i> <span class="text-success"> {{$ports->count()}} </span> {{trans('models.ports')}}</p>
						</div>
					</div>
				</div>
				@endif
				<div class="col-sm-6">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">{{trans('views.docks')}}</h3>
						</div>
						<div class="panel-body">
							<p class="lead"><i class="fa fa-anchor fa-2x"></i> <span class="text-success"> {{($docks ? $docks->count() : '0')}} </span> {{trans('models.docks')}}</p>
						</div>
					</div>
				</div>
				<div class="col-sm-6">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">{{trans('views.bookings')}}</h3>
						</div>
						<div class="panel-body">
							<p class="lead"><i class="fa fa-bookmark-o fa-2x"></i> <span class="text-success"> {{($bookings ? $bookings->count() : '0')}} </span> {{trans('models.bookings')}}</p>
						</div>
					</div>
				</div>
			</div>
			<!-- End Main Content -->
		</div>
	</div>
</div>
@endsection
