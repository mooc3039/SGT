@extends('layouts.master')
@section('content')
<div class="row">
  <div class="col-lg-12">
    <h3 class="page-header"><i class="fa fa-file-text-o"></i>Alterar Login</h3>
    <ol class="breadcrumb">
      <li><i class="fa fa-home"></i><a href="#">Home</a></li>
      <li><i class="icon_document_alt"></i>Usuários</li>
      <li><i class="fa fa-file-text-o"></i>Gerenciar Usuários</li>
    </ol>
  </div>
</div>

<div class="row"> 
  <div class="col-lg-12">
    <div class="profile-widget profile-widget-info">
      <div class="panel-body">
        <div class="col-sm-2">
          <h6><i class="fa fa-file"></i> {{$usuario->role->nome}}</h6>
        </div>
        <div class="col-sm-4 follow-info">
          <h6>
            <span><i class="fa fa-user"></i> {{$usuario->name}}</span>
          </h6>
        </div>

      </div>
      <section class="panel panel-default">

        {{ Form::model($usuario, ['route' => ['alterar_senha_usuario', $usuario->id], 'method' => 'POST', 'class'=>'form-horizontal']) }}

        <div class="panel-body bio-graph-info" style="border-bottom: 1px solid #ccc; ">
          <div class="row form-group" style="margin-bottom: 15px">

            {{Form::label('username', 'Usuário', ['class'=>'col-sm-2 col-sm-offset-2 control-label'])}}
            <div class="col-sm-4">
              {{Form::text('username', null, ['placeholder' => 'Usuário', 'class' => 'form-control '])}}
            </div>
          </div>
          <div class="row form-group" style="margin-bottom: 15px">

            {{Form::label('senha', 'Nova Senha', ['class'=>'col-sm-2 col-sm-offset-2 control-label'])}}
            <div class="col-sm-4">
              {{Form::password('senha', ['placeholder' => 'Senha', 'class' => 'form-control'])}}
            </div>
          </div>
          <div class="row form-group" style="margin-bottom: 15px">

            {{Form::label('senha_confirmation', 'Confirmar Senha', ['class'=>'col-sm-2 col-sm-offset-2 control-label'])}}
            <div class="col-sm-4">
              {{Form::password('senha_confirmation', ['placeholder' => 'Confirmar Senha', 'class' => 'form-control'])}}
            </div>

          </div>
        </div>

        <div class="panel-footer">
          <div class="row">
            <div class="col-md-6">

              {{Form::submit('Actualizar', ['class'=>'btn btn-primary submit_iten'])}}
              {{Form::reset('Limpar', ['class'=>'btn btn-default'])}}

            </div>
            <div class="col-md-6">

              <a href="{{route('usuarios.index')}}" class="btn btn-warning pull-right"> Cancelar</a>

            </div>
          </div>
        </div>

        {!! Form::close() !!}
      </section>
  </div>
  </div>
</div>

@endsection
@section('script')
<script type="text/javascript">

  $('.submit_iten').on('click',function(){
    $(".wait").css("display", "block");
  });

</script>
@endsection
