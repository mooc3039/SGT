@extends('layouts.master')
@section('content')
<div class="row">
  <div class="col-lg-12">
    <h3 class="page-header"><i class="fa fa-file-text-o"></i>Parametrização</h3>
    <ol class="breadcrumb">
      <li><i class="fa fa-home"></i><a href="#">Home</a></li>
      <li><i class="icon_document_alt"></i>Usuários</li>
      <li><i class="fa fa-file-text-o"></i>Gerenciar Usuários</li>
    </ol>
  </div>
</div>

<div class="row"> 
  <div class="col-lg-12">
    <section class="panel panel-default"> 
      @if(isset($usuario))

      {{ Form::model($usuario, ['route' => ['usuarios.update', $usuario->id], 'method' => 'PUT', 'class'=>'form-horizontal']) }}

      @else

      {{ Form::open(['route' => 'usuarios.store','method'=>'POST']) }}

      @endif

      <div class="panel-body" style="border-bottom: 1px solid #ccc; ">
        <div class="form-group">
          <div class="col-md-3">
            {{ Form::label('role_id', 'Tipo de Usúario', ['class'=>'control-label']) }}
            <div class="input-group">
              {{ Form::select('role_id', [''=>'Tipo de Usúario',] + $roles, null, ['class'=>'form-control select_search']) }}
              <div class="input-group-addon">
                <span class="fa fa-plus"></span>
              </div>
            </div>
          </div>

          <div class="col-sm-3">
            {{Form::label('name', 'Nome Completo')}}
            {{Form::text('name', null, ['placeholder' => 'Nome Completo', 'class' => 'form-control'])}}
          </div>          

          <div class="col-sm-3">
            {{Form::label('email', 'Email')}}
            {{Form::text('email', null, ['placeholder' => 'Email', 'class' => 'form-control'])}}
          </div>


          <div class="col-sm-3">
            {{Form::label('Telefone', 'Telefone')}}
            {{Form::text('telefone', null, ['placeholder' => 'Telefone', 'class' => 'form-control'])}}
          </div>

          <div class="col-sm-3">
            {{Form::label('endereco', 'Endereço')}}
            {{Form::text('endereco', null, ['placeholder' => 'Endereço', 'class' => 'form-control'])}}
          </div>

          <div class="col-sm-3">
            {{Form::label('occupation', 'Ocupação')}}
            {{Form::text('occupation', null, ['placeholder' => 'Ocupação', 'class' => 'form-control'])}}
          </div>

          <div class="col-md-3" >
            <div class="radio-inline" style="margin: 25px">
              <input type="radio" name="active" value="1" id="activo" 
              @if(isset($usuario))
              @if($usuario->active == 1)
              {{'checked'}}
              @endif
              @endif><label for="activo">Activo</label>
            </div>
            <div class="radio-inline">
              <input type="radio" name="active" value="0" id="inactivo" 
              @if(isset($usuario))
              @if($usuario->active == 0)
              {{'checked'}}
              @endif
              @endif><label for="inactivo">Inactivo</label>
            </div>
          </div>

        </div>
      </div>

    </section>
  </div>
</div>
<div class="row">
  <div class="col-sm-12">
    <div class="profile-widget profile-widget-info">
      <div class="panel-body">
        <div class="col-sm-12">
          <h6 style="text-align: center">
            <span><i class="fa fa-user"></i> LOGIN </span>
          </h6>
        </div>
      </div>
      <section class="panel panel-default">

        <div class="panel-body bio-graph-info" style="border-bottom: 1px solid #ccc; ">
          @if(!isset($usuario))
          <div class="row form-group" style="margin-bottom: 15px">

            {{Form::label('username', 'Usuário', ['class'=>'col-sm-2 col-sm-offset-2 control-label'])}}
            <div class="col-sm-4">
              {{Form::text('username', null, ['placeholder' => 'Usuário', 'class' => 'form-control '])}}
            </div>
          </div>
          <div class="row form-group" style="margin-bottom: 15px">

            {{Form::label('password', 'Nova Senha', ['class'=>'col-sm-2 col-sm-offset-2 control-label'])}}
            <div class="col-sm-4">
              {{Form::password('password', ['placeholder' => 'Senha', 'class' => 'form-control'])}}
            </div>
          </div>
          <div class="row form-group" style="margin-bottom: 15px">

            {{Form::label('password_confirmation', 'Confirmar Senha', ['class'=>'col-sm-2 col-sm-offset-2 control-label'])}}
            <div class="col-sm-4">
              {{Form::password('password_confirmation', ['placeholder' => 'Confirmar Senha', 'class' => 'form-control'])}}
            </div>

          </div>
          @endif
        </div>

      </section>
    </div>
  </div>
</div>


<div class="row">
  <div class="col-md-6">

    @if(isset($usuario))

    {{Form::hidden('usuario_id', $usuario->id)}}

    {{Form::submit('Actualizar', ['class'=>'btn btn-primary submit_iten'])}}

    @else

    {{Form::submit('Salvar', ['class'=>'btn btn-primary submit_iten'])}}
    {{Form::reset('Limpar', ['class'=>'btn btn-default'])}}

    @endif

  </div>
  <div class="col-md-6">

    <a href="{{route('usuarios.index')}}" class="btn btn-warning pull-right"> Cancelar</a>

  </div>
</div>

{!! Form::close() !!}

@endsection
@section('script')
<script type="text/javascript">

  $('.submit_iten').on('click',function(){
    $(".wait").css("display", "block");
  });

</script>
@endsection
