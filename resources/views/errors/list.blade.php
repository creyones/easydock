@if ($errors->any())
  <hr/>
  <ul class="alert alert-danger list-unstyled">
    @foreach ($errors->all() as $error)
      <li>{{$error}}</li>
    @endforeach
  </ul>
@endif
