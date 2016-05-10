<!-- Navigation Sidebar -->
<div class="list-group">
  <a href={{route('home')}} class="list-group-item {{ $active === 'home' ? 'active' : '' }}"><i class="fa fa-tachometer"></i> {{trans('views.dashboard')}}</a>
  <a href={{route('profile')}} class="list-group-item {{ $active === 'profile' ? 'active' : '' }}"><i class="fa fa-user"></i> {{trans('views.profile')}}</a>
  @if (Auth::user()->hasRole('owner') || Auth::user()->hasRole('admin'))
    <a href={{route('users.index')}} class="list-group-item {{ $active === 'users' ? 'active' : '' }}"><i class="fa fa-users"></i> {{trans('views.users')}}</a>
    <a href={{route('providers.index')}} class="list-group-item {{ $active === 'providers' ? 'active' : '' }}"><i class="fa fa-building"></i> {{trans('views.providers')}}</a>
    <a href={{route('ports.index')}} class="list-group-item {{ $active === 'ports' ? 'active' : '' }}"><i class="fa fa-ship"></i> {{trans('views.ports')}}</a>
  @endif
  <a href={{route('docks.index')}} class="list-group-item {{ $active === 'docks' ? 'active' : '' }}"><i class="fa fa-anchor"></i> {{trans('views.docks')}}</a>
  <a href={{route('bookings.index')}} class="list-group-item {{ $active === 'bookings' ? 'active' : '' }}"><i class="fa fa-bookmark-o"></i> {{trans('views.bookings')}}</a>
</div>
<!-- End Navigation Sidebar -->
