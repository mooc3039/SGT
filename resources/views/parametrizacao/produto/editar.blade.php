@extends('layouts.master')
@section('content')
<div class="row">
  <div class="col-lg-12">
    <h3 class="page-header"><i class="fa fa-file-text-o"></i>Parametrização</h3>
    <ol class="breadcrumb">
      <li><i class="fa fa-home"></i><a href="#">Home</a></li>
      <li><i class="icon_document_alt"></i>Produtos</li>
      <li><i class="fa fa-file-text-o"></i>Gerenciar Produto</li>
    </ol>
  </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <section class="panel panel-default">
      <header class="panel-heading">
        Actualizar Produto
      </header>

      {!! Form::open([ 'action' => ['produtoController@update', $produto->id],'method' => 'POST', 'class' => 'form-horizontal']) !!}
        <div class="panel-body" style="border-bottom: 1px solid #ccc; ">
          <div class="form-group">

              <div class="col-sm-3">
                {{Form::label('descricao', 'Descrição')}}
                {{Form::text('descricao', $produto->descricao, ['class' => 'form-control', 'placeholder' => 'Descrição do Produto'])}}
              </div>
          
              <div class="col-sm-3">
                {{Form::label('preco_venda', 'Preço de Venda')}}
                {{Form::text('preco_venda', $produto->preco_venda, ['class' => 'form-control', 'placeholder' => 'Preço de Venda'])}}
              </div>
          
              <div class="col-sm-3">
                {{Form::label('preco_aquisicao', 'Preço de Aquisição')}}
                {{Form::text('preco_aquisicao', $produto->preco_aquisicao, ['class' => 'form-control', 'placeholder' => 'Preço de Aquisição '])}}
              </div>
          
              <div class="col-sm-3">
                {{Form::label('quantidade_dispo', 'Quantidade Disponível')}}
                {{Form::text('quantidade_dispo', $produto->quantidade_dispo, ['class' => 'form-control', 'placeholder' => 'Quantidade Disponível'])}}
              </div>
        
              <div class="col-sm-3">
                {{Form::label('quantidade_min', 'Quantidade Minima')}}
                {{Form::text('quantidade_min', $produto->quantidade_min, ['class' => 'form-control', 'placeholder' => 'Validade'])}}
              </div>
         
            </div>
          </div>
          <div class="panel-footer">
            {{Form::hidden('_method','PUT')}}
            {{Form::submit('Actualizar Produto', ['class'=>'btn btn-primary'])}}
          </div>
        
      {!! Form::close() !!}

      
    </section>
  </div>
</div>

@endsection
