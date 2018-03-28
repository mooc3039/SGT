@extends('layouts.master')
@section('content')
<div class="row">
  <div class="col-lg-12">
    <h3 class="page-header"><i class="fa fa-file-text-o"></i>Vendas</h3>
    <ol class="breadcrumb">
      <li><i class="fa fa-home"></i><a href="#">Home</a></li>
      <li><i class="icon_document_alt"></i>Vendas</li>
    </ol>
  </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <div id="wait" style=" 
    text-align: center; 
    z-index: 1; 
    display:none;
    width:100%;
    height:100%;
    position:absolute;
    top:0;
    left:0;
    padding:5px;">

    <div id="wait-loader" style="
    position:absolute;    
    left:40%;
    top:40%;
    font-size: 50px; 
    color: blue;">
    <!-- <i class="fa fa-plus text-center"> -->
      <img src="{{asset('/img/Gear-0.6s-200px.gif')}}"/>
    </i>
    <!-- <h2>Aguarde...</h2> -->
  </div>
</div>
<section class="panel panel-default">
      <!-- <header class="panel-heading">
        Vendas
      </header> -->
      <div class="panel-body">
        <div class="row" style="margin-bottom: 10px">
          <div class="col-md-12">
            <a href="{{ route('venda.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <table class="table table-striped table-advance table-hover">
              <thead>
                <tr>
                  <th><i class="icon_profile"></i>Código da Venda </th>
                  <th><i class="icon_mobile"></i> Data de Emissão </th>
                  <th><i class="icon_mail_alt"></i> Cliente </th>
                  <th><i class="icon_mail_alt"></i> Valor Total </th>
                  <th><i class="icon_mail_alt"></i> Pagamento </th>
                  <th class="text-right"><i class="icon_cogs"></i> Operações </th>
                </tr>
              </thead>
              <tbody>
                @foreach($vendas as $venda)
                <tr>
                  <td> <a href="{{ route('show_guia_entrega', $venda->id) }}">{{$venda->id}}</a> </td>
                  <td> {{$venda->created_at}} </td>
                  <td> {{$venda->cliente->nome}} </td>
                  <td> {{$venda->valor_iva}} </td>
                  {{ Form::open(['route'=>['venda.destroy', $venda->id], 'method'=>'DELETE']) }}
                  <td> 
                    <!-- <button type="button" data-toggle="modal" data-target="#modalPagamentoVenda" data-venda_id={{ $venda->id }} data-valor_total={{ $venda->valor_total }} data-valor_pago={{ $venda->valor_pago }} data-troco={{ $venda->troco }} data-forma_pagamento_id={{ $venda->forma_pagamento_id }} data-nr_documento_forma_pagamento={{ $venda->nr_documento_forma_pagamento }} -->
                      <a href="{{route('createPagamentoVenda', $venda->id)}}"

                      <?php
                        $valor_pago_soma = 0;
                        $arry_valor_pago_soma[] = 0;

                        foreach($venda->pagamentosVenda as $pagamento){
                          $arry_valor_pago_soma[] = $pagamento->valor_pago;
                        }

                        if(sizeof($arry_valor_pago_soma)<0){
                          $valor_pago_soma = 0;
                        }else{
                          $valor_pago_soma = array_sum($arry_valor_pago_soma);
                        }



                        if(($venda->pago==1 && ($valor_pago_soma >= $venda->valor_iva))){ 
                          echo 'class="btn btn-success btn-sm"';
                        }else{
                          echo 'class="btn btn-danger btn-sm"';
                        }

                        ?>
                      >

                      <!-- > -->
                      Pagamento

                      <?php

                      if(($venda->pago==1) && ($valor_pago_soma >= $venda->valor_iva) ){
                        echo '<i class="fa fa-check"></i>';
                      }else{
                        echo '<i class="icon_close_alt2"></i>';
                      }

                      ?>
                    </a>
                    <!-- </button> -->

                  </a> 
                </td>
                <td class="text-right">

                  <div class="btn-group btn-group-sm">
                    <a class="btn btn-primary" href="{{route('venda.show', $venda->id)}}"><i class="fa fa-eye"></i></a>
                    <a class="btn btn-success" href="{{route('venda.edit', $venda->id)}}"><i class="fa fa-pencil"></i></a>
                    {{ Form::button('<i class="icon_close_alt2"></i>', ['type'=>'submit', 'class'=>'btn btn-danger submit_iten']) }}

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
          {{ $vendas->links() }}
        </div>
      </div>
    </div>

  </section>
</div>
</div>


<div class="modal fade" tabindex="-1" role="dialog" id="modalPagamentoVenda">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><b>Venda: </b>Pagamento</h4>
      </div>
      <div class="modal-body">

        {{Form::open(['route'=>['pagamentoVenda'], 'method'=>'POST', 'onsubmit'=>'submitFormPagamentoVenda.disabled = true; return true;'])}}

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

                    {{ Form::hidden('venda_id', null, ['class'=>'form-control', 'id'=>'venda_id'])}}
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
            <h5>Montante Geral da Venda: <b><span class="valor_total_visual" style="color: blue"></span></b></h5>
          </div>
          <div class="col-md-6 text-right">
            {{Form::button('Fechar', ['class'=>'btn btn-default', 'data-dismiss'=>'modal'])}}
            {{Form::submit('Actualizar', ['class'=>'btn btn-primary submit_iten', 'name'=>'submitFormPagamentoVenda', 'id'=>'submitFormPagamentoVenda'])}}
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
    });
  });

  $('#modalPagamentoVenda').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); 
    var dta_venda_id = button.data('venda_id');
    var dta_valor_total = button.data('valor_total');
    var dta_valor_pago = button.data('valor_pago');
    var dta_troco = button.data('troco');
    var dta_forma_pagamento_id = button.data('forma_pagamento_id');
    var dta_nr_documento_forma_pagamento = button.data('nr_documento_forma_pagamento');
    var modal = $(this);

    modal.find('.modal-body #venda_id').val(dta_venda_id);
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
