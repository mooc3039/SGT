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
        Actualizar Dados do Fornecedor
      </header>

      {!! Form::open(['action' => ['fornecedorController@update', $fornecedor->fornecedor_id], 'method' => 'POST', 'class' => 'form-horizontal']) !!}
        <div class="panel-body" style="border-bottom: 1px solid #ccc; ">
          <div class="form-group">

              <div class="col-sm-3">
                {{Form::label('nome', 'Nome da Empresa')}}
                {{Form::text('nome', $fornecedor->nome, ['class' => 'form-control', 'placeholder' => 'Nome do Fornecedor'])}}
              </div>
          
              <div class="col-sm-3">
                {{Form::label('contacto', 'Contacto')}}
                {{Form::text('contacto', $fornecedor->contacto, ['class' => 'form-control', 'placeholder' => 'Contacto do Fornecedor'])}}
              </div>
          
              <div class="col-sm-3">
                {{Form::label('email', 'Email')}}
                {{Form::text('email', $fornecedor->email, ['class' => 'form-control', 'placeholder' => 'Email do Fornecedor'])}}
              </div>
          
              <div class="col-sm-3">
                {{Form::label('produto', 'Produto')}}
                {{Form::text('produto', $fornecedor->produto, ['class' => 'form-control', 'placeholder' => 'Produto que fornece'])}}
              </div>
        
              <div class="col-sm-3">
                {{Form::label('rubrica', 'Rubrica')}}
                {{Form::text('rubrica', $fornecedor->rubrica, ['class' => 'form-control', 'placeholder' => 'Rubrica'])}}
              </div>
        
          
              <div class="col-sm-6">
                {{Form::label('descricao', 'Descrição')}}
                {{Form::text('descricao', $fornecedor->descricao, ['class' => 'form-control', 'placeholder' => 'Descrição do Fornecedor'])}}
              </div>  
            </div>
          </div>
          <div class="panel-footer">
            {{Form::hidden('_method','PUT')}}
            {{Form::submit('Actualizar Fornecedor', ['class'=>'btn btn-primary'])}}
          </div>
        
      {!! Form::close() !!}

    </section>
  </div>
</div>

@endsection
