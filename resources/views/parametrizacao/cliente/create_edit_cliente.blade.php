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
      {{ Form::open(['route' => 'cliente.store','method'=>'POST', 'class' => 'form']) }}
      @endif

      <div class="panel-body" style="border-bottom: 1px solid #ccc; ">

        <div class="row" style="margin-bottom: 15px">

          <div class="form-horizontal">

            <div class="col-sm-3">
              {{Form::label('nome', 'Nome do Cliente')}}
              {{Form::text('nome', null, ['placeholder' => 'Nome do Cliente', 'class' => 'form-control'])}}
            </div>

            <div class="col-sm-3">
              {{Form::label('telefone', 'Telefone')}}
              {{Form::text('telefone', null, ['placeholder' => 'Telefone', 'class' => 'form-control'])}}
            </div>

            <div class="col-sm-3">
              {{Form::label('endereco', 'Endereço')}}
              {{Form::text('endereco', null, ['placeholder' => 'Endereço', 'class' => 'form-control'])}}
            </div>

            <div class="col-sm-3">
              {{Form::label('email', 'Email')}}
              {{Form::text('email', null, ['placeholder' => 'Email', 'class' => 'form-control'])}}
            </div>
          </div>

        </div>

        <div class="row" style="margin-bottom: 15px">

          <div class="col-sm-3">
            {{Form::label('nuit', 'NUIT')}}
            {{Form::text('nuit', null, ['placeholder' => 'NUIT', 'class' => 'form-control'])}}
          </div>

          <div class="col-sm-3">
            <div class="radio-inline" style="margin: 30px">
              {{Form::radio('activo', '1')}} Activo
            </div>
            <div class="radio-inline">
              {{Form::radio('activo', '0')}} Inactivo
            </div>
          </div>

        </div>

      </div>

      <div class="panel-footer">

        <div class="row">
          <div class="col-md-6">

            @if(isset($cliente))

            {{Form::hidden('cliente_id', $cliente->id)}} <!-- Para ser capturado no FormReques para ignorar a validacao uniq para o campo email durante o update -->

            {{ Form::button('Actualizar', ['type'=>'submit', 'class'=>'btn btn-primary']) }}

            @else

            {{ Form::button('Salvar', ['type'=>'submit', 'class'=>'btn btn-primary']) }}
            {{ Form::reset('Limpar', ['class'=>'btn btn-default']) }}

            @endif

          </div>
          <div class="col-md-6">

            <a href="{{route('cliente.index')}}" class="btn btn-primary pull-right">Cancelar</a>

          </div>
        </div>



      </div>





      {{Form::close()}}
    </section>
  </div>
</div>

@endsection
