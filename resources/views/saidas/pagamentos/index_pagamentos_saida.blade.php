@extends('layouts.master')
@section('content')
<div class="row">
  <div class="col-lg-8">
    <h3 class="page-header"><i class="fa fa-file-text-o"></i>Pagamentos da Saida</h3>
    <ol class="breadcrumb">
      <li><i class="fa fa-home"></i><a href="#">Home</a></li>
      <li><i class="fa fa-file-text-o"></i>Pagamentos da Saida</li>
    </ol>
  </div>
  <div class="col-lg-4 text-right">
    <h3>Factura: <b>{{ $saida->codigo }}</b></h3>
    <h4>Status: <b><span class="info_pagamento"></span></b></h4>
    <h4>Montante Geral da Factura: <b><span class="valor_total_visual" style="color: blue"></span></b></h4>
    <h4>Remanescente: <b><span class="remanescente_visual" style="color: red"></span></b></h4>
  </div>
</div>

<div class="row">
  <div class="col-lg-12">

    <section class="panel panel-default">

      <div class="panel-body">

        {{Form::model($saida, ['route'=>['pagamentoSaida'], 'method'=>'POST', 'onsubmit'=>'submitFormPagamentoSaida.disabled = true; return true;'])}}
        <?php

        $valor_total = $saida->valor_iva;
        $valor_pago_soma = 0;
        $remanescente = 0;
        $arry_valor_pago_soma = array();

        if($saida->aplicacao_motivo_iva == 1){
          $valor_total = $saida->valor_total;
        }

        foreach($saida->pagamentosSaida as $pagamento){
          $arry_valor_pago_soma[] = $pagamento->valor_pago;
        }

        if(sizeof($arry_valor_pago_soma)<=0){
          $valor_pago_soma = 0;
          $remanescente = $valor_total - $valor_pago_soma;
        }else{
          $valor_pago_soma = array_sum($arry_valor_pago_soma);
          $remanescente = $valor_total - $valor_pago_soma;
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
                    {{ Form::label('valor_pago', 'Valor a Pago')}}
                    <div class="input-group">
                      {{ Form::text('valor_pago', null, ['class'=>'form-control', 'id'=>'valor_pago'])}}

                      {{ Form::hidden('valor_remanescente_ref', $remanescente, ['class'=>'form-control', 'id'=>'valor_remanescente_ref'])}}
                      <div class="input-group-addon">Mtn</div>
                    </div>            
                  </div>
                  <div class="col-md-6">
                    {{ Form::label('remanescente', 'Remanescente')}}
                    <div class="input-group">
                      {{ Form::text('remanescente', null, ['class'=>'form-control remanescente', 'id'=>'remanescente', 'readonly'])}}
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

                    {{ Form::hidden('saida_id', $saida->id, ['class'=>'form-control', 'id'=>'saida_id'])}}
                    {{ Form::hidden('valor_total', $valor_total, ['class'=>'form-control', 'id'=>'valor_total'])}}

                    {{ Form::hidden('pago', $saida->pago, ['class'=>'form-control', 'id'=>'pago', 'disabled'])}}

                    {{ Form::hidden('valor_total_info', $valor_total, ['class'=>'form-control', 'id'=>'valor_total_info', 'disabled'])}}

                    {{ Form::hidden('valor_pago_soma', $valor_pago_soma, ['class'=>'form-control', 'id'=>'valor_pago_soma', 'disabled'])}}
                  </div>
                </div>
              </div>

            </div>

          </div>
        </div>

        <div class="row">
          <div class="col-md-6">
            {{Form::submit('Actualizar', ['class'=>'btn btn-primary submit_iten', 'name'=>'submitFormPagamentoSaida', 'id'=>'submitFormPagamentoSaida'])}}
          </div>
        </div>
        {{Form::close()}}

        <div class="row">
          <div class="col-md-12">
            <br><br>
            <legend>Listagem de Pagamentos <span><i class="fa fa-caret-down"></i></span></legend>

            <div class="row" style="margin-bottom: 10px">
              <div class="col-md-8">
              </div>
              <div class="col-md-4">
                <input type="text" id="pesq" class="form-control" placeholder="Pesquisa...">
              </div>
            </div>

            <table class="table table-striped table-advance table-hover" id="tbl_index_pagamentos_saida" data-order='[[ 3, "desc" ]]'>

              <thead>
                <tr>
                  <th> Forma de Pagamento</th>
                  <th> Documento </th>
                  <th> Valor Pago (Mtn) </th>
                  <th> Data Pagamento </th>
                  <th> Data Actualizacao </th>
                  <th> Recibo </th>
                </tr>
              </thead>

              <tbody>

                @foreach($saida->pagamentosSaida as $pagamento_saida)
                @if($pagamento_saida->valor_pago > 0)
                <tr>
                  <td>
                    {{ $pagamento_saida->formaPagamento->descricao}}
                  </td>
                  <td>
                    {{ $pagamento_saida->nr_documento_forma_pagamento}}
                  </td>
                  <td>
                    {{ number_format($pagamento_saida->valor_pago, 2, '.', ',')}}
                  </td>
                  <td>
                    {{ date('d-m-Y', strtotime($pagamento_saida->created_at))}}
                  </td>
                  <td>
                    {{ date('d-m-Y H:m:s', strtotime($pagamento_saida->updated_at))}}
                  </td>
                  <td>

                    {{Form::open()}}

                    <div class="btn-group btn-group-sm">
                      <a href="{{route('show_recibo_saida', [$pagamento_saida->saida_id, $pagamento_saida->id])}}" class="btn btn-info btn-sm">
                      <i class="fa fa-eye"></i>
                      Visualizar
                    </a>

                    <div class="btn-group btn-group-sm">
                      <a href="{{route('imprimir_recibo_pagamento', [$pagamento_saida->saida_id, $pagamento_saida->id])}}" class="btn btn-info btn-sm">
                      <i class="fa fa-print"></i>
                      Imprimir
                    </a>

                      <!-- {{Form::hidden('pagamento_saida_id', $pagamento_saida->id)}}
                      {{Form::button('<i class="fa fa-print"></i> Imprimir', ['type'=>'submit', 'class'=>'btn btn-success btn-sm', 'name'=>'submitFormReciboPagamentoSaida', 'id'=>'submitFormReciboPagamentoSaida'])}} -->

                    </div>

                    {{Form::close()}}
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
            <a href="{{ route('saida.index')}}" class="btn btn-warning">Voltar</a>
          </div>
        </div>


      </div>

    </section>
  </div>
</div>

{{Form::hidden('codigo_saida', $saida->id, ['id'=>'codigo_saida', 'disabled'])}}

@endsection

@section('script')
<script type="text/javascript">

  // DataTables Inicio
  $(document).ready(function() {

    var codigo_saida = $('#codigo_saida').val();
    var titulo = "Pagamentos da Factura "+codigo_saida;   
    var msg_bottom = "Papelaria Agenda & Serviços";

    var oTable = $('#tbl_index_pagamentos_saida').DataTable( {
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

      if (document.getElementById('pago').checked) {
        if($('#valor_pago').val() === "" || $('#valor_pago').val() === null){
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

    var valor_total_visual = Number.parseFloat($('#valor_total').val());
    $('.valor_total_visual').html(valor_total_visual.formatMoney()+ " Mtn");
    resetPagamento(); // Faz o reset dos campos "pagamento" ao carregar a pagina para permitir o alertaremanescentePagamento()...correcto
    alertaremanescentePagamento();
    remanescenteRed();

    var pago = $('#pago').val();
    var valor_total_info = Number.parseFloat(($('#valor_total_info').val()).replace(/[^0-9-.]/g, ''));
    var valor_pago_soma = Number.parseFloat(($('#valor_pago_soma').val()).replace(/[^0-9-.]/g, ''));

    if(pago==1){
      if(valor_pago_soma >= valor_total_info){
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
    // console.log(valor_pago_soma);
  });



  function pagoNaoPago() {
    if (document.getElementById('pago').checked) {
      document.getElementById('div_forma_pagamento').style.display = 'block';
      resetPagoChecked();
      
    }
    else if(document.getElementById('nao_pago').checked){
      document.getElementById('div_forma_pagamento').style.display = 'none';
      resetPagamento();
    }
  };

  function resetPagoChecked(){
    $('#valor_pago').val(Number.parseFloat(0).toFixed(2));
    $('#forma_pagamento_id').val('');
    $('#nr_documento_forma_pagamento').val('');
  }

  function resetPagamento(){
     $('#forma_pagamento_id').val(1); // codigo da forma de pagamento (Nao Aplicavel=>DB)
     $('#nr_documento_forma_pagamento').val('Nao Aplicavel');
     $('#remanescente').val(Number.parseFloat($('#valor_remanescente_ref').val()).formatMoney()); // sem necessidade, o tratamento do remanesc.. eh feito no controler com o valor_iva quando o reset eh feto
     $('#valor_pago').val(Number.parseFloat(0).toFixed(2));
   }

   $('#valor_pago').keyup(function(){
    alertaremanescentePagamento();
  });

   function alertaremanescentePagamento(){
    var valor_remanescente_ref = Number.parseFloat(($('#valor_remanescente_ref').val()));
    var valor_pago = Number.parseFloat(($('#valor_pago').val()).replace(/[^0-9-.]/g, '')); // input editavel
    var remanescente = Number.parseFloat((valor_remanescente_ref - valor_pago));

    if($('#valor_pago').val() === "" || $('#valor_pago').val() === null){
          $('#remanescente').val(Number.parseFloat(valor_remanescente_ref).formatMoney());
          $('.remanescente_visual').html(valor_remanescente_ref.formatMoney()+ " Mtn");
        }

    if(remanescente >= 0){
     $('#remanescente').val(remanescente.formatMoney());
     $('.remanescente_visual').html(remanescente.formatMoney()+ " Mtn");
   }else{
    if(valor_pago > valor_remanescente_ref){ 
      // ou remanscente < 0, significa q o valor pago eh maior q o remanescente_ref
      alert('O Valor informado e maior do que o valor remanescente(Divida)');
      $('#valor_pago').val(Number.parseFloat(0).formatMoney());
      $('#remanescente').val(valor_remanescente_ref.formatMoney());
      $('.remanescente_visual').html(valor_remanescente_ref.formatMoney()+ " Mtn");
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
  // Number.prototype.formatMoney = function(decPlaces, thouSeparator, decSeparator){
  //   var n = this,
  //   decPlaces = isNaN(decPlaces = Math.abs(decPlaces)) ? 2 : decPlaces,
  //   decSeparator = decSeparator == undefined ? ".": decSeparator,
  //   thouSeparator = thouSeparator == undefined ? ",": thouSeparator,
  //   sign = n < 0 ? "-" : "",
  //   i = parseInt(n = Math.abs(+n || 0).toFixed(decPlaces)) + "",
  //   j = (j = i.length) > 3 ? j % 3 : 0;
  //   return sign + (j ? i.substr(0,j) + thouSeparator : "")
  //   + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thouSeparator)
  //   + (decPlaces ? decSeparator + Math.abs(n-i).toFixed(decPlaces).slice(2) : "");
  // };

//   Number.prototype.formatMoney = function(places, symbol, thousand, decimal) {
//   places = !isNaN(places = Math.abs(places)) ? places : 2;
//   symbol = symbol !== undefined ? symbol : "";
//   thousand = thousand || ",";
//   decimal = decimal || ".";
//   var number = this, 
//       negative = number < 0 ? "-" : "",
//       i = parseInt(number = Math.abs(+number || 0).toFixed(places), 10) + "",
//       j = (j = i.length) > 3 ? j % 3 : 0;
//   return symbol + negative + (j ? i.substr(0, j) + thousand : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousand) + (places ? decimal + Math.abs(number - i).toFixed(places).slice(2) : "");
// };

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

