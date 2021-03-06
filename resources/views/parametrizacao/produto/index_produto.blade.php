@extends('layouts.master')
@section('content')
<div class="row">
  <div class="col-lg-12">
    <h3 class="page-header"><i class="fa fa-file-text-o"></i>Parametrização do Produto</h3>
    <ol class="breadcrumb">
      <li><i class="fa fa-home"></i><a href="#">Home</a></li>
      <li><i class="icon_document_alt"></i>Produto</li>
      <li><i class="fa fa-file-text-o"></i>Gerenciar Produto</li>
    </ol>
  </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <section class="panel panel-default">
      <!-- <header class="panel-heading">
        Lista dos Produto
      </header> -->

      <div class="panel-body">
        <div class="row" style="margin-bottom: 10px">
          <div class="col-md-8">
            <a href="{{ route('produtos.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
          </div>
          <div class="col-md-4">
                <input type="text" id="pesq" class="form-control" placeholder="Pesquisa...">
              </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <table class="table table-striped table-advance table-hover" id="tbl_index_produtos" data-order='[[ 0, "asc" ]]'>

          <thead>
            <tr>
              <th>Referência</th>
              <th>Descrição</th>
              <th>Preço de Venda (Mtn)</th>
              <th>Preço de Aquisição (Mtn)</th>
              <th>Quantidade Disponível</th>
              <th>Quantidade Minima</th>
              <th style="width: 12%"><i class="icon_cogs"></i> Operações</th>
            </tr>
          </thead>

          <tbody>
            @foreach($produtos as $produto)
            <tr>
            <td> {{$produto->referencia}}</td>
              <td> {{$produto->descricao}}</td>
              <td>{{number_format($produto->preco_venda, 2, '.', ',')}}</td>
              <td>{{number_format($produto->preco_aquisicao, 2, '.', ',')}}</td>
              <td>{{$produto->quantidade_dispo}}</td>
              <td>{{$produto->quantidade_min}}</td>
              <td style="width: 12%x">
                <div class="btn-group btn-group-sm">
                  <a class="btn btn-primary" href="#"><i class="icon_plus_alt2"></i></a>
                  <a class="btn btn-success" href="{{route('produtos.edit', $produto->id)}}"><i class="fa fa-pencil"></i></a>
                  <a class="btn btn-danger" href="{{route('produtos.destroy', $produto->id)}}"><i class="icon_close_alt2"></i></a>
                </div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
          </div>
        </div>
      </div>
      


      <div class="panel-footer">
        <div class="row">
          <div class="col-md-6">
          </div>
        </div>
      </div>

    </section>
    
  </div>
</div>



@endsection

@section('script')
<script type="text/javascript">
    // DataTables Inicio
  $(document).ready(function() {

    var titulo = "Produtos";   
    var msg_bottom = "Papelaria Agenda & Serviços";

    var oTable = $('#tbl_index_produtos').DataTable( {
      "processing": true,
      "pagingType": "full_numbers",
      "dom": 'Brtpl',
      buttons: [
            // 'print',
            // 'excelHtml5',
            // 'pdfHtml5'
            {
              text: 'Imprimir',
              extend: 'print',
              title: titulo,
              messageBottom: msg_bottom,
              className: 'btn btn-defaul btn-sm'
            },
            {
              text: 'Excel',
              extend: 'excelHtml5',
              title: titulo,
              messageBottom: msg_bottom,
              className: 'btn btn-defaul btn-sm'
            },
            {
              text: 'PDF',
              extend: 'pdfHtml5',
              title: titulo,
              messageBottom: msg_bottom,
              className: 'btn btn-defaul btn-sm'
            }
            ]
          });

    $('#pesq').keyup(function(){
      oTable.search($(this).val()).draw();
    });

  } );
  // DataTables Fim
</script>
@endsection
