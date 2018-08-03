@extends('layouts.master')
@section('content')
  <div class="row">
    <div class="col-lg-12">
      <h3 class="page-header"><i class="fa fa-file-text-o"></i>Parametrização do Tipo Cliente</h3>
      <ol class="breadcrumb">
        <li><i class="fa fa-home"></i><a href="#">Home</a></li>
        <li><i class="icon_document_alt"></i>Clientes</li>
Clientes      </ol>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-12">
      <section class="panel panel-default">

        @if(isset($tipo_cliente))
          {{ Form::model($tipo_cliente, ['route' => ['tipo_cliente.update', $tipo_cliente->id], 'method' => 'PUT', 'class' => 'form']) }}

        @else
          {{ Form::open(['route' => 'tipo_cliente.store','method'=>'POST', 'class' => 'form']) }}
        @endif

        <div class="panel-body" style="border-bottom: 1px solid #ccc; ">

          <div class="row" style="margin-bottom: 15px">
            <div class="form-horizontal">

              <div class="col-sm-4">
                {{Form::label('tipo_cliente', 'Tipo de Cliente')}}
                {{Form::text('tipo_cliente', null, ['placeholder' => 'Tipo de Cliente', 'class' => 'form-control'])}}
              </div>
              <div class="col-sm-4">
                {{Form::label('acronimo', 'Acrónimo')}}
                {{Form::text('acronimo', null, ['placeholder' => 'Acrónimo', 'class' => 'form-control'])}}
              </div>

            </div>

          </div>

          <div class="row" style="margin-bottom: 15px">

            <div class="form-horizontal">

              <div class="col-sm-4">
                {{Form::label('descricao', 'Descrição')}}
                {{Form::textarea('descricao', null, ['placeholder' => 'Descrição', 'class' => 'form-control'])}}
              </div>

            </div>

          </div>


        </div>

        <div class="panel-footer">

          <div class="row">
            <div class="col-md-6">

              @if(isset($tipo_cliente))

                {{Form::hidden('tipo_cliente_id', $tipo_cliente->id)}} <!-- Para ser capturado no FormReques para ignorar a validacao uniq para o campo email durante o update -->

                {{ Form::button('Actualizar', ['type'=>'submit', 'class'=>'btn btn-primary']) }}

              @else

                {{ Form::button('Salvar', ['type'=>'submit', 'class'=>'btn btn-primary']) }}
                {{ Form::reset('Limpar', ['class'=>'btn btn-default']) }}

              @endif

            </div>
            <div class="col-md-6">

              <a href="{{route('tipo_cliente.index')}}" class="btn btn-primary pull-right">Cancelar</a>

            </div>
          </div>



        </div>





        {{Form::close()}}
      </section>
    </div>
  </div>

@endsection
