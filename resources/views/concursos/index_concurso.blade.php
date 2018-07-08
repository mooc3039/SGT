@extends('layouts.master')
@section('content')
<div class="row">
  <div class="col-lg-12">
    <h3 class="page-header"><i class="fa fa-file-text-o"></i>concursos</h3>
    <ol class="breadcrumb">
      <li><i class="fa fa-home"></i><a href="#">Home</a></li>
      <li><i class="icon_document_alt"></i>concursos</li>
    </ol>
  </div>
</div>

<div class="row">
  <div class="col-lg-12">

    <!-- Processing -->    
    <div class="wait">
      <div class="wait-loader">
        <img src="{{asset('/img/Gear-0.6s-200px.gif')}}"/>
      </div>
    </div>
    <!-- Processing -->
    
    <section class="panel panel-default">
      <div class="panel-body">
        <div class="row" style="margin-bottom: 10px">
          <div class="col-md-8">
            <a href="{{ route('concurso.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
          </div>
          <div class="col-md-4">
            <input type="text" id="pesq" class="form-control" placeholder="Pesquisa...">
          </div>
        </div>

        <table class="table table-striped table-advance table-hover" id="tbl_index_concursos" data-order='[[ 0, "desc" ]]'>
          <thead>
            <tr>
              <th> Código do Concurso </th>
              <th> Data do Concurso </th>
              <th> Cliente </th>
              <th> Valor Total (Mtn)</th>
              <th> Valor Total - IVA (Mtn)</th>
              <th> Pagamento </th>
              <th class="text-right"><i class="icon_cogs"></i> Operações </th>
            </tr>
          </thead>
          <tbody>
            @foreach($concursos as $concurso)
            <tr>
              <td> {{$concurso->codigo_concurso}} </td>
              <td> {{date('d-m-Y', strtotime($concurso->created_at))}} </td>
              <td> {{$concurso->cliente->nome}} </td>
              <td> {{number_format($concurso->valor_total, 2, '.', ',')}} </td>
              <td>
                @if($concurso->aplicacao_motivo_iva == 1)
                {{""}}
                @else
                {{number_format($concurso->valor_iva, 2, '.', ',')}}
                @endif
              </td>
              {{ Form::open(['route'=>['concurso.destroy', $concurso->id], 'method'=>'DELETE']) }}
              <td>
                <!-- <button type="button" data-toggle="modal" data-target="#modalPagamentoConcurso" data-concurso_id={{ $concurso->id }} data-valor_concurso={{ $concurso->valor_concurso }} data-valor_total={{ $concurso->valor_total }} data-forma_pagamento_id={{ $concurso->forma_pagamento_id }} data-nr_documento_forma_pagamento={{ $concurso->nr_documento_forma_pagamento }} -->
                  <a href="{{route('createPagamentoConcurso', $concurso->id)}}"

                    <?php
                    $valor_total = $concurso->valor_iva;
                    $valor_pago_soma = 0;
                    $arry_valor_pago_soma = array();

                    if($concurso->aplicacao_motivo_iva == 1){
                            $valor_total = $concurso->valor_total;
                          }

                    foreach($concurso->pagamentosConcurso as $pagamento){
                      $arry_valor_pago_soma[] = $pagamento->valor_pago;
                    }

                    if(sizeof($arry_valor_pago_soma)<0){
                      $valor_pago_soma = 0;
                    }else{
                      $valor_pago_soma = array_sum($arry_valor_pago_soma);
                    }



                    if(($concurso->pago==1 && ($valor_pago_soma >= $valor_total))){ 
                      echo 'class="btn btn-success btn-sm"';
                    }else{
                      echo 'class="btn btn-danger btn-sm"';
                    }

                    if($concurso->concurso_id != 0){
                      echo 'disabled';
                    }

                    ?>
                    >
                    <!-- > -->
                    Pagamento

                    <?php

                    if(($concurso->pago==1 && ($valor_pago_soma >= $valor_total))){

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

                    <a class="btn btn-primary" href="{{route('concurso.show', $concurso->id)}}"><i class="fa fa-eye"></i></a>
                    <!-- <a class="btn btn-success" href="{{route('concurso.edit', $concurso->id)}}"><i class="fa fa-pencil"></i></a> -->
                    {{ Form::button('<i class="icon_close_alt2"></i>', ['type'=>'submit', 'class'=>'btn btn-danger submit_iten', 'id'=>'apagar_con']) }}

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

  <!-- MODAL PAGAMENTO -->
  <div class="modal fade" tabindex="-1" role="dialog" id="modalPagamentoConcurso">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title"><b>Concurso: </b>Pagamento</h4>
        </div>
        <div class="modal-body">

          {{Form::open(['route'=>['pagamentoConcurso'], 'method'=>'POST', 'onsubmit'=>'submitFormpagamentoConcurso.disabled = true; return true;'])}}

          <div class="row">
            <div class="col-md-12">
              <legend>Valor do Concurso: <span class="valor_concurso_visual pull-right" style="color: blue"></span></legend>
              <div class="row" style="margin-bottom: 5px">
                <div class="col-md-4">
                  <div class="radio-inline">
                    <input type="radio" onclick="javascript:pagoNaoPago();" name="pago" value="1" id="pago"><label for="pago">Pago</label>
                  </div>
                  <div class="radio-inline">
                    <input type="radio" onclick="javascript:pagoNaoPago();" name="pago" value="0" id="nao_pago"> <label for="nao_pago">Não Pago</label>
                  </div>

                </div>

                <div class="col-md-8" id="div_forma_pagamento" style="display:block;">
                  <div class="row">
                    <div class="col-md-6">
                      {{ Form::label('forma_pagamento_id', 'Forma Pgamento')}}
                      {{Form::select('forma_pagamento_id', [''=>'Forma Pgamento',] + $formas_pagamento, null, ['class'=>'form-control', 'id'=>'forma_pagamento_id'] )}}
                    </div>
                    <div class="col-md-6">
                      {{ Form::label('nr_documento_forma_pagamento', 'Documento')}}
                      {{ Form::text('nr_documento_forma_pagamento', null, ['class'=>'form-control', 'id'=>'nr_documento_forma_pagamento'])}}

                      {{ Form::hidden('concurso_id', null, ['class'=>'form-control', 'id'=>'concurso_id'])}}
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
            </div>
            <div class="col-md-6 text-right">
              {{Form::button('Fechar', ['class'=>'btn btn-default', 'data-dismiss'=>'modal'])}}
              {{Form::submit('Actualizar', ['class'=>'btn btn-primary submit_iten', 'name'=>'submitFormpagamentoConcurso', 'id'=>'submitFormpagamentoConcurso'])}}
            </div>
          </div>



          {{Form::close()}}
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
  <!-- MODAL PAGAMENTO -->

  @endsection

  @section('script')
  <script type="text/javascript">

    // DataTables Inicio
    $(document).ready(function() {

      var titulo = "Concursos";   
      var msg_bottom = "Papelaria Agenda & Serviços";

      var oTable = $('#tbl_index_concursos').DataTable( {
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

  $('#modalPagamentoConcurso').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); 
    var dta_concurso_id = button.data('concurso_id');
    var dta_valor_concurso = button.data('valor_concurso');
    var dta_valor_total = button.data('valor_total');
    var dta_forma_pagamento_id = button.data('forma_pagamento_id');
    var dta_nr_documento_forma_pagamento = button.data('nr_documento_forma_pagamento');
    var modal = $(this);

    modal.find('.modal-body #concurso_id').val(dta_concurso_id);
    modal.find('.modal-body #valor_total').val(dta_valor_total);
    modal.find('.modal-body #forma_pagamento_id').val(dta_forma_pagamento_id);
    modal.find('.modal-body #nr_documento_forma_pagamento').val(dta_nr_documento_forma_pagamento);


    var valor_concurso_visual = (dta_valor_concurso*1);
    $('.valor_concurso_visual').html(valor_concurso_visual.formatMoney(2,',','.')+ " Mtn");


  });


  function pagoNaoPago() {
    if (document.getElementById('pago').checked) {
      document.getElementById('div_forma_pagamento').style.display = 'block';
      $('#forma_pagamento_id').val('');
      $('#nr_documento_forma_pagamento').val('');
    }else {
      document.getElementById('div_forma_pagamento').style.display = 'none';
        $('#forma_pagamento_id').val(1); // codigo da forma de pagamento (Nao Aplicavel=>DB)
        $('#nr_documento_forma_pagamento').val('Nao Aplicavel');

      }

    };

    $('#forma_pagamento_id').change(function(){
      var frm_pagamento = document.getElementById('forma_pagamento_id').options[document.getElementById('forma_pagamento_id').selectedIndex].text;
      var res_frm_pagamento = frm_pagamento.toLowerCase();

      if(res_frm_pagamento == "dinheiro"){
        $('#nr_documento_forma_pagamento').val('Nao Aplicavel');
      }else{
        $('#nr_documento_forma_pagamento').focus();
        $('#nr_documento_forma_pagamento').val('');
      }
      
    });
  </script>
  @endsection
