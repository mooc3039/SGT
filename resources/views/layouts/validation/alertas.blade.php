@if(count($errors) > 0)
@foreach($errors->all() as $error)
<div class="alert alert-danger alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Erro! </strong>{{$error}}
</div>
@endforeach
@endif

@if(session('success'))
<div class="alert alert-success alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Sucesso! </strong>{{session('success')}}
</div>
@endif

@if(session('$error'))
<div class="alert alert-danger alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
  <strong>Erro! </strong>{{session('error')}}
</div>
@endif