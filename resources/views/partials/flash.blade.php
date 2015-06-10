@if (Session::has('flash_message'))
<!-- Flash Message -->
<div class ="alert alert-success alert-flash {{ Session::has('flash_message_important') ? 'alert-important' : '' }}">
  @if (Session::has('flash_message_important'))
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  @endif
  {{ session('flash_message') }}
</div>
<!-- End Flash Message -->
@endif
