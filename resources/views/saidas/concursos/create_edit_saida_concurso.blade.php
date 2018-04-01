@extends('layouts.master')
@section('content')
<div class="row">
  <div class="col-lg-12">
    <h3 class="page-header"><i class="fa fa-file-text-o"></i>Concursos <b style="color: red"> Concursos</b></h3>
    <ol class="breadcrumb">
      <li><i class="fa fa-home"></i><a href="#">Home</a></li>
      <li><i class="icon_document_alt"></i>Concursos</li>
      <li><i class="fa fa-file-text-o"></i>Gerenciar Concurso</li>
    </ol>
  </div>
</div>

<div class="row">
  <div class="col-lg-12">

    <section class="panel panel-default">
      <div class="panel-body" style="border-bottom: 1px solid #ccc; ">

        {{ Form::open(['route'=>'saida.store', 'method'=>'POST', 'id'=>'form_concurso']) }}

        <div class="row" style="margin-bottom: 20px">
          <div class="col-md-3">
            {{ Form::label('concurso_id', 'Selecione o Concurso')}}
            {{Form::select('concurso_id', [''=>'Concurso',] + $concursos, null, ['class'=>'form-control select_search', 'id'=>'concurso_id'] )}}
          </div>
        </div>
        <div class="row"  id="div_create_saida_concurso" style="display: none;">
          <div class="col-md-12">

            <div class="row" style="margin-bottom: 15px">
              <div class="form-horizontal">
               <div class="col-md-3">
                <legend>Cliente: </legend>
                {{Form::label('cliente_nome', 'Cliente')}}
                {{ Form::text('cliente_nome', null, ['class'=>'form-control','id'=>'cliente_nome', 'disabled'])}}

                {{ Form::hidden('cliente_id', null, ['class'=>'form-control','id'=>'cliente_id'])}}
              </div>
              <div class="col-md-3">
                <div class="row">
                  <div class="col-md-12">
                    <legend>Código do Concurso: </legend>
                    {{ Form::label('codigo_concurso', 'Código do Concurso')}}
                    {{ Form::text('codigo_concurso', null, ['class'=>'form-control','id'=>'codigo_concurso', 'disabled'])}}
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <legend>Pagamento: </legend>
                <div class="row">
                  <div class="col-md-2">
                   {{ Form::label('pago_visual', 'Pago')}}
                   <button class="btn btn-default btn-sm" id="btn_visual_check" disabled style="display: block">
                     <span id="pago_visual"></span>
                   </button>

                   {{Form::hidden('pago', null, ['class'=>'form-control', 'id'=>'pago', 'readonly'] )}}
                 </div>
                 <!-- <div class="col-md-5">
                  {{ Form::label('forma_pagamento_descricao', 'Forma Pgamento')}}

                  {{ Form::text('forma_pagamento_descricao', null, ['class'=>'form-control', 'id'=>'forma_pagamento_descricao', 'disabled'])}}

                  {{ Form::hidden('forma_pagamento_id', null, ['class'=>'form-control', 'id'=>'forma_pagamento_id'])}}
                </div>
                <div class="col-md-5">
                  {{ Form::label('nr_documento_forma_pagamento', 'Documento')}}
                  {{ Form::text('nr_documento_forma_pagamento', null, ['class'=>'form-control', 'id'=>'nr_documento_forma_pagamento', 'readonly'])}}
                </div> -->
              </div>
            </div>
          </div>
        </div>

        <div class="panel-footer">
          {{ Form::hidden('salvar_saida_concurso', 1) }}
          {{Form::submit('Salvar Factura', ['class'=>'btn btn-primary submit_iten'])}}
        </div>


        <!-- começa a secção de cotacao na tabela-->

        <section class="panel">
         <header class="panel-heading">
          Produtos / Itens
        </header>

        <div class="panel-body">
          <table class="table table-striped table-advance table-hover">
            <thead>
              <tr>
                <th><i class="icon_profile"></i> Nome do Produto</th>
                <th><i class="icon_calendar"></i> Qtd/Unidades</th>
                <th><i class="icon_mail_alt"></i> Preço</th>
                <th><i class="icon_mail_alt"></i> Valor</th>
                <th><i class="icon_pin_alt"></i> Desconto</th>
                <th><i class="icon_mobile"></i> Subtotal</th>
              </tr>
            </thead>
            <tbody>

            </tbody>
            <tfoot>

            <tr>
              <td style="border:none"></td>
              <td style="border:none"></td>
              <td style="border:none"></td>
              <td></td>
              <td><b>Subtotal</b></td>
              <td><b><div class="valor_visual" style="border:none"> </div></b></td>
            </tr><tr>
              <td style="border:none"></td>
              <td style="border:none"></td>
              <td style="border:none"></td>
              <td></td>
              <td><b>IVA(17%)</b></td>
              <td><b><div class="iva" style="border:none"> </div></b></td>
            </tr><tr>
              <td style="border:none"></td>
              <td style="border:none"></td>
              <td style="border:none"></td>
              <td></td>
              <td><b>Total</b></td>
              <td><b><div class="valor_visual_iva" style="border:none"> </div></b></td>
            </tr>
          </tfoot>
        </table>
      </div>
      <div class="panel-footer">

      </div>
    </section>
    {{ Form::hidden('valor_total', 0, ['id'=>'valor_total']) }}
    {{ Form::hidden('valor_total_iva', 0, ['id'=>'valor_total_iva']) }}
    {{ Form::hidden('valor_pago', 0, ['id'=>'valor_pago']) }}
    {{ Form::hidden('valor_pago_conc', 0, ['id'=>'valor_pago_conc']) }}
    {{ Form::hidden('remanescente', 0, ['id'=>'remanescente']) }}
    {{ Form::hidden('user_id', Auth::user()->id) }}
    {!!Form::hidden('_token',csrf_token())!!}
    {{ Form::close() }}
  </div>
</div>


</section>
</div>
</div>
<div class="row">
  <div class="col-md-6"></div>
  <div class="col-md-6 text-right">
    <a href="{{ route('saida.index') }}" class="btn btn-warning">Cancelar</a>
  </div>
</div>


@endsection
@section('script')
<script text="text/javascript">

  $(document).ready(function(){
    $('.submit_iten').on('click',function(){
      $(".wait").css("display", "block");
    });
  });


  $(document).ready(function(){
    $(document).ajaxStart(function(){
      $(".wait").css("display", "block");
    });
    $(document).ajaxComplete(function(){
      $(".wait").css("display", "none");
    });
  });


    //------devolver dados do concurso
    $('#concurso_id').change( function(){
      if($('#concurso_id').val() === ""){ // Deve ser selecionada uma opcao valida
        $("#div_create_saida_concurso").css("display", "none");
      }else{

        $('tbody').empty();
      var id = $('#concurso_id').val();
      var dataId={'id':id};
      $.ajax({
        type  : 'POST',
        url   : '{!!URL::route('findConcursoDados')!!}',
        dataType: 'json',
        data  : dataId,
        success:function(data){
          $('#cliente_id').val(data.cliente.id);
          $('#cliente_nome').val(data.cliente.nome);
          $('#codigo_concurso').val(data.codigo_concurso);
          $('#pago').val(data.pago);
          $('#valor_total').val(data.valor_total);
          // preenche o input valor_pago_conc, soma todos valores pagos do pagamentosConcurso
          $('#valor_pago_conc').val(
            valorPagoPagamentosConcurso(data.pagamentos_concurso)
            );
          ; 
          // adiciona os itens do concurso a tabela migrarem para iten de siada
          adicionarItensAtabela(data.itens_concurso);

          

          // $('#forma_pagamento_descricao').val(data.forma_pagamento.descricao);
          // $('#forma_pagamento_id').val(data.forma_pagamento_id);
          // $('#nr_documento_forma_pagamento').val(data.nr_documento_forma_pagamento);
          

          if(data.pago === 1){
            if( ($('#valor_pago_conc').val()*1) < (data.valor_iva) ){
              $('#remanescente').val(0);
              btnNaoPago();
            }
            else{
              $('#remanescente').val(0);
              btnPago();
            }
          }
          else{
            $('#remanescente').val(0);
            btnNaoPago();
          }

        },
        error:function(data){
          $("#div_create_saida_concurso").css("display", "block");
        },
        complete:function(data){
          $("#div_create_saida_concurso").css("display", "block");
        }
      });

      }
      
    });

    function btnPago(){
      $("#pago_visual").empty();
      $('#btn_visual_check').css('background-color', '#5cb85c');
      $('#btn_visual_check').css('color', 'white');
      var icon_check = '<i class="fa fa-check"></i>';
      $("#pago_visual").append(icon_check);
    }

    function btnNaoPago(){
      $("#pago_visual").empty();  
      $('#btn_visual_check').css('background-color', '#d9534f');         
      $('#btn_visual_check').css('color', 'white');         
      var icon_close = '<i class="fa fa-times"></i>';            
      $("#pago_visual").append(icon_close);
    }

    function valorPagoPagamentosConcurso(pagamentos){
      var valor_pago_conc = 0*1;
      for( var i=0; i < pagamentos.length; i++){
        valor_pago_conc = valor_pago_conc + pagamentos[i].valor_pago*1;
      }
      return valor_pago_conc;
    }



    function adicionarItensAtabela(itens){
      for(var i=0; i<itens.length ; i++){
        var tr='<tr>'+
        '<td><input type="text" name="descricao[itens.pro]" class="form-control descricao" value='+itens[i].produto.descricao+' readonly></td>'+
        '<td><input type="hidden" name="produto_id[]" class="form-control descricao" value='+itens[i].produto.id+' readonly>'+
        '<input type="text" name="quantidade[]" class="form-control quantidade" value='+itens[i].quantidade_rest+' readonly></td>'+
        '<td><input type="text" name="preco_venda[]" class="form-control preco_venda" value='+itens[i].preco_venda+' readonly></td>'+
        '<td><input type="text" name="valor[]" class="form-control valor" value='+itens[i].valor_rest+' readonly readonly></td>'+
        '<td><input type="text" name="desconto[]" class="form-control desconto" value='+itens[i].desconto+' readonly></td>'+
        '<td><input type="text" name="subtotal[]" class="form-control subtotal" value='+itens[i].subtotal_rest+' readonly></td>'+
        ' </tr>';
        $('tbody').append(tr);
      }
      total();
    }

    function total()
    {
      var total =0;
      var total_iva = 0;
      var iva = 0;
      $('.subtotal').each(function(i,e){
        var subtotal = $(this).val()-0;
        total += subtotal*1;
        iva = (total*17)/100;
        total_iva = total + (total*17)/100;

      })

      $('#valor_total_iva').val(total_iva);
      $('#valor_pago').val(total_iva);

      $('.valor_visual').html(total.formatMoney(2,',','.')+ " Mtn");
      $('.iva').html(iva.formatMoney(2,',','.')+ " Mtn");
      $('.valor_visual_iva').html(total_iva.formatMoney(2,',','.')+ " Mtn");
    };



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
    //---começam aqui as funçoes que filtram somente números
    //---find element by row--
    function findRowNum(input){
      $('tbody').delegate(input, 'keydown',function(){
        var tr =$(this).parent().parent();
        number(tr.find(input));
      });
    }

    function findRowNumOnly(input){
      $('tbody').delegate(input, 'keydown',function(){
        var tr =$(this).parent().parent();
        numberOnly(tr.find(input));
      });
    }

    //--numeros e pontos
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
    }
    function findRowNumOnly(input){
      $('tbody').delegate(input, 'keydown',function(){
        var tr =$(this).parent().parent();
        numberOnly(tr.find(input));
      });
    }
    //-------------somente numeros
    function numberOnly(input){
      $(input).keypress(function(evt){
        var e = event || evt;
        var charCode = e.which || e.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57))
          return false;
        return true;
      });
    }
    //---limitando somente para entrada de números
    findRowNum('.quantidade');
    findRowNum('.preco_venda');
    findRowNum('.desconto');

  </script>
  @endsection
