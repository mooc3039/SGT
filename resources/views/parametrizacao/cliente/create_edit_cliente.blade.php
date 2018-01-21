@extends('layouts.master')
@section('content')
<div class="row">
  <div class="col-lg-12">
    <h3 class="page-header"><i class="fa fa-file-text-o"></i>Parametrização</h3>
    <ol class="breadcrumb">
      <li><i class="fa fa-home"></i><a href="#">Home</a></li>
      <li><i class="icon_document_alt"></i>Clientes</li>
      <li><i class="fa fa-file-text-o"></i>Gerenciar Clientes</li>
    </ol>
  </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <section class="panel panel-default">
      <header class="panel-heading">
        Parametrizar Cliente
      </header>

      @if(isset($cliente))
      {{ Form::model($cliente, ['route' => ['cliente.update', $cliente->id], 'method' => 'PUT', 'class' => 'form']) }}

      @else
      {{ Form::open(['route' => 'cliente.store', 'class' => 'form']) }}
      @endif

      <div class="panel-body" style="border-bottom: 1px solid #ccc; ">
        <div class="form-group">

          <div class="col-sm-3">
            {{Form::label('nome', 'Nome do Cliente')}}
            <div class="input-group">
              {{Form::text('nome', null, ['placeholder' => 'Nome do Cliente', 'class' => 'form-control'])}}
              <div class="input-group-addon">
                <span class="fa fa-plus"></span>
              </div>
            </div>
          </div>

          <div class="col-sm-3">
            {{Form::label('telefone', 'Telefone')}}
            <div class="input-group">
              {{Form::text('telefone', null, ['placeholder' => 'Telefone', 'class' => 'form-control'])}}
              <div class="input-group-addon">
                <span class="fa fa-plus"></span>
              </div>
            </div>
          </div>

          <div class="col-sm-3">
            {{Form::label('endereco', 'Endereço')}}
            <div class="input-group">
              {{Form::text('endereco', null, ['placeholder' => 'Endereço', 'class' => 'form-control'])}}
              <div class="input-group-addon">
                <span class="fa fa-plus"></span>
              </div>
            </div>
          </div>

          <div class="col-sm-3">
            {{Form::label('email', 'Email')}}
            <div class="input-group">
              {{Form::text('email', null, ['placeholder' => 'Email', 'class' => 'form-control'])}}
              <div class="input-group-addon">
                <span class="fa fa-plus"></span>
              </div>
            </div>
          </div>

          <div class="col-sm-3">
            {{Form::label('nuit', 'NUIT')}}
            <div class="input-group">
              {{Form::text('nuit', null, ['placeholder' => 'NUIT', 'class' => 'form-control'])}}
              <div class="input-group-addon">
                <span class="fa fa-plus"></span>
              </div>
            </div>
          </div>


        </div>
      </div>


      <div class="panel-footer">

        @if(!isset($cliente))

        {{ Form::button('Salvar', ['type'=>'submit', 'class'=>'btn btn-success']) }}

        @else

        {{ Form::button('Actualizar', ['type'=>'submit', 'class'=>'btn btn-success']) }}

        @endif

        {{ Form::reset('Limpar', ['class' => 'btn btn-warning']) }}

        <a href="{{route('cliente.index')}}" class="btn btn-primary">Cancelar</a>

      </div>





      {{Form::close()}}
    </section>
  </div>
</div>

@endsection
