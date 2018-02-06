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
     <!--  <header class="panel-heading">
        Parametrizar Produtos
      </header> -->

      @if(isset($produto))

      {{Form::model($produto, ['route'=>['produtos.update', $produto->id], 'method'=>'PUT'])}}

      @else

      {!! Form::open(['route'=>'produtos.store', 'method'=>'POST']) !!}

      @endif

     <!--  <div class="panel-body">

     </div> -->
     <!-- <div class="panel-footer"></div> -->


     <div class="panel-body" style="border-bottom: 1px solid #ccc; ">

      <div class="row" style="margin-bottom: 15px;">

        <div class="form-horizontal">

          <div class="col-md-4">

            {{Form::label('categoria_id', 'Categoria')}}
            <div class="input-group">
              {{Form::select('categoria_id', [''=>'Selecione Categoria',] + $categoria, null, ['class'=>'form-control select_search'] )}}
              {{Form::button('<i class="fa fa-plus"></i>', ['class'=>'input-group-addon', 'data-toggle'=>'modal', 'data-target'=>'#modalCategoria', 'style'=>'width:auto; font-weight:lighter'])}}

            </div>

          </div>

          <div class="col-md-4">

            {{Form::label('fornecedor_id', 'Fornecedor')}}
            <div class="input-group">
              {{Form::select('fornecedor_id', [''=>'Selecione Fornecedor',] + $fornecedor, null, ['class'=>'form-control select_search'] )}}
              {{Form::button('<i class="fa fa-plus"></i>', ['class'=>'input-group-addon', 'data-toggle'=>'modal', 'data-target'=>'#modalFornecedor', 'style'=>'width:auto; font-weight:lighter'])}}
            </div>

          </div>


        </div>

      </div>

      <hr style="border: 1px solid #ccc;">

      <div class="row" style="margin-bottom: 15px;">

        <div class="form-horizontal">

          <div class="col-sm-4">
            {{Form::label('descricao', 'Descrição')}}
            {{Form::text('descricao', null, ['class' => 'form-control', 'placeholder' => 'Descrição do Produto'])}}
          </div>

          <div class="col-sm-4">
            {{Form::label('preco_venda', 'Preço de Venda')}}
            <div class="input-group">
              {{Form::text('preco_venda', null, ['class' => 'form-control', 'placeholder' => '0.00 - 999999.99'])}}
              <div class="input-group-addon">Mtn</div>
            </div>
          </div>

          <div class="col-sm-4">
            {{Form::label('preco_aquisicao', 'Preço de Aquisição')}}
            <div class="input-group">
            {{Form::text('preco_aquisicao', null, ['class' => 'form-control', 'placeholder' => '0.00 - 999999.99 '])}}
            <div class="input-group-addon">Mtn</div>
          </div>
          </div>

        </div>

      </div>

      <div class="row">

        <div class="form-horizontal">

          <div class="col-sm-4">
            {{Form::label('quantidade_dispo', 'Quantidade Disponível')}}
            {{Form::text('quantidade_dispo', null, ['class' => 'form-control', 'placeholder' => 'Quantidade Disponível'])}}
          </div>

          <div class="col-sm-4">
            {{Form::label('quantidade_min', 'Quantidade Minima')}}
            {{Form::text('quantidade_min', null, ['class' => 'form-control', 'placeholder' => 'Quantidade Minima'])}}
          </div>

        </div>

      </div>

    </div>
    <div class="panel-footer">
      <div class="row">
        <div class="col-md-6">

          @if(isset($produto))

          {{Form::submit('Actualizar', ['class'=>'btn btn-primary'])}}

          @else

          {{Form::submit('Salvar', ['class'=>'btn btn-primary'])}}

          @endif

          {{Form::reset('Limpar', ['class'=>'btn btn-default'])}}

        </div>
        <div class="col-md-6 text-right">

          <a href="{{route('produtos.index')}}" class="btn btn-warning"> Cancelar </a>
        </div>
      </div>

    </div>

    {!! Form::close() !!}


  </section>
</div>
</div>

<!-- MODAL CATEGORIA -->
<div class="modal fade" tabindex="-1" role="dialog" id="modalCategoria">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Cadastrar Categoria</h4>
      </div>
      <div class="modal-body">

        {{Form::open(['route'=>'categoria_salvar_rback', 'method'=>'POST'])}}

        <div class="form-group">
          {{Form::label('nome', 'Nome', ['class'=>'control-lable'])}}
          {{Form::text('nome', null, ['placeholder' => 'Nome', 'class' => 'form-control'])}}
        </div>

      </div>
      <div class="modal-footer">

        {{Form::button('Fechar', ['class'=>'btn btn-default', 'data-dismiss'=>'modal'])}}
        {{Form::submit('Salvar', ['class'=>'btn btn-primary'])}}

        {{Form::close()}}
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- FIM MODAL CATEGORIA -->


<!-- MODAL FORNECEDOR -->
<div class="modal fade" tabindex="-1" role="dialog" id="modalFornecedor">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Cadastrar Fornecedor</h4>
      </div>
      <div class="modal-body">

        {{Form::open(['route'=>'fornecedor_salvar_rback', 'method'=>'POST'])}}
        <div class="form-group">
          {{Form::label('nome', 'Nome', ['class'=>'control-lable'])}}
          {{Form::text('nome', null, ['placeholder' => 'Nome', 'class' => 'form-control'])}}
        </div>
        <div class="form-group">
          {{Form::label('telefone', 'Telefone', ['class'=>'control-lable'])}}
          {{Form::text('telefone', null, ['placeholder' => 'Telefone', 'class' => 'form-control'])}}
        </div>
        <div class="form-group">
          {{Form::label('endereco', 'Endereço', ['class'=>'control-lable'])}}
          {{Form::text('endereco', null, ['placeholder' => 'Endereço', 'class' => 'form-control'])}}
        </div>
        <div class="form-group">
          {{Form::label('email', 'Email', ['class'=>'control-lable'])}}
          {{Form::text('email', null, ['placeholder' => 'Email', 'class' => 'form-control'])}}
        </div>
        <div class="form-group">
          {{Form::label('rubrica', 'Rubrica', ['class'=>'control-lable'])}}
          {{Form::text('rubrica', null, ['placeholder' => 'Rubrica', 'class' => 'form-control'])}}
        </div>
        <div class="radio-inline">
          {{Form::radio('activo', '1')}} Activo
        </div>
        <div class="radio-inline">
          {{Form::radio('activo', '0')}} Inactivo
        </div>

      </div>
      <div class="modal-footer">
        {{Form::button('Fechar', ['class'=>'btn btn-default', 'data-dismiss'=>'modal'])}}
        {{Form::submit('Salvar', ['class'=>'btn btn-primary'])}}
        <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
          <button type="button" class="btn btn-primary">Salvar</button> -->
          {{Form::close()}}
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
  <!--FIM MODAL FORNECEDOR -->

  @endsection
