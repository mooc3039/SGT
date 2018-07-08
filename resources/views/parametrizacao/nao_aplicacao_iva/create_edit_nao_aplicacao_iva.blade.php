@extends('layouts.master')
@section('content')
  <div class="row">
    <div class="col-lg-12">
      <h3 class="page-header"><i class="fa fa-file-text-o"></i>Parametrização do Motivo da Não aplicação do IVA</h3>
      <ol class="breadcrumb">
        <li><i class="fa fa-home"></i><a href="#">Home</a></li>
        <li><i class="icon_document_alt"></i>Motivo da Não aplicação do IVA</li>
</ol>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-12">
      <section class="panel panel-default">

        @if(isset($motivo_nao_aplicacao_iva))
          {{ Form::model($motivo_nao_aplicacao_iva, ['route' => ['motivo_nao_aplicacao_iva.update', $motivo_nao_aplicacao_iva->id], 'method' => 'PUT', 'class' => 'form']) }}

        @else
          {{ Form::open(['route' => 'motivo_nao_aplicacao_iva.store','method'=>'POST', 'class' => 'form']) }}
        @endif

        <div class="panel-body" style="border-bottom: 1px solid #ccc; ">

          <div class="row" style="margin-bottom: 15px">

            <div class="form-horizontal">

              <div class="col-sm-12">
                {{Form::label('motivo_nao_aplicacao', 'Motivo da Não aplicação do IVA')}}
                {{Form::textarea('motivo_nao_aplicacao', null, ['placeholder' => 'Motivo da Não aplicação do IVA', 'class' => 'form-control'])}}
              </div>

            </div>

          </div>


        </div>

        <div class="panel-footer">

          <div class="row">
            <div class="col-md-6">

              @if(isset($motivo_nao_aplicacao_iva))

                {{Form::hidden('motivo_nao_aplicacao_iva_id', $motivo_nao_aplicacao_iva->id)}} <!-- Para ser capturado no FormReques para ignorar a validacao uniq para o campo email durante o update -->

                {{ Form::button('Actualizar', ['type'=>'submit', 'class'=>'btn btn-primary']) }}

              @else

                {{ Form::button('Salvar', ['type'=>'submit', 'class'=>'btn btn-primary']) }}
                {{ Form::reset('Limpar', ['class'=>'btn btn-default']) }}

              @endif

            </div>
            <div class="col-md-6">

              <a href="{{route('motivo_nao_aplicacao_iva.index')}}" class="btn btn-primary pull-right">Cancelar</a>

            </div>
          </div>



        </div>





        {{Form::close()}}
      </section>
    </div>
  </div>

@endsection
