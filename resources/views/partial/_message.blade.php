@if(Session::has('success'))
  <div class="alert alert-info">
    <a class="close" data-dismiss="alert">×</a>
    <strong>{!!Session::get('success')!!}</strong>
  </div>
@endif

@if(Session::has('error'))
  <div class="alert alert-danger">
    <a class="close" data-dismiss="alert">×</a>
    <strong>{!!Session::get('error')!!}</strong>
  </div>
@endif