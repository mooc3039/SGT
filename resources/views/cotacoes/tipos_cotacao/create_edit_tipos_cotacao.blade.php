@extends('layouts.master')
@section('content')
<div class="row">
  <div class="col-lg-12">
    <h3 class="page-header"><i class="fa fa-file-text-o"></i>Parametrização do Tipo Cotação</h3>
    <ol class="breadcrumb">
      <li><i class="fa fa-home"></i><a href="#">Home</a></li>
      <li><i class="icon_document_alt"></i>Tipos de Cotaçao</li>
    </ol>
  </div>
</div>

<div class="row">
  <div class="col-lg-12">

    <!-- Processing -->    
    <div class="wait">
      <div class="wait-loader">
        <img src="{{asset('/img/Gear-0.6s-200px.gif')}}"/>
      </div>
    </div>
    <!-- Processing -->

    <section class="panel panel-default">

      @if(isset($tipo_cotacao))
      {{ Form::model($tipo_cotacao, ['route' => ['tipo_cotacao.update', $tipo_cotacao->id], 'method' => 'PUT', 'class' => 'form']) }}

      @else
      {{ Form::open(['route' => 'tipo_cotacao.store','method'=>'POST', 'class' => 'form']) }}
      @endif

      <div class="panel-body" style="border-bottom: 1px solid #ccc; ">

        <div class="row" style="margin-bottom: 15px">
          <div class="form-horizontal">

            <div class="col-sm-4">
              {{Form::label('nome', 'Tipo de Cotação')}}
              {{Form::text('nome', null, ['placeholder' => 'Tipo de Cotação', 'class' => 'form-control'])}}
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

            @if(isset($tipo_cotacao))

            {{Form::hidden('tipo_cotacao_id', $tipo_cotacao->id)}} <!-- Para ser capturado no FormReques para ignorar a validacao uniq para o campo email durante o update -->

            {{ Form::submit('Actualizar', ['class'=>'btn btn-primary salvar_tipo_cotacao']) }}

            @else

            {{ Form::submit('Salvar', ['class'=>'btn btn-primary salvar_tipo_cotacao']) }}
            {{ Form::reset('Limpar', ['class'=>'btn btn-default']) }}

            @endif

          </div>
          <div class="col-md-6">

            <a href="{{route('tipo_cotacao.index')}}" class="btn btn-primary pull-right">Cancelar</a>

          </div>
        </div>



      </div>





      {{Form::close()}}
    </section>
  </div>
</div>

@endsection

@section('script')
<script type="text/javascript">
  $(document).ready(function(){
    $('.salvar_tipo_cotacao').on('click',function(){
      $(".wait").css("display", "block");
    });
  });
</script>
@endsection
