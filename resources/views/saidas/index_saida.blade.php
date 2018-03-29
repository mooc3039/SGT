@extends('layouts.master')
@section('content')
<div class="row">
  <div class="col-lg-12">
    <h3 class="page-header"><i class="fa fa-file-text-o"></i>Facturas</h3>
    <ol class="breadcrumb">
      <li><i class="fa fa-home"></i><a href="#">Home</a></li>
      <li><i class="icon_document_alt"></i>Facturas</li>
    </ol>
  </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <section class="panel panel-default">
      <div class="panel-body">
        <div class="row" style="margin-bottom: 10px">
          <div class="col-md-12">
            <a href="{{ route('saida.create') }}" class="btn btn-primary btn-sm" data-toggle="confirmation" data-title="Open Google?"><i class="fa fa-plus"></i> Privado</a>
            <a href="{{ route('saidaPublicoCreate') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Publico</a>
            <a href="{{ route('saidaConcursoCreate') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Concurso</a>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <table class="table table-striped table-advance table-hover">
              <thead>
                <tr>
                  <th><i class="icon_profile"></i>Código da Factura </th>
                  <th><i class="icon_mobile"></i> Refe </th>
                  <th><i class="icon_mobile"></i> Concur </th>
                  <th><i class="icon_mobile"></i> Data de Emissão </th>
                  <th><i class="icon_mail_alt"></i> Cliente </th>
                  <th><i class="icon_mail_alt"></i> Valor Total </th>
                  <th><i class="icon_mail_alt"></i> Pagamento & Guia de Entrega </th>
                  <th class="text-right"><i class="icon_cogs"></i> Operações </th>
                </tr>
              </thead>
              <tbody>
                @foreach($saidas as $saida)
                <tr>
                  <td> <a href="{{ route('show_guia_entrega', $saida->id) }}" data-toggle="tooltip" data-placement="right" title="Guias de Entrega">{{$saida->id}}</a> </td>
                  <td> {{$saida->nr_referencia}} </td>
                  <td> {{$saida->concurso_id}} </td>
                  <td> {{$saida->data}} </td>
                  <td> {{$saida->cliente->nome}} </td>
                  <td> {{$saida->valor_iva}} </td>
                  <!-- Abertura para o form destroy. Aberto aqui e nao mais abaixo para melhor estetica do btn-group. Existe apenas um submit dentro deste codigo, como nao eh apenas o ofrmulario aqui -->
                  {{ Form::open(['route'=>['saida.destroy', $saida->id], 'method'=>'DELETE']) }} 
                  <td>
                    <div class="btn-group btn-group-sm">
                      <!-- <button type="button" data-toggle="modal" data-target="#modalPagamentoSaida" data-saida_id={{ $saida->id }} data-valor_total={{ $saida->valor_total }} data-valor_pago={{ $saida->valor_pago }} data-remanescente={{ $saida->remanescente }} data-forma_pagamento_id={{ $saida->forma_pagamento_id }} data-nr_documento_forma_pagamento={{ $saida->nr_documento_forma_pagamento }} -->
                        <a href="{{route('createPagamentoSaida', $saida->id)}}"

                          <?php
                          $valor_pago_soma = 0;
                          $arry_valor_pago_soma = array();

                          foreach($saida->pagamentosSaida as $pagamento){
                            $arry_valor_pago_soma[] = $pagamento->valor_pago;
                          }

                          if(sizeof($arry_valor_pago_soma)<0){
                            $valor_pago_soma = 0;
                          }else{
                            $valor_pago_soma = array_sum($arry_valor_pago_soma);
                          }


                          if($saida->concurso_id != 0){
                            // Se for concurso entao, botao default
                            echo 'class="btn btn-default btn-sm"'; 
                            echo 'disabled';
                          }else{
                            if(($saida->pago==1 && ($valor_pago_soma >= $saida->valor_iva))){ 
                              echo 'class="btn btn-success btn-sm"';
                            }else{
                              echo 'class="btn btn-danger btn-sm"';
                            }
                          }

                          ?>
                          >
                          <!-- > -->
                          Pagamento

                          <?php

                          if($saida->concurso_id != 0){
                            echo '<i class="fa fa-warning"></i>';
                          }else{
                            if(($saida->pago==1 && ($valor_pago_soma >= $saida->valor_iva))){

                              echo '<i class="fa fa-check"></i>';
                            }else{
                              echo '<i class="icon_close_alt2"></i>';
                            }

                          }
                          
                          ?>
                        </a>
                        <!-- </button> -->


                        @php
                        $som_quantidade_rest = 0;
                        @endphp

                        @foreach($saida->itensSaida as $iten_saida)
                        @php
                        $som_quantidade_rest = $som_quantidade_rest + $iten_saida->quantidade_rest
                        @endphp
                        @endforeach

                        @if($som_quantidade_rest <= 0)
                        {{Form::button('Factura Fechada', ['class'=>'btn btn-warning btn-sm', 'style'=>'width:110px', 'data-toggle'=>'confirmation', 'data-title'=>'Open Google?'])}}
                        @else
                        <a href="{{ route('create_guia', $saida->id)}}" class="btn btn-default btn-sm" style="width:110px">Guia de Entrega</a>
                        @endif
                      </div>

                    </td>
                    <td class="text-right">


                      <div class="btn-group btn-group-sm">
                        <a class="btn btn-primary" href="{{route('saida.show', $saida->id)}}"><i class="fa fa-eye"></i></a>
                        <a class="btn btn-success" href="{{route('saida.edit', $saida->id)}}"
                          @if($saida->concurso_id != 0)
                          {{ 'disabled' }}
                          @endif
                          @if($saida->pago==1)
                          {{ 'disabled' }}
                          @endif
                          >
                          <i class="fa fa-pencil"></i>
                        </a>

                          <button type="submit" class="btn btn-danger submit_iten"
                          @if($saida->concurso_id != 0)
                          {{ 'disabled' }}
                          @endif
                          >
                            <i class="icon_close_alt2"></i>
                          </button>

                        </div>

                      </td>
                      {{ Form::close() }}

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
                {{ $saidas->links() }}
              </div>
            </div>
          </div>

        </section>
      </div>
    </div>

    <!-- Modal Pagamento -->
    <div class="modal fade" tabindex="-1" role="dialog" id="modalPagamentoSaida">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><b>Facturação: </b>Pagamento</h4>
          </div>
          <div class="modal-body">

            {{Form::open(['route'=>['pagamentoSaida'], 'method'=>'POST', 'onsubmit'=>'submitFormPagamentoSaida.disabled = true; return true;'])}}

            <div class="row">
              <div class="col-md-12">
                <legend>Valor a Pagar: <span class="valor_remanescente_visual pull-right" style="color: blue"></span></legend>
                <div class="row" style="margin-bottom: 5px">
                  <div class="col-md-4">
                    <div class="radio-inline">
                      <!-- {{Form::radio('pago', '1', ['id'=>'pago', 'onclick'=>'javascript:pagoNaoPago();'])}} Pago -->
                      <input type="radio" onclick="javascript:pagoNaoPago();" name="pago" value="1" id="pago"><label for="pago">Pago</label>
                    </div>
                    <div class="radio-inline">
                      <!-- {{Form::radio('pago', '0', ['id'=>'nao_pago', 'onclick'=>'javascript:pagoNaoPago();'])}} Não Pago -->
                      <input type="radio" onclick="javascript:pagoNaoPago();" name="pago" value="0" id="nao_pago"> <label for="nao_pago">Não Pago</label>
                    </div>

                  </div>

                  <div class="col-md-8" id="div_forma_pagamento" style="display:none">
                    <div class="row">
                      <div class="col-md-6">
                        {{ Form::label('valor_pago', 'Valor a Pago')}}
                        <div class="input-group">
                          {{ Form::text('valor_pago', null, ['class'=>'form-control', 'id'=>'valor_pago'])}}

                          {{ Form::hidden('valor_remanescente_ref', null, ['class'=>'form-control', 'id'=>'valor_remanescente_ref'])}}
                          <div class="input-group-addon">$</div>
                        </div>            
                      </div>
                      <div class="col-md-6">
                        {{ Form::label('remanescente', 'Remanescente')}}
                        <div class="input-group">
                          {{ Form::text('remanescente', null, ['class'=>'form-control', 'id'=>'remanescente', 'readonly'])}}
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

                        {{ Form::hidden('saida_id', null, ['class'=>'form-control', 'id'=>'saida_id'])}}
                        {{ Form::hidden('valor_total', null, ['class'=>'form-control', 'id'=>'valor_total'])}}
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
                <h5>Montante Geral da Venda: <b><span class="valor_total_visual" style="color: blue"></span></b></h5>
              </div>
              <div class="col-md-6 text-right">
                {{Form::button('Fechar', ['class'=>'btn btn-default', 'data-dismiss'=>'modal'])}}
                {{Form::submit('Actualizar', ['class'=>'btn btn-primary submit_iten', 'name'=>'submitFormPagamentoSaida', 'id'=>'submitFormPagamentoSaida'])}}
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
      $(document).ready(function(){
        $('.submit_iten').on('click',function(){
          $("#wait").css("display", "block");

          if (document.getElementById('pago').checked) {
            if($('#valor_pago').val() === "" || $('#valor_pago').val() === null){
              alert('Informe o Valor a Pagar');
              $("#wait").css("display", "none");
              $('#valor_pago').focus();
              return false;
            }
          }


          if($('#forma_pagamento_id').val() === "" || $('#forma_pagamento_id').val() === null){
            alert('Selecione a Forma de Pagamento');
            $("#wait").css("display", "none");
            $('#forma_pagamento_id').focus();
            return false;
          }

          if($('#nr_documento_forma_pagamento').val() === "" || $('#nr_documento_forma_pagamento').val() === null){
            alert('Informe o Número do Documento para o Pagamento da Factura, ou o valor padrao (Não Aplicavel)');
            $("#wait").css("display", "none");
            $('#nr_documento_forma_pagamento').focus();
            return false;
          }
        });
      });

      $('#modalPagamentoSaida').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); 
        var dta_saida_id = button.data('saida_id');
        var dta_valor_total = button.data('valor_total');
        var dta_valor_pago = button.data('valor_pago');
        var dta_remanescente = button.data('remanescente');
        var dta_forma_pagamento_id = button.data('forma_pagamento_id');
        var dta_nr_documento_forma_pagamento = button.data('nr_documento_forma_pagamento');
        var modal = $(this);

        modal.find('.modal-body #saida_id').val(dta_saida_id);
        modal.find('.modal-body #valor_total').val(dta_valor_total);
        modal.find('.modal-body #valor_pago').val('');
        modal.find('.modal-body #valor_remanescente_ref').val(dta_remanescente);
        modal.find('.modal-body #remanescente').val(dta_remanescente);
        modal.find('.modal-body #forma_pagamento_id').val(dta_forma_pagamento_id);
        modal.find('.modal-body #nr_documento_forma_pagamento').val(dta_nr_documento_forma_pagamento);


        var valor_total_visual = (dta_valor_total*1);
        var valor_remanescente_visual = (dta_remanescente*(-1));
        $('.valor_total_visual').html(valor_total_visual.formatMoney(2,',','.')+ " Mtn");
        $('.valor_remanescente_visual').html(valor_remanescente_visual.formatMoney(2,',','.')+ " Mtn");
      });


      function pagoNaoPago() {
        if (document.getElementById('pago').checked) {
          document.getElementById('div_forma_pagamento').style.display = 'block';
          alertaremanescentePagamento();
        }
        else{
          document.getElementById('div_forma_pagamento').style.display = 'none';
          $('#remanescente').val($('#valor_total').val()*(-1));
        }
      };

      $('#valor_pago').keyup(function(){
        alertaremanescentePagamento();
      });

      function alertaremanescentePagamento(){
        var valor_remanescente_ref = ($('#valor_remanescente_ref').val()*(-1));
        var valor_pago = $('#valor_pago').val();
        var remanescente = valor_pago - valor_remanescente_ref;


        $('#remanescente').val(remanescente);


        if( remanescente < 0 ){
          remanescenteRed();
        }else{
          remanescenteWhite();

        }

        if(valor_pago > valor_remanescente_ref){
          alert('O Valor informado e maior do que o valor remanescente(Divida)');
          $('#valor_pago').val(0);
          $('#remanescente').val($('#valor_remanescente_ref').val());

          if( $('#valor_remanescente_ref').val() < 0 ){
            remanescenteRed();
          }else{
            remanescenteWhite();

          }
        }
      }

      function remanescenteRed(){
        document.getElementById('remanescente').style.backgroundColor = "red";
        document.getElementById('remanescente').style.color = "white";
      }

      function remanescenteWhite(){
        document.getElementById('remanescente').style.backgroundColor = "white";
        document.getElementById('remanescente').style.color = "black";
      }

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

  // ==== formatando os numeros ====
  Number.prototype.formatMoney = function(decPlaces, thouSeparator, decSeparator){
    var n = this,
    decPlaces = isNaN(decPlaces = Math.abs(decPlaces)) ? 2 : decPlaces,
    decSeparator = decSeparator == undefined ? ".": decSeparator,
    thouSeparator = thouSeparator == undefined ? ",": thouSeparator,
    sign = n < 0 ? "-" : "",
    i = parseInt(n = Math.abs(+n || 0).toFixed(decPlaces)) + "",
    j = (j = i.length) > 3 ? j % 3 : 0;
    return sign + (j ? i.substr(0,j) + thouSeparator : "")
    + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thouSeparator)
    + (decPlaces ? decSeparator + Math.abs(n-i).toFixed(decPlaces).slice(2) : "");
  };

</script>
@endsection
