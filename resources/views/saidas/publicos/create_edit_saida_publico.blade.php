@extends('layouts.master')
@section('content')
<div class="row">
	<div class="col-lg-12">
		<h3 class="page-header"><i class="fa fa-file-text-o"></i>Facturas <b style="color: red">Instituições do Estado</b></h3>
		<ol class="breadcrumb">
			<li><i class="fa fa-home"></i><a href="#">Home</a></li>
			<li><i class="icon_document_alt"></i>Facturas</li>
			<li><i class="fa fa-file-text-o"></i>Gerenciar Factura</li>
		</ol>
	</div>
</div>

<div class="row">
	<div class="col-lg-12">

    <section class="panel panel-default">

      {{ Form::open(['route'=>'saida.store', 'method'=>'POST', 'id'=>'form_saida']) }}

      <div class="panel-body" style="border-bottom: 1px solid #ccc; ">
       <div class="row" style="margin-bottom: 15px">
        <div class="form-horizontal">

          <div class="col-sm-3">
            {{Form::label('cliente_id', 'Cliente Estado')}}
            <div class="input-group">
             {{Form::select('cliente_id', [''=>'Cliente',] + $clientes, null, ['class'=>'form-control select_search'] )}}
             {{Form::button('<i class="fa fa-plus"></i>', ['class'=>'input-group-addon', 'data-toggle'=>'modal', 'data-target'=>'#modalCliente', 'style'=>'width:auto; font-weight:lighter'])}}
           </div>

         </div>

         <div class="col-md-3" style="display: none">
           <legend>Referência: </legend>
           <div class="row">
             <div class="col-md-12">
               {{ Form::label('nr_referencia', 'Referência da Factura')}}
               {{ Form::text('nr_referencia', null, ['class'=>'form-control', 'id'=>'nr_referencia'])}}
             </div>
           </div>
           <div class="row">
             <div class="col-md-12">
               {{ Form::label('confirmar_nr_referencia', 'Confirmar')}}
               {{ Form::text('confirmar_nr_referencia', null, ['class'=>'form-control', 'id'=>'confirmar_nr_referencia'])}}
             </div>
           </div>

         </div>

         <div class="col-md-6 col-md-offset-3">
          <legend>Pagamento: <b><span class="valor_total_iva_visual pull-right" style="border:none"> </span></b></legend>
          <div class="row" style="margin-bottom: 5px">
            <div class="col-md-3">
              <div class="row">
                <div class="col-md-12">
                  <div class="radio-inline">
                    <!-- {{Form::radio('pago', '1', ['id'=>'pago', 'onclick'=>'javascript:pagoNaoPago();'])}} Pago -->
                    <input type="radio" onclick="javascript:pagoNaoPago();" name="pago" value="1" id="pago" checked="true"> <label for="pago">Pago</label>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="radio-inline">
                    <!-- {{Form::radio('pago', '0', ['id'=>'nao_pago', 'onclick'=>'javascript:pagoNaoPago();'])}} Não Pago -->
                    <input type="radio" onclick="javascript:pagoNaoPago();" name="pago" value="0" id="nao_pago"> <label for="nao_pago">Não pago</label>
                  </div>
                </div>
              </div>



            </div>

            <div class="col-md-9" id="div_forma_pagamento" style="display:block">
              <div class="row" style="display: block">
                <div class="col-md-6">
                  {{ Form::label('valor_pago', 'Valor Pago')}}
                  <div class="input-group">
                    {{ Form::text('valor_pago', null, ['class'=>'form-control', 'id'=>'valor_pago'])}}
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
                  {{ Form::text('nr_documento_forma_pagamento', null, ['class'=>'form-control'])}}
                </div>
              </div>
            </div>

          </div>

        </div>

      </div>
    </div>
  </div>

  <div class="panel-footer">
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
          <th> Nome do Produto</th>
          <th> Qtd/Unidades</th>
          <th> Qtd-Restante</th>
          <th> Preço (Mtn)</th>
          <th> Valor (Mtn)</th>
          <th> Desconto (%)</th>
          <th> Subtotal (Mtn)</th>
          <th><a class="btn btn-primary addRow" href="#"><i class="icon_plus_alt2"></i></a></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>
           <select class="form-control descricao" name="produto_id[]">
            <option value="0" selected="true" disabled="true">Selecione Produto</option>
            @foreach($produtos as $produto)
            <option value="{!!$produto->id!!}">{!!$produto->descricao!!}</option>
            @endforeach
          </select>
        </td>
        <td><input type="text" name="quantidade[]" class="form-control quantidade"></td>
        <td><input type="text" name="quantidade_dispo[]" class="form-control quantidade_dispo" readonly><input type="hidden" name="qtd_dispo_original" class="form-control qtd_dispo_original"></td>
        <td><input type="text" name="preco_venda[]" class="form-control preco_venda" readonly></td>
        <td><input type="text" name="valor[]" class="form-control valor" value="0" readonly></td>
        <td><input type="text" name="desconto[]" class="form-control desconto" value="0"></td>
        <td><input type="text" name="subtotal[]" class="form-control subtotal" readonly></td>
        <td><a class="btn btn-danger remove" href="#"><i class="icon_close_alt2"></i></a></td>
      </tr>

    </tbody>
    <tfoot>
     <tr>
      <td style="border:none"></td>
      <td style="border:none"></td>
      <td style="border:none"></td>
      <td style="border:none"></td>
      <td></td>
      <td><b>Subtotal</b></td>
      <td><b><div class="valor_total" style="border:none"> </div></b></td>
      <td></td>
    </tr><tr>
      <td style="border:none"></td>
      <td style="border:none"></td>
      <td style="border:none"></td>
      <td style="border:none"></td>
      <td></td>
      <td><b>IVA(17%)</b></td>
      <td><b><div class="iva" style="border:none"> </div></b></td>
      <td></td>
    </tr><tr>
      <td colspan="2" style="border:none">
        <div class="checkbox">
          <label>
            <h5><b> <input name="checkbox_motivo_imposto" id="checkbox_motivo_imposto" type="checkbox" onclick="javascript:motivoDaNaoAPlicacaoDoImposto();"> Motivo Justificativo da não aplicação de imposto</b></h5>
          </label>
        </div>
      </td>
      <td style="border:none"></td>
      <td style="border:none"></td>
      <td></td>
      <td><b>Total</b></td>
      <td><b><div class="valor_total_iva_visual" style="border:none"> </div></b></td>
      <td></td>
    </tr>
    <tr>
      <td style="border:none" colspan="7">
        <div id="mostra_texto">
          <textarea class="form-control" rows="3" cols="7" name="texto_motivo_imposto" id="texto_motivo_imposto"></textarea>
        </div>
      </td>
    </tr>
  </tfoot>
</table>
</div>
<div class="panel-footer">
  <div class="row">
    <div class="col-md-6"></div>
    <div class="col-md-6 text-right">
      <a href="{{ route('saida.index') }}" class="btn btn-warning">Cancelar</a>
    </div>
  </div>
</div>
</section>
{{ Form::hidden('valor_total_iva', 0, ['id'=>'valor_total_iva']) }}
{{ Form::hidden('user_id', Auth::user()->id) }}
{!!Form::hidden('_token',csrf_token())!!}
{{ Form::close() }}
</section>
</div>
</div>

<!-- MODAL CLIENTE -->
<div class="modal fade" tabindex="-1" role="dialog" id="modalCliente">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Cadastrar Tipo de Saida</h4>
			</div>
			<div class="modal-body">

				<div class="row">
					<div class="col-md-12">
						<div class="panel-body">
							{{ Form::open(['route'=>'cliente_salvar_rback', 'method'=>'POST', 'onsubmit'=>'submitFormCliente.disabled = true; return true;']) }}
							<div class="row">
								<div class="col-md-12">
									<div class="form-horizontal">
										<div class="row" style="margin-bottom: 15px;">
											<div class="col-md-4">
												{{ Form::label('tipo_cliente_id', 'Tipo de Cliente', ['class'=>'control-label']) }}
												{{ Form::select('tipo_cliente_id', [''=>'Tipo de Cliente',] + $tipos_cliente, null, ['class'=>'form-control', 'id'=>'mdl_cli_email']) }}
											</div>
										</div>
										<div class="row">
											<div class="col-md-4">
												<div class="radio-inline">
                          <input type="radio" name="activo" value="1" id="activo"> <label for="activo">Activo</label>
                        </div>
                        <div class="radio-inline">
                          <input type="radio" name="activo" value="0" id="inactivo"> <label for="inactivo">Inactivo</label>
                        </div>
                      </div>
                    </div>
                  </div>
                  <hr style="border: 1px solid #ccc;">
                  <div class="form-horizontal">
                    <div class="row" style="margin-bottom: 15px;">
                     <div class="col-md-4">
                      {{ Form::label('nome', 'Nome', ['class'=>'control-label']) }}
                      {{ Form::text('nome', null, ['placeholder'=>'Nome','class'=>'form-control', 'id'=>'mdl_cli_nome']) }}
                    </div>
                    <div class="col-md-4">
                      {{ Form::label('endereco', 'Endereço', ['class'=>'control-label']) }}
                      {{ Form::text('endereco', null, ['placeholder'=>'Endereço','class'=>'form-control', 'id'=>'mdl_cli_endereco']) }}
                    </div>
                    <div class="col-md-4">
                      {{ Form::label('telefone', 'Telefone', ['class'=>'control-label']) }}
                      {{ Form::text('telefone', null, ['placeholder'=>'telefone','class'=>'form-control', 'id'=>'mdl_cli_telefone']) }}
                    </div>
                  </div>
                </div>
                <div class="form-horizontal">
                  <div class="row" style="margin-bottom: 15px;">
                   <div class="col-md-4">
                    {{ Form::label('email', 'Email', ['class'=>'control-label']) }}
                    {{ Form::text('email', null, ['placeholder'=>'Email','class'=>'form-control', 'id'=>'mdl_cli_email']) }}
                  </div>
                  <div class="col-md-4">
                    {{ Form::label('nuit', 'NUIT', ['class'=>'control-label']) }}
                    {{ Form::text('nuit', null, ['placeholder'=>'NUIT','class'=>'form-control', 'id'=>'mdl_cli_nuit']) }}
                  </div>
                </div>
              </div>


            </div>
          </div>
        </div>
        <div class="modal-footer">
         {{Form::button('Fechar', ['class'=>'btn btn-default', 'data-dismiss'=>'modal'])}}
         {{Form::submit('Salvar', ['class'=>'btn btn-primary submit_cliente', 'name'=>'submitFormCliente', 'id'=>'submitFormCliente'])}}

         {{Form::close()}}
       </div>
     </div>
   </div>

 </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- FIM MODAL CLIENTE -->

@endsection
@section('script')
<script text="text/javascript">

  $(document).ready(function() {
    document.getElementById('mostra_texto').style.display = 'none';
    $('#texto_motivo_imposto').val("");

  });

  $('.submit_cliente').on('click',function(){
    $(".wait").css("display", "block");
  });

  $(document).ready(function(){
    $(document).ajaxStart(function(){
      $(".wait").css("display", "block");
    });
    $(document).ajaxComplete(function(){
      $(".wait").css("display", "none");
    });
  });

  $(document).ready(function(){
    $('.submit_iten').on('click',function(){
      $(".wait").css("display", "block");

        // if($('#nr_referencia').val() === "" || $('#nr_referencia').val() === null){
        //   alert('Informe o Número de Referência para a Factura, ou o valor padrao (Não Aplicavel)');
        //   $(".wait").css("display", "none");
        //   $('#nr_referencia').focus();
        //   return false;
        // }

        // if($('#confirmar_nr_referencia').val() != $('#nr_referencia').val()){
        //   alert('As Referências não são compatíveis');
        //   $(".wait").css("display", "none");
        //   $('#nr_referencia').focus();
        //   return false;
        // }

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

    remanescenteRed();
    formataValoresMonetariosAoCarregarAPagina();
  });

  function formataValoresMonetariosAoCarregarAPagina(){
     $('#remanescente').val(Number.parseFloat(0).formatMoney()); // O remanescente eh zero porq ainda nao ha valores
     $('#valor_pago').val(Number.parseFloat(0).toFixed(2));
   }


    // $('#confirmar_nr_referencia, #nr_referencia').keyup(function(){
    //   var nr_referencia = $('#nr_referencia').val();
    //   if( $('#confirmar_nr_referencia').val() === nr_referencia){
    //     document.getElementById('nr_referencia').style.borderColor ='green';
    //     document.getElementById('confirmar_nr_referencia').style.borderColor ='green';
    //   }else{
    //     document.getElementById('nr_referencia').style.borderColor ='rgba(81, 203, 238, 1)';
    //     document.getElementById('confirmar_nr_referencia').style.borderColor ='red';
    //   }
    // });

    
    // Pagamento da Facturacao
    function pagoNaoPago() {
      if (document.getElementById('pago').checked) {
        document.getElementById('div_forma_pagamento').style.display = 'block';
        $('#valor_pago').val(Number.parseFloat(0).formatMoney());
        $('#forma_pagamento_id').val('');
        $('#nr_documento_forma_pagamento').val('');
        remanescenteRed();
      }
      else {
        document.getElementById('div_forma_pagamento').style.display = 'none';
        $('#valor_pago').val(Number.parseFloat(0).formatMoney());
        $('#remanescente').val(Number.parseFloat($('#valor_total_iva').val()).formatMoney());
        $('#forma_pagamento_id').val(1); // codigo da forma de pagamento (Nao Aplicavel=>DB)
        $('#nr_documento_forma_pagamento').val('Nao Aplicavel');

      }
    };


    $('#valor_pago').keyup(function(){
      alertaremanescentePagamento();
    });


    $('#forma_pagamento_id').change(function(){
      var frm_pagamento = document.getElementById('forma_pagamento_id').options[document.getElementById('forma_pagamento_id').selectedIndex].text;
      var resul_frm_pagamento = frm_pagamento.toLowerCase();

      if(resul_frm_pagamento == "dinheiro"){
        $('#nr_documento_forma_pagamento').val('Nao Aplicavel');
      }else{
        $('#nr_documento_forma_pagamento').focus();
        $('#nr_documento_forma_pagamento').val('');
      }
      
    });

    function alertaremanescentePagamento(){
      var valor_pago = Number.parseFloat($('#valor_pago').val());
      var valor_total_iva = Number.parseFloat($('#valor_total_iva').val());
      var remanescente = valor_total_iva - valor_pago;

      if($('#valor_pago').val() === "" || $('#valor_pago').val() === null){
        $('#remanescente').val(Number.parseFloat(valor_total_iva).formatMoney());
      }

      if(remanescente >= 0){
       $('#remanescente').val(remanescente.formatMoney());
     }else{
      if(valor_pago > valor_total_iva){ 
            // ou remanscente < 0, significa q o valor pago eh maior q o remanescente_ref
            alert('O Valor a Pagar informado e maior do que o Valor Total da Saida)');
            $('#valor_pago').val(Number.parseFloat(0).formatMoney());
            $('#remanescente').val(valor_total_iva.formatMoney());
          }
        }
      }


      function remanescenteRed(){
        document.getElementById('remanescente').style.backgroundColor = "red";
        document.getElementById('remanescente').style.color = "white";
      }


    //função que adiciona a linha
    function addRow()
    {
    	var tr='<tr>'+
    	'<td>'+
    	'<select class="form-control descricao" name="produto_id[]">'+
    	'<option value="0" selected="true" disabled="true">Selecione Producto</option>'+
    	'@foreach($produtos as $produto)'+
    	' <option value="{!!$produto->id!!}">{!!$produto->descricao!!}</option>'+
    	'@endforeach'+
    	'</select>'+
    	'</td>'+
      '<td><input type="text" name="quantidade[]" class="form-control quantidade"></td>'+
      '<td><input type="text" name="quantidade_dispo[]" class="form-control quantidade_dispo" readonly>'+
      ' <input type="hidden" name="qtd_dispo_original[]" class="form-control qtd_dispo_original"></td>'+
      '<td><input type="text" name="preco_venda[]" class="form-control preco_venda" readonly></td>'+
      '<td><input type="text" name="valor[]" class="form-control valor" value="0" readonly></td>'+
      '<td><input type="text" name="desconto[]" class="form-control desconto" value="0"></td>'+
      '<td><input type="text" name="subtotal[]" class="form-control subtotal" readonly></td>'+
      '<td><a class="btn btn-danger remove" href="#"><i class="icon_close_alt2"></i></a></td>'+
      ' </tr>';
      $('tbody').append(tr);

    };

    //==========adiciona mais uma linha da usando a função addRow==
    $('.addRow').on('click',function(){
    	addRow();
    });

    //====remove a linha adicionada, foram corrigidos muitos bugs aqui===

    $('tbody').on('click','.remove',function(){
    	var l=$('tbody tr').length;
    	if (l==1) {
    		alert('A Saida deve conter pelo menos um item');
    	}else{
    		$(this).parent().parent().remove();
    		total();
    	}

    });
    


    //------devolver dados do price
    $('tbody').delegate('.descricao','change',function(){

    	var tr= $(this).parent().parent();

      var quantidade = Number.parseInt(0); // garante q a qtd seja um numero e nao NaN
      if( (tr.find('.quantidade').val()) === "" || (tr.find('.quantidade').val()) === null){
        quantidade = Number.parseInt(0);
      }else{
        quantidade = Number.parseInt(tr.find('.quantidade').val());
      }

      var id = tr.find('.descricao').val();
      var dataId={'id':id};
      $.ajax({
        type  : 'GET',
        url   : '{!!URL::route('findPrice')!!}',
        dataType: 'json',
        data  : dataId,
        success:function(data){
          var quantidade_disponivel = ((Number.parseInt(data.quantidade_dispo)) - (Number.parseInt(data.quantidade_min)))

          tr.find('.preco_venda').val(Number.parseFloat(data.preco_venda).formatMoney());
          tr.find('.quantidade_dispo').val(quantidade_disponivel - quantidade); //type="text", visivel a cada mudanca.
          tr.find('.qtd_dispo_original').val(quantidade_disponivel); // qtd total do produto necessaria para calcular o restante de acordo com a quantidade especificada no input. O restante eh total de produtos menos a quantidade minima de stock. type="hidden"

          calcularIten(tr);
          alertaremanescentePagamento();

        },
        complete:function(data){
          //====trocar de focus para o proximo campo a preencher
          tr.find('.quantidade').focus();
        }
      });
    });

    //======pegar os valores dos campos e calcular o valor de cada produto====
    $('tbody').delegate('.quantidade,.preco_venda,.desconto','keyup',function(){
    	var tr = $(this).parent().parent();

      calcularIten(tr);
      alertaremanescentePagamento();
      
    });

    // Calcular os valores de cada linha, ou iten
    function calcularIten(tr){

      var quantidade = Number.parseInt(0);
      if( (tr.find('.quantidade').val()) === "" || (tr.find('.quantidade').val()) === null){
        quantidade = Number.parseInt(0);
      }else{
        quantidade = Number.parseInt(tr.find('.quantidade').val());
      }

      var preco_venda = Number.parseFloat((tr.find('.preco_venda').val()).replace(/[^0-9-.]/g, ''));
      var valor = Number.parseFloat((quantidade*preco_venda));
      var desconto = Number.parseInt(tr.find('.desconto').val());
      var subtotal = Number.parseFloat(((quantidade*preco_venda)-(quantidade*preco_venda*desconto)/100));
      


      var qtd_dispo_original = Number.parseInt(tr.find('.qtd_dispo_original').val());


      if(quantidade > qtd_dispo_original){
        alert('A quantidade especificada excedeu o limite');
        tr.find('.quantidade').val(0);

        var qtd_after_validation_fail = Number.parseInt(tr.find('.quantidade').val());
        var qtd_rest_after_validation_fail = qtd_dispo_original-qtd_after_validation_fail;


        var valor_after_validation_fail = Number.parseFloat((qtd_after_validation_fail*preco_venda));
        var subtotal_after_validation_fail = Number.parseFloat(((qtd_after_validation_fail*preco_venda)-(qtd_after_validation_fail*preco_venda*desconto)/100));

        tr.find('.quantidade_dispo').val(qtd_rest_after_validation_fail);
        tr.find('.valor').val(valor_after_validation_fail.formatMoney());
        tr.find('.subtotal').val(subtotal_after_validation_fail.formatMoney());
        total();

      }else{
        tr.find('.quantidade').val(quantidade);
        var quantidade_dispo = (qtd_dispo_original-quantidade);
        tr.find('.quantidade_dispo').val(quantidade_dispo);
        tr.find('.valor').val(valor.formatMoney());
        tr.find('.subtotal').val(subtotal.formatMoney());
        total();
      }
      
    }

    //==calculo do total de todas as linhas
    function total()
    {
    	var total = Number.parseFloat(0);
      var total_iva = Number.parseFloat(0);
      $('.subtotal').each(function(i,e){
        var subtotal_string = $(this).val();
        var subtotal_float = Number.parseFloat(subtotal_string.replace(/[^0-9-.]/g, ''));
        total +=subtotal_float;
      })

      iva = Number.parseFloat(Number.parseFloat((total*17)/100).toFixed(2)); // o parseFloat interno gera uma string e garante duas casas decimas, o parseFloat externo garante que seja um float para posteriores operacoes artime.
      total_iva = (total + iva);

      $('.valor_total').html(total.formatMoney()+ " Mtn");
      $('.iva').html(iva.formatMoney()+ " Mtn");
      $('.valor_total_iva_visual').html(total_iva.formatMoney()+ " Mtn");
      $('#valor_total_iva').val(total_iva); //cuidado, input importante para calculos
    };

    function motivoDaNaoAPlicacaoDoImposto() {
      if (document.getElementById('checkbox_motivo_imposto').checked) {
        document.getElementById('mostra_texto').style.display = 'block';
        $('#texto_motivo_imposto').val("");
        
      }
      else {
        document.getElementById('mostra_texto').style.display = 'none';
        $('#texto_motivo_imposto').val("");
      }
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
    };
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
    number('#valor_pago')


  </script>
  @endsection
