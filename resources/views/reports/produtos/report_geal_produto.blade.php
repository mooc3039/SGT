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
      <div class="panel-heading">
        <div class="row">
          <div class="col-md-4">

            <a href="#"><h5><b><i class="fa fa-print"></i>Imprimir </b></h5></a>

          </div>

          <div class="col-md-8">

            <a href="{{route('report_geral_produto')}}" class="btn btn-default pull-right" style="width: auto; height: 28px; margin-top: 4px; margin-left: 3px; font-size: 15px; font-weight: normal; padding: 3px 10px;"> <i class="fa fa-list"></i> Listar Todos </a>

            
            <div class="btn-group pull-right" role="group" aria-label="...">


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
        </div>
      </div>
      <div class="panel-body">


        <table class="table table-striped table-advance table-hover" id="tbl_report_geral_prd">


          <thead>
            <tr>
              <th><i class="fa fa-shopping-cart"></i> Descricão </th>
              <th><i class="fa fa-database"></i> Quantidade Disponivel </th>
              <th><i class="fa fa-money"></i> Preco Venda </th>
              <th><i class="fa fa-money"></i> Preco Aquisicao </th>
              <th><i class="fa fa-suitcase"></i> Categoria </th>
              <th><i class="fa fa-user"></i> Fornecedor </th>

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
            <td>{{$produto->preco_venda}}</td>
            <td>{{$produto->preco_aquisicao}}</td>
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
      {{ $produtos->links() }}
    </div>


  </section>
</div>
</div>

@endsection


@section('script')

<script type="text/javascript">
  
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