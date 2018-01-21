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

      {!! Form::open(['action' => 'fornecedorController@store', 'method' => 'POST', 'class' => 'form-horizontal']) !!}
        <div class="panel-body" style="border-bottom: 1px solid #ccc; ">
          <div class="form-group">

              <div class="col-sm-3">
                {{Form::label('nome', 'Nome da Empresa')}}
                {{Form::text('nome', '', ['class' => 'form-control', 'placeholder' => 'Nome do Fornecedor'])}}
              </div>
          
              <div class="col-sm-3">
                {{Form::label('endereco', 'Endereço')}}
                {{Form::text('endereco', '', ['class' => 'form-control', 'placeholder' => 'Endereço'])}}
              </div>
          
              <div class="col-sm-3">
                {{Form::label('email', 'Email')}}
                {{Form::text('email', '', ['class' => 'form-control', 'placeholder' => 'Email do Fornecedor'])}}
              </div>
          
              <div class="col-sm-3">
                {{Form::label('telefone', 'Telefone')}}
                {{Form::text('telefone', '', ['class' => 'form-control', 'placeholder' => 'Telefone'])}}
              </div>
        
              <div class="col-sm-3">
                {{Form::label('rubrica', 'Rubrica')}}
                {{Form::text('rubrica', '', ['class' => 'form-control', 'placeholder' => 'Rubrica'])}}
              </div>
 
            </div>
          </div>
          <div class="panel-footer">
            {{Form::submit('Adicionar Fornecedor', ['class'=>'btn btn-primary'])}}
          </div>
        
      {!! Form::close() !!}

    </section>
  </div>
</div>

@endsection
