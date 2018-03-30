@extends('layouts.master')
@section('content')
<div class="row">
  <div class="col-lg-12">
    <h3 class="page-header"><i class="fa fa-file-text-o"></i>Parametrização</h3>
    <ol class="breadcrumb">
      <li><i class="fa fa-home"></i><a href="#">Home</a></li>
      <li><i class="icon_document_alt"></i>Categorias</li>
      <li><i class="fa fa-file-text-o"></i>Gerenciar Categorias</li>
    </ol>
  </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <section class="panel panel-default">
     <!--  <header class="panel-heading">
        Parametrizar Produtos
      </header> -->

      @if(isset($categoria))

      {{Form::model($categoria, ['route'=>['categoria.update', $categoria], 'method'=>'PUT'])}}

      @else

      {!! Form::open(['route'=>'categoria.store', 'method'=>'POST']) !!}

      @endif

      <!-- <div class="panel-footer"></div> -->


      <div class="panel-body" style="border-bottom: 1px solid #ccc; ">

        <div class="row" style="margin-bottom: 15px;">

          <div class="form-horizontal">

            <div class="col-sm-4">
              {{Form::label('nome', 'Nome')}}
              {{Form::text('nome', null, ['class' => 'form-control', 'placeholder' => 'Nome da Categoria'])}}
            </div>

          </div>

        </div>

      </div>

      <div class="panel-footer">
        <div class="row">
          <div class="col-md-6">

            {{Form::submit('Salvar', ['class'=>'btn btn-primary submit_iten'])}}

          </div>
          <div class="col-md-6 text-right">

            <a href="{{route('categoria.index')}}" class="btn btn-warning"> Cancelar </a>
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