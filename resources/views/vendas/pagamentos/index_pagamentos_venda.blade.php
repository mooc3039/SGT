@extends('layouts.master')
@section('content')
<div class="row">
  <div class="col-lg-8">
    <h3 class="page-header"><i class="fa fa-file-text-o"></i>Pagamentos da Venda</h3>
    <ol class="breadcrumb">
      <li><i class="fa fa-home"></i><a href="#">Home</a></li>
      <li><i class="fa fa-file-text-o"></i>Pagamentos da Venda</li>
    </ol>
  </div>
  <div class="col-lg-4 text-right">
    <h3>Factura: <b>{{ $venda->id }}</b></h3>
    <h4>Status: <b><span class="info_pagamento"></span></b></h4>
    <h4>Montante Geral da Venda: <b><span class="valor_total_visual" style="color: blue"></span></b></h4>
    <h4>Remanescente: <b><span class="remanescente_visual"  style="color: red"></span></b></h4>
  </div>
</div>

<div class="row">
  <div class="col-lg-12">
    
    <section class="panel panel-default">

      <div class="panel-body">

        {{Form::model($venda, ['route'=>['pagamentoVenda'], 'method'=>'POST', 'onsubmit'=>'submitFormPagamentovenda.disabled = true; return true;'])}}

        <?php

        $valor_pago_soma = 0;
        $remanescente = 0;
        $arry_valor_pago_soma = array();

        foreach($venda->pagamentosVenda as $pagamento){
          $arry_valor_pago_soma[] = $pagamento->valor_pago;
        }

        if(sizeof($arry_valor_pago_soma)<=0){
          $valor_pago_soma = 0;
          $remanescente = $venda->valor_iva - $valor_pago_soma;
        }else{
          $valor_pago_soma = array_sum($arry_valor_pago_soma);
          $remanescente = $venda->valor_iva - $valor_pago_soma;
        }

        ?>

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
                    {{ Form::label('valor_pago', 'Valor a Pagor')}}
                    <div class="input-group">
                      {{ Form::text('valor_pago', null, ['class'=>'form-control', 'id'=>'valor_pago', 'readonly'])}}

                      {{ Form::hidden('valor_remanescente_ref', $remanescente, ['class'=>'form-control', 'id'=>'valor_remanescente_ref'])}}
                      <div class="input-group-addon">Mtn</div>
                    </div>            
                  </div>
                  <div class="col-md-6">
                    {{ Form::label('remanescente', 'Remanescente')}}
                    <div class="input-group">
                      {{ Form::text('remanescente', null, ['class'=>'form-control', 'id'=>'remanescente', 'readonly'])}}
                      <div class="input-group-addon">Mtn</div>
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

                    {{ Form::hidden('venda_id', $venda->id, ['class'=>'form-control', 'id'=>'venda_id'])}}
                    {{ Form::hidden('valor_iva', null, ['class'=>'form-control', 'id'=>'valor_total_iva'])}}

                    {{ Form::hidden('pago', $venda->pago, ['class'=>'form-control', 'id'=>'pago', 'disabled'])}}

                    {{ Form::hidden('pago_total_iva_info', $venda->valor_iva, ['class'=>'form-control', 'id'=>'pago_total_iva_info', 'disabled'])}}

                    {{ Form::hidden('valor_pago_soma', $valor_pago_soma, ['class'=>'form-control', 'id'=>'valor_pago_soma', 'disabled'])}}
                  </div>
                </div>
              </div>

            </div>

          </div>
        </div>

        <div class="row">
          <div class="col-md-6">
            {{Form::submit('Actualizar', ['class'=>'btn btn-primary submit_iten', 'name'=>'submitFormPagamentovenda', 'id'=>'submitFormPagamentovenda'])}}
          </div>
        </div>
        {{Form::close()}}

        <div class="row">
          <div class="col-md-12">
            <br><br>
            <legend>Pagamentos <span><i class="fa fa-caret-down"></i></span></legend>
            <table class="table table-striped table-advance table-hover">

              <thead>
                <tr>
                  <th><i class="icon_profile"></i>Forma de Pagamento</th>
                  <th><i class="icon_cogs"></i> Documento </th>
                  <th><i class="icon_cogs"></i> Valor Pago </th>
                  <th><i class="icon_cogs"></i> Data Pagamento </th>
                  <th><i class="icon_cogs"></i> Data Actualizacao </th>
                </tr>
              </thead>

              <tbody>

                @foreach($venda->pagamentosvenda as $pagamento_venda)
                @if($pagamento_venda->valor_pago > 0)
                <tr>
                  <td>
                    {{ $pagamento_venda->formaPagamento->descricao}}
                  </td>
                  <td>
                    {{ $pagamento_venda->nr_documento_forma_pagamento}}
                  </td>
                  <td>
                    {{ $pagamento_venda->valor_pago}}
                  </td>
                  <td>
                    {{ date('d-m-Y', strtotime($pagamento_venda->created_at))}}
                  </td>
                  <td>
                    {{ $pagamento_venda->updated_at}}
                  </td>
                </tr>
                @endif
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
          <div class="col-md-6 text-right">
            <a href="{{ route('venda.index')}}" class="btn btn-warning">Voltar</a>
          </div>
        </div>


      </div>

    </section>
  </div>
</div>

@endsection

@section('script')
<script type="text/javascript">
  $(document).ready(function(){
    $('.submit_iten').on('click',function(){
      $(".wait").css("display", "block");


      if (document.getElementById('pago').checked) {
        if($('#pago').val() === "" || $('#valor_pago').val() === null){
          alert('Informe o Valor a Pagar');
          $(".wait").css("display", "none");
          $('#valor_pago').focus();
          return false;
        }
      }

      if($('#forma_pagamento_id').val() === "" || $('#forma_pagamento_id').val() === null){
        alert('Selecione a Forma de Pagamento');
        $(".wait").css("display", "none");
        $('#forma_pagamento_id').focus();
        return false;
      }

      if($('#nr_documento_forma_pagamento').val() === "" || $('#nr_documento_forma_pagamento').val() === null){
        alert('Informe o Número do Documento para o Pagamento da Factura, ou o valor padrao (Não Aplicavel)');
        $(".wait").css("display", "none");
        $('#nr_documento_forma_pagamento').focus();
        return false;
      }
    });

    var valor_total_visual = ($('#valor_total_iva').val()*1);
    $('.valor_total_visual').html(valor_total_visual.formatMoney(2,',','.')+ " Mtn");
    $('.remanescente_visual').html(($('#valor_remanescente_ref').val()*1).formatMoney(2,',','.')+ " Mtn");
    
    remanescenteRed();

    var pago = $('#pago').val();
    var pago_total_iva_info = $('#pago_total_iva_info').val()*1;
    var valor_pago_soma = $('#valor_pago_soma').val()*1;

    if(pago==1){
      if(valor_pago_soma >= pago_total_iva_info){
        $('.info_pagamento').css("color", "green");
        $('.info_pagamento').html('Paga na Totalidade');
      }else{
        $('.info_pagamento').css("color", "red");
        $('.info_pagamento').html('Paga Parcialmente');
      }
    }else{
      $('.info_pagamento').css("color", "red");
      $('.info_pagamento').html('Nao Paga');
    }
    console.log(pago);
  });



  function pagoNaoPago() {
    if (document.getElementById('pago').checked) {
      document.getElementById('div_forma_pagamento').style.display = 'block';
      // resetPagoChecked();
      pagamentoTotal();
    }
    else if(document.getElementById('nao_pago').checked){
      document.getElementById('div_forma_pagamento').style.display = 'none';
      // resetPagamento();
      resetPagamentoTotal();
    }
  }

  function pagamentoTotal(){
    $('#forma_pagamento_id').val('');
    $('#nr_documento_forma_pagamento').val('');

    var valor_total_iva = ($('#valor_total_iva').val()*1);
    var remanescente = 0;
    $('#valor_pago').val(valor_total_iva);
    $('#remanescente').val(remanescente);
  }

  function resetPagamentoTotal(){
    var valor_total_iva = 0;
    var remanescente = ($('#valor_total_iva').val()*1);
    $('#valor_pago').val(0);
    $('#remanescente').val(remanescente);
    $('#forma_pagamento_id').val(1); // codigo da forma de pagamento (Nao Aplicavel=>DB)
    $('#nr_documento_forma_pagamento').val('Nao Aplicavel');
  }

  // function resetPagoChecked(){
  //   $('#valor_pago').val(0);
  //   $('#forma_pagamento_id').val('');
  //   $('#nr_documento_forma_pagamento').val('');
  // }

  // function resetPagamento(){
  //    $('#forma_pagamento_id').val(1); // codigo da forma de pagamento (Nao Aplicavel=>DB)
  //    $('#nr_documento_forma_pagamento').val('Nao Aplicavel');
  //    $('#remanescente').val($('#valor_remanescente_ref').val()*1);
  //    $('#valor_pago').val(0);
  //  }

  // $('#valor_pago').keyup(function(){
  //   alertaremanescentePagamento();
  // });

//   function alertaremanescentePagamento(){
//     var valor_remanescente_ref = ($('#valor_remanescente_ref').val()*1);
//     var valor_pago = $('#valor_pago').val()*1;
//     var remanescente = valor_remanescente_ref - valor_pago;

//     if(remanescente >= 0){
//      $('#remanescente').val(remanescente);
//      $('.remanescente_visual').html(remanescente*(1).formatMoney(2,',','.')+ " Mtn");
//    }else{
//     if(valor_pago > valor_remanescente_ref){ 
//       // ou remanscente < 0, significa q o valor pago eh maior q o remanescente_ref
//       alert('O Valor informado e maior do que o valor remanescente(Divida)');
//       $('#valor_pago').val(0);
//       $('#remanescente').val(valor_remanescente_ref);
//       $('.remanescente_visual').html(valor_remanescente_ref*(1).formatMoney(2,',','.')+ " Mtn");

//     }
//   }
// }

function remanescenteRed(){
  document.getElementById('remanescente').style.backgroundColor = "red";
  document.getElementById('remanescente').style.color = "white";
}

// function remanescenteWhite(){
//   document.getElementById('remanescente').style.backgroundColor = "white";
//   document.getElementById('remanescente').style.color = "black";
// }

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

  function number(input){
    $(input).keypress(function (evt){
      var theEvent = evt || window.event;
      var key = theEvent.keyCode || theEvent.which;
      key = String.fromCharCode( key );
      var regex = /[-\d\.]/;
      var objRegex = /^-?\d*[\.]?\d*$/;
      var val = $(evt.target).val();
      if(!regex.test(key) || !objRegex.test(val+key) ||
        !theEvent.keyCode == 46 || !theEvent.keyCode == 8){
        theEvent.returnValue = false;
      if(theEvent.preventDefault) theEvent.preventDefault();
    };
  });
  };

  number('#valor_pago');

</script>
@endsection

