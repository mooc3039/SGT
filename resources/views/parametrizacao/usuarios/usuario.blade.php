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
      <header class="panel-heading">
        Parametrizar Usuários do Sistema
      </header>
      @if(isset($usuario))

      {{ Form::model($usuario, ['route' => ['usuarios.update', $usuario->id], 'method' => 'PUT']) }}

      @else

      {{ Form::open(['route' => 'usuarios.store','method'=>'POST']) }}

      @endif
        
        <div class="panel-body" style="border-bottom: 1px solid #ccc; ">
          <div class="form-group">

            <div class="col-sm-3">
                  <label for="role_id">Função/Papel</label>
                  <div class="input-group">
                    <select class="form-control" name="role_id" >
                          <option selected disabled>Selecione o Papel</option>
                      @foreach($papel as $papeis) 
                          <option value="{{$papeis->id}}">{{$papeis->nome}}</option>
                      @endforeach
                    </select>
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
              {{Form::label('occupation', 'Ocupação')}}
              {{Form::text('occupation', null, ['placeholder' => 'Ocupação', 'class' => 'form-control'])}}
            </div>
            
            <div class="col-sm-3">
              {{Form::label('username', 'Usuário')}}
              {{Form::text('username', null, ['placeholder' => 'Usuário', 'class' => 'form-control'])}}
            </div>

            <div class="col-sm-3">
              {{Form::label('password', 'Password')}}
              {{Form::text('password', null, ['placeholder' => 'Password', 'class' => 'form-control'])}}
            </div>
            <div class="col-sm-3">
              {{Form::label('password_confirmation', 'Confirmar Password')}}
              {{Form::text('password_confirmation', null, ['placeholder' => 'Confirmar Password', 'class' => 'form-control'])}}
            </div>
            
            <div class="col-md-3" >
              <div class="radio-inline" style="margin: 25px">
                <input type="radio" name="active" value="1" id="activo"><label for="activo">Activo</label>
              </div>
              <div class="radio-inline">
                <input type="radio" name="active" value="1" id="inactivo"><label for="inactivo">Inactivo</label>
              </div>
            </div>

          </div>
        </div>

        <div class="panel-footer">
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
      </div>

      {!! Form::close() !!}
    </section>
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
