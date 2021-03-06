@extends('layouts.master')
@section('content')
<div class="row">
  <div class="col-lg-12">
    <h3 class="page-header"><i class="fa fa-file-text-o"></i>Entradas</h3>
    <ol class="breadcrumb">
      <li><i class="fa fa-home"></i><a href="#">Home</a></li>
      <li><i class="icon_document_alt"></i>Entradas</li>
    </ol>
  </div>
</div>

<div class="row">
  <div class="col-lg-12">
     
    <section class="panel panel-default">
      <div class="panel-body">
        <div class="row" style="margin-bottom: 10px">
          <div class="col-md-8">
            <a href="{{ route('entrada.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
          </div>
          <div class="col-md-4">
                <input type="text" id="pesq" class="form-control" placeholder="Pesquisa...">
              </div>
        </div>

        <table class="table table-striped table-advance table-hover" id="tbl_index_entradas" data-order='[[ 0, "desc" ]]'>
          <thead>
            <tr>
              <th> Código da Entrada </th>
              <th> Data de Entrada </th>
              <th> Fornecedor </th>
              <th> Valor Total </th>
              <th> Pagamento </th>
              <th class="text-right"><i class="icon_cogs"></i> Operações </th>
            </tr>
          </thead>
          <tbody>
            @foreach($entradas as $entrada)
            <tr>
              <td> {{$entrada->codigo}} </td>
              <td> {{date('d-m-Y', strtotime($entrada->created_at))}} </td>
              <td> {{$entrada->fornecedor->nome}} </td>
              <td> {{number_format($entrada->valor_total, 2, '.', ',')}} </td>
              {{ Form::open(['route'=>['entrada.destroy', $entrada->id], 'method'=>'DELETE']) }}
              <td>
                <!-- <button type="button" data-toggle="modal" data-target="#modalPagamentoEntrada" data-entrada_id={{ $entrada->id }} data-valor_total={{ $entrada->valor_total }} data-valor_pago={{ $entrada->valor_pago }} data-troco={{ $entrada->troco }} data-forma_pagamento_id={{ $entrada->forma_pagamento_id }} data-nr_documento_forma_pagamento={{ $entrada->nr_documento_forma_pagamento }} -->
                  <a href="{{route('createPagamentoEntrada', $entrada->id)}}"

                    <?php
                    $valor_pago_soma = 0;
                    $arry_valor_pago_soma = array();

                    foreach($entrada->pagamentosEntrada as $pagamento){
                      $arry_valor_pago_soma[] = $pagamento->valor_pago;
                    }

                    if(sizeof($arry_valor_pago_soma)<0){
                      $valor_pago_soma = 0;
                    }else{
                      $valor_pago_soma = array_sum($arry_valor_pago_soma);
                    }



                    if(($entrada->pago==1 && ($valor_pago_soma >= $entrada->valor_total))){ 
                      echo 'class="btn btn-success btn-sm"';
                    }else{
                      echo 'class="btn btn-danger btn-sm"';
                    }

                    ?>
                    >
                    <!-- > -->
                    Pagamento

                    <?php

                    if(($entrada->pago==1) && ($valor_pago_soma >= $entrada->valor_total) ){
                      echo '<i class="fa fa-check"></i>';
                    }else{
                      echo '<i class="icon_close_alt2"></i>';
                    }

                    ?>
                  </a>
                  <!-- </button> -->

                </td>
                <td class="text-right">
                  <div class="btn-group btn-group-sm">

                    <a class="btn btn-primary" href="{{route('entrada.show', $entrada->id)}}"><i class="fa fa-eye"></i></a>
                    <a class="btn btn-success" href="{{route('entrada.edit', $entrada->id)}}"
                      @if($entrada->pago==1)
                      {{ 'disabled' }}
                      @endif
                      >
                      <i class="fa fa-pencil"></i>
                    </a>
                    {{ Form::button('<i class="icon_close_alt2"></i>', ['type'=>'submit', 'class'=>'btn btn-danger submit_iten']) }}

                  </div>
                </td>
                {{ Form::close() }}
              </tr>
              @endforeach
            </tbody>
          </table>

        </div>

      </section>
    </div>
  </div>

  <div class="modal fade" tabindex="-1" role="dialog" id="modalPagamentoEntrada">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"><b>Entrada: </b>Pagamento</h4>
        </div>
        <div class="modal-body">

          {{Form::open(['route'=>['pagamentoEntrada'], 'method'=>'POST', 'onsubmit'=>'submitFormPagamentoEntrada.disabled = true; return true;'])}}

          <div class="row">
            <div class="col-md-12">
              <legend>Pagamento: <span class="valor_total_visual pull-right" style="color: blue"></span></legend>
              <div class="row" style="margin-bottom: 5px">
                <div class="col-md-4">
                  <div class="radio-inline">
                    <!-- {{Form::radio('pago', '1', ['id'=>'pago', 'onclick'=>'javascript:pagoNaoPago();'])}} Pago -->
                    <input type="radio" onclick="javascript:pagoNaoPago();" name="pago" value="1" id="pago"> Pago
                  </div>
                  <div class="radio-inline">
                    <!-- {{Form::radio('pago', '0', ['id'=>'nao_pago', 'onclick'=>'javascript:pagoNaoPago();'])}} Não Pago -->
                    <input type="radio" onclick="javascript:pagoNaoPago();" name="pago" value="0" id="nao_pago"> Não Pago
                  </div>

                </div>

                <div class="col-md-8" id="div_forma_pagamento" style="display:none">
                  <div class="row">
                    <div class="col-md-6">
                      {{ Form::label('valor_pago', 'Valor Pago')}}
                      <div class="input-group">
                        {{ Form::text('valor_pago', null, ['class'=>'form-control', 'id'=>'valor_pago'])}}
                        <div class="input-group-addon">$</div>
                      </div>            
                    </div>
                    <div class="col-md-6">
                      {{ Form::label('troco', 'Troco')}}
                      <div class="input-group">
                        {{ Form::text('troco', null, ['class'=>'form-control', 'readonly'])}}
                        <div class="input-group-addon">$</div>
                      </div>
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-6">
                      {{ Form::label('forma_pagamento_id', 'Forma Pgamento')}}
                      {{Form::select('forma_pagamento_id', [''=>'Forma Pgamento',] + $formas_pagamento, null, ['class'=>'form-control', 'id'=>'forma_pagamento_id'] )}}
                    </div>
                    <div class="col-md-6">
                      {{ Form::label('nr_documento_forma_pagamento', 'Documento')}}
                      {{ Form::text('nr_documento_forma_pagamento', null, ['class'=>'form-control', 'id'=>'nr_documento_forma_pagamento'])}}

                      {{ Form::hidden('entrada_id', null, ['class'=>'form-control', 'id'=>'entrada_id'])}}
                      {{ Form::hidden('valor_total', null, ['class'=>'form-control', 'id'=>'valor_total', 'disabled'])}}
                    </div>
                  </div>
                </div>

              </div>

            </div>
          </div>


        </div>
        <div class="modal-footer">
          <div class="row">
            <div class="col-md-6 text-left">
              <h5>Montante Geral da entrada: <b><span class="valor_total_visual" style="color: blue"></span></b></h5>
            </div>
            <div class="col-md-6 text-right">
              {{Form::button('Fechar', ['class'=>'btn btn-default', 'data-dismiss'=>'modal'])}}
              {{Form::submit('Actualizar', ['class'=>'btn btn-primary submit_iten', 'name'=>'submitFormPagamentoEntrada', 'id'=>'submitFormPagamentoEntrada'])}}
            </div>
          </div>



          {{Form::close()}}
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->

  @endsection

  @section('script')
  <script type="text/javascript">

    // DataTables Inicio
  $(document).ready(function() {

    var titulo = "Entradas";   
    var msg_bottom = "Papelaria Agenda & Serviços";

    var oTable = $('#tbl_index_entradas').DataTable( {
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
    $(document).ready(function(){
      $('.submit_iten').on('click',function(){
        $(".wait").css("display", "block");
      });
    });

    $('#modalPagamentoEntrada').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget); 
      var dta_entrada_id = button.data('entrada_id');
      var dta_valor_total = button.data('valor_total');
      var dta_valor_pago = button.data('valor_pago');
      var dta_troco = button.data('troco');
      var dta_forma_pagamento_id = button.data('forma_pagamento_id');
      var dta_nr_documento_forma_pagamento = button.data('nr_documento_forma_pagamento');
      var modal = $(this);

      modal.find('.modal-body #entrada_id').val(dta_entrada_id);
      modal.find('.modal-body #valor_total').val(dta_valor_total);
      modal.find('.modal-body #valor_pago').val(dta_valor_pago);
      modal.find('.modal-body #troco').val(dta_troco);
      modal.find('.modal-body #forma_pagamento_id').val(dta_forma_pagamento_id);
      modal.find('.modal-body #nr_documento_forma_pagamento').val(dta_nr_documento_forma_pagamento);


      var valor_total_visual = (dta_valor_total*1);
      $('.valor_total_visual').html(valor_total_visual.formatMoney(2,',','.')+ " Mtn");

      alertaTrocoPagamento();


    });


    function pagoNaoPago() {
      if (document.getElementById('pago').checked) {
        document.getElementById('div_forma_pagamento').style.display = 'block';
      }
      else document.getElementById('div_forma_pagamento').style.display = 'none';

    };

    $('#valor_pago').keyup(function(){
      alertaTrocoPagamento();
    });

    function alertaTrocoPagamento(){
      var valor_pago = $('#valor_pago').val();
      var valor_total = $('#valor_total').val();
      var troco = valor_pago - valor_total;


      $('#troco').val(troco);


      if( troco < 0 ){
        document.getElementById('troco').style.backgroundColor = "red";
        document.getElementById('troco').style.color = "white";
      }else{
        document.getElementById('troco').style.backgroundColor = "white";
        document.getElementById('troco').style.color = "black";

      }
    }
  </script>
  @endsection
