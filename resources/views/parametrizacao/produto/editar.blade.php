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

      {!! Form::open([ 'action' => ['produtoController@update', $produto->produto_id],'method' => 'POST', 'class' => 'form-horizontal']) !!}
        <div class="panel-body" style="border-bottom: 1px solid #ccc; ">
          <div class="form-group">

              <div class="col-sm-3">
                {{Form::label('nome', 'Nome do Produto')}}
                {{Form::text('nome', $produto->nome, ['class' => 'form-control', 'placeholder' => 'Nome do Produto'])}}
              </div>
          
              <div class="col-sm-3">
                {{Form::label('tipo', 'Categoria/Tipo')}}
                {{Form::text('tipo', $produto->tipo, ['class' => 'form-control', 'placeholder' => 'Categoria/Tipo'])}}
              </div>
          
              <div class="col-sm-3">
                {{Form::label('preco', 'Preço')}}
                {{Form::text('preco', $produto->preco, ['class' => 'form-control', 'placeholder' => 'Preço '])}}
              </div>
          
              <div class="col-sm-3">
                {{Form::label('fornecedor', 'Fornecedor')}}
                {{Form::text('fornecedor', $produto->fornecedor, ['class' => 'form-control', 'placeholder' => 'Fornecedor'])}}
              </div>
        
              <div class="col-sm-3">
                {{Form::label('validade', 'Validade')}}
                {{Form::text('validade', $produto->validade, ['class' => 'form-control', 'placeholder' => 'Validade'])}}
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
