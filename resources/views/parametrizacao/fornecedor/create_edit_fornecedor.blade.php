@extends('layouts.master')
@section('content')
<div class="row">
  <div class="col-lg-12">
    <h3 class="page-header"><i class="fa fa-file-text-o"></i>Parametrização</h3>
    <ol class="breadcrumb">
      <li><i class="fa fa-home"></i><a href="#">Home</a></li>
      <li><i class="icon_document_alt"></i>Fornecedor</li>
      <li><i class="fa fa-file-text-o"></i>Gerenciar Fornecedor</li>
    </ol>
  </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <section class="panel panel-default">
      <header class="panel-heading">
        Novo Fornecedor
      </header>
 
      @if(isset($fornecedor))

      {{ Form::model($fornecedor, ['route' => ['fornecedores.update', $fornecedor->id], 'method' => 'PUT']) }}

      @else

      {{ Form::open(['route' => 'fornecedores.store','method'=>'POST']) }}

      @endif

      <div class="panel-body" style="border-bottom: 1px solid #ccc; ">
        <div class="row" style="margin-bottom: 15px">

          <div class="form-horizontal">

            <div class="col-md-3">
              {{Form::label('nome', 'Nome do Fornecedor')}}
              {{Form::text('nome', null, ['placeholder' => 'Nome do Fornecedor', 'class' => 'form-control'])}}
            </div>

            <div class="col-md-3">
              {{Form::label('telefone', 'Telefone')}}
              {{Form::text('telefone', null, ['placeholder' => 'Telefone', 'class' => 'form-control'])}}
            </div>

            <div class="col-md-3">
              {{Form::label('endereco', 'Endereço')}}
              {{Form::text('endereco', null, ['placeholder' => 'Endereço', 'class' => 'form-control'])}}
            </div>

            <div class="col-md-3">
              {{Form::label('email', 'Email')}}
              {{Form::text('email', null, ['placeholder' => 'Email', 'class' => 'form-control'])}}
            </div>

          </div>

        </div>

        <div class="row" style="margin-bottom: 15px">

          <div class="form-horizontal">

            <div class="col-md-3">
              {{Form::label('rubrica', 'Rubrica')}}
              {{Form::text('rubrica', null, ['placeholder' => 'Rubrica', 'class' => 'form-control'])}}
            </div>
            <div class="col-md-3">
              {{Form::label('nuit', 'NUIT')}}
              {{Form::text('nuit', null, ['placeholder' => 'NUIT', 'class' => 'form-control'])}}
            </div>

            <div class="col-md-3" >
              <div class="radio-inline" style="margin: 25px">
                <input type="radio" name="activo" value="1" id="activo" 
                @if(isset($fornecedor))
                @if($fornecedor->activo == 1)
                {{'checked'}}
                @endif
                @endif><label for="activo">Activo</label>
                <!-- {{Form::radio('activo', '1', ['class' => 'form-horizontal'])}} Activo -->
              </div>
              <div class="radio-inline">
                <input type="radio" name="activo" value="0" id="inactivo" 
                @if(isset($fornecedor))
                @if($fornecedor->activo == 0)
                {{'checked'}}
                @endif
                @endif><label for="inactivo">Inactivo</label>
                <!-- {{Form::radio('activo', '0', ['class' => 'form-horizontal'])}} Inactivo -->
              </div>
            </div>

          </div>

        </div>
      </div>
      <div class="panel-footer">
        <div class="row">
          <div class="col-md-6">

            @if(isset($fornecedor))

            {{Form::hidden('fornecedor_id', $fornecedor->id)}}

            {{Form::submit('Actualizar', ['class'=>'btn btn-primary submit_iten'])}}

            @else

            {{Form::submit('Salvar', ['class'=>'btn btn-primary submit_iten'])}}
            {{Form::reset('Limpar', ['class'=>'btn btn-default'])}}

            @endif

          </div>
          <div class="col-md-6">

            <a href="{{route('fornecedores.index')}}" class="btn btn-warning pull-right"> Cancelar</a>

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
