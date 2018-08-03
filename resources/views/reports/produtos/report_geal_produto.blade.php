@extends('layouts.master')

@section('content')
<div class="row">
  <div class="col-lg-12">
    <h3 class="page-header"><i class="fa fa-file-text-o"></i>Produtos</h3>
    <ol class="breadcrumb">
      <li><i class="fa fa-home"></i><a href="#">Home / Relatórios Gérais</a></li>
      <li><i class="icon_document_alt"></i>Produtos</li>
    </ol>
  </div>
</div>



<div class="row">
  <div class="col-lg-12">
    <section class="panel panel-default">
      <div class="panel-body">

        <div class="row">

          <div class="col-md-8">

            <a href="{{route('report_geral_produto')}}" class="btn btn-default pull-left" style="width: auto; height: 28px; margin-left: 3px; font-size: 15px; font-weight: normal; padding: 3px 10px;"> <i class="fa fa-list"></i> Listar Todos </a>

            
            <div class="btn-group pull-left" role="group" aria-label="...">


              <select class="btn btn-default select_search" id="categoria"><i class="fa fa-list"></i>
                <option> Listar por Categoria </option>
                @foreach($categorias as $categoria)
                <option class="selected_categoria search_select" value="{{$categoria->id}}"> {{$categoria->nome}} </option>
                @endforeach
              </select>


              <select class="btn btn-default select_search" id="fornecedor">
                <option> Listar por Fornecedor </option>
                @foreach($fornecedores as $fornecedor)
                <option class="selected_fornecedor search_select" value="{{$fornecedor->id}}"> {{$fornecedor->nome}} </option>
                @endforeach
              </select>

            </div>

          </div>
          <div class="col-md-4">
            <input type="text" id="pesq" class="form-control" placeholder="Pesquisa...">
          </div>
        </div>


        <table class="mostrar table table-striped table-advance table-hover" id="tbl_report_geral_prd" data-order='[[ 0, "desc" ]]'>


          <thead>
            <tr>
              <th> Descricão </th>
              <th> Quantidade Disponivel </th>
              <th> Preco Venda </th>
              <th> Preco Aquisicao </th>
              <th> Categoria </th>
              <th> Fornecedor </th>

            </tr>
          </thead>
          <tbody id="data">

           @foreach($produtos as $produto)
           <tr
           @php
           if($produto->quantidade_dispo <= $produto->quantidade_min )
           {
            echo 'style="color:red"';
          } elseif($produto->quantidade_dispo <= ($produto->quantidade_min + $produto->quantidade_min/3)){
          echo 'style="color:blue"';
        }
        @endphp
        >
        <td>{{$produto->descricao}}</td>
        <td>{{$produto->quantidade_dispo}}</td>
        <td>{{number_format($produto->preco_venda, 2, '.', ',')}}</td>
        <td>{{number_format($produto->preco_aquisicao, 2, '.', ',')}}</td>
        <td>{{$produto->categoria->nome}}</td>
        <td>{{$produto->fornecedor->nome}}</td>
      </tr>
      @endforeach

    </tbody>

    <tbody id="data-ajax">

    </tbody>
  </table>

</div>
<div class="panel-footer">
</div>


</section>
</div>
</div>

@endsection


@section('script')

<script type="text/javascript">

  $(document).ready(function() {
    var oTable = $('#tbl_report_geral_prd').DataTable( {
      "pagingType": "full_numbers",
      "dom": 'Brtpl',
      buttons: [
            // 'print',
            // 'excelHtml5',
            // 'pdfHtml5'
            {
              text: 'Imprimir',
              extend: 'print',
              className: 'btn btn-defaul btn-sm'
            },
            {
              text: 'Excel',
              extend: 'excelHtml5',
              className: 'btn btn-defaul btn-sm'
            },
            {
              text: 'PDF',
              extend: 'pdfHtml5',
              className: 'btn btn-defaul btn-sm'
            }
            ]
        });

    $('#pesq').keyup(function(){
      oTable.search($(this).val()).draw();
    });
  } );


  $(document).ready(function(){
    $(document).ajaxStart(function(){
      $(".wait").css("display", "block");
    });
    $(document).ajaxComplete(function(){
      $(".wait").css("display", "none");
    });
  });

  $(document).ready(function(){

    /*LISTAR POR CATEGORIA*/
    $('#categoria').change( function() {
      $('#data').hide();
      $('#data-ajax').empty();

      var option = this.options[this.selectedIndex];
      var id = option.value;

      $.get('listar_prod_categoria_ajax/'+id, function(data){

        $.each(data, function(key, val){

          $('#data-ajax')
          .append("<tr>"+
            "<td>"+val.descricao+"</td>"+
            "<td>"+val.quantidade_dispo+"</td>"+
            "<td>"+val.preco_venda+"</td>"+
            "<td>"+val.preco_aquisicao+"</td>"+
            "<td>"+val.categoria['nome']+"</td>"+
            "<td>"+val.fornecedor['nome']+"</td>"+
            "</tr>");

        });
      });

    })
    /* FIM LISTAR POR CATEGORIA*/

    /* LISTAR POR FORNECEDOR */
    $('#fornecedor').change( function() {
      $('#data').hide();
      $('#data-ajax').empty();

      var option = this.options[this.selectedIndex];
      var id = option.value;

      $.get('listar_prod_fornecedor_ajax/'+id, function(data){

        $.each(data, function(key, val){

          $('#data-ajax')
          .append("<tr>"+
            "<td>"+val.descricao+"</td>"+
            "<td>"+val.quantidade_dispo+"</td>"+
            "<td>"+val.preco_venda+"</td>"+
            "<td>"+val.preco_aquisicao+"</td>"+
            "<td>"+val.categoria['nome']+"</td>"+
            "<td>"+val.fornecedor['nome']+"</td>"+
            "</tr>");

        });
      });

    })
    /* FIM LISTAR POR FORNECEDOR */

  });
  
</script>
@endsection