@extends('layouts.master')
@section('content')
<div class="row">
	<div class="col-lg-12">
		<h3 class="page-header"><i class="fa fa-file-text-o"></i>Facturas <b style="color: red"> Instituições ou Clientes Privados</b></h3>
		<ol class="breadcrumb">
			<li><i class="fa fa-home"></i><a href="#">Home</a></li>
			<li><i class="icon_document_alt"></i>Facturas</li>
			<li><i class="fa fa-file-text-o"></i>Gerenciar Factura</li>
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

  {{ Form::open(['route'=>'saida.store', 'method'=>'POST', 'id'=>'form_saida']) }}

  <div class="panel-body" style="border-bottom: 1px solid #ccc; ">
   <div class="row" style="margin-bottom: 15px">
    <div class="form-horizontal">

     <div class="col-md-3">
      {{Form::label('cliente_id', 'Cliente Privado')}}
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
         {{ Form::text('nr_referencia', null, ['class'=>'form-control', 'placeholder'=>'Padrão: Não Aplicavel', 'id'=>'nr_referencia'])}}
       </div>
     </div>
     <div class="row">
       <div class="col-md-12">
         {{ Form::label('confirmar_nr_referencia', 'Confirmar')}}
         {{ Form::text('confirmar_nr_referencia', null, ['class'=>'form-control', 'placeholder'=>'Padrão: Não Aplicavel', 'id'=>'confirmar_nr_referencia'])}}
         {{ Form::hidden('concurso_id', 0, ['class'=>'form-control', 'id'=>'concurso_id'])}}
       </div>
     </div>

   </div>

   <div class="col-md-6 col-md-offset-3">
    <legend>Pagamento: <b><span class="valor_total_iva_visual pull-right" style="border:none"> </span></b></legend>
    <div class="row" style="display: block">
      <div class="col-md-6">
        {{ Form::label('valor_pago', 'Valor Pago')}}
        <div class="input-group">
          {{ Form::text('valor_pago', 0.00, ['class'=>'form-control'])}}
          <div class="input-group-addon">Mtn</div>
          {{ Form::hidden('pago', 1)}}
        </div>            
      </div>
      <div class="col-md-6">
        {{ Form::label('remanescente', 'Remanescente')}}
        <div class="input-group">
          {{ Form::text('remanescente', 0.00, ['class'=>'form-control', 'readonly'])}}
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
        {{ Form::text('nr_documento_forma_pagamento', null, ['class'=>'form-control', 'id'=>'nr_documento_forma_pagamento', 'placeholder'=>'Padrão: Não Aplicavel'])}}
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
        <th><i class="icon_profile"></i> Nome do Produto</th>
        <th><i class="icon_calendar"></i> Qtd/Unidades</th>
        <th><i class="icon_calendar"></i> Qtd-Restante</th>
        <th><i class="icon_mail_alt"></i> Preço</th>
        <th><i class="icon_mail_alt"></i> Valor</th>
        <th><i class="icon_pin_alt"></i> Desconto</th>
        <th><i class="icon_mobile"></i> Subtotal</th>
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
        <td></td>
        <td></td>
        <td><b>Subtotal</b></td>
        <td><b><div class="valor_total" style="border:none"> </div></b></td>
        <td></td>
      </tr><tr>
        <td style="border:none"></td>
        <td style="border:none"></td>
        <td style="border:none"></td>
        <td></td>
        <td></td>
        <td><b>IVA(17%)</b></td>
        <td><b><div class="iva" style="border:none"> </div></b></td>
        <td></td>
      </tr><tr>
        <td style="border:none"></td>
        <td style="border:none"></td>
        <td style="border:none"></td>
        <td></td>
        <td></td>
        <td><b>Total</b></td>
        <td><b><div class="valor_total_iva_visual" style="border:none"> </div></b></td>
        <td></td>
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
							{{ Form::open(['route'=>'cliente_salvar_rback', 'method'=>'POST']) }}
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
													{{Form::radio('activo', '1')}} Activo
												</div>
												<div class="radio-inline">
													{{Form::radio('activo', '0')}} Inactivo
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
							{{Form::submit('Salvar', ['class'=>'btn btn-primary submit_iten'])}}

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

    $(document).ready(function(){
      $('.submit_iten').on('click',function(){
        $("#wait").css("display", "block");

        // if($('#nr_referencia').val() === "" || $('#nr_referencia').val() === null){
        //   alert('Informe o Número de Referência para a Factura, ou o valor padrao (Não Aplicavel)');
        //   $("#wait").css("display", "none");
        //   $('#nr_referencia').focus();
        //   return false;
        // }

        // if($('#confirmar_nr_referencia').val() != $('#nr_referencia').val()){
        //   alert('As Referências não são compatíveis');
        //   $("#wait").css("display", "none");
        //   $('#nr_referencia').focus();
        //   return false;
        // }

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
      remanescenteRed();
    });

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


    $(document).ready(function(){
      $(document).ajaxStart(function(){
        $("#wait").css("display", "block");
      });
      $(document).ajaxComplete(function(){
        $("#wait").css("display", "none");
      });
    });


    // Pagamento da Facturacao
    // function pagoNaoPago() {
    //   if (document.getElementById('pago').checked) {
    //     document.getElementById('div_forma_pagamento').style.display = 'block';
    //   }
    //   else document.getElementById('div_forma_pagamento').style.display = 'none';

    // };

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

    // $('#valor_pago').keyup(function(){
    //   var valor_pago = $('#valor_pago').val();
    //   var valor_total_iva = $('#valor_total_iva').val();
    //   var remanescente = valor_pago - valor_total_iva;

    //   $('#remanescente').val(remanescente);

    //   if( remanescente < 0 ){
    //     document.getElementById('remanescente').style.backgroundColor = "red";
    //     document.getElementById('remanescente').style.color = "white";
    //   }else{
    //     document.getElementById('remanescente').style.backgroundColor = "white";
    //     document.getElementById('remanescente').style.color = "black";

    //   }
    // });

    $('#valor_pago').keyup(function(){
      alertaremanescentePagamento();
    });

    function alertaremanescentePagamento(){
      var valor_pago = $('#valor_pago').val();
      var valor_total_iva = $('#valor_total_iva').val();
      var remanescente = valor_total_iva - valor_pago;

      if(remanescente >= 0){
       $('#remanescente').val(remanescente);
     }else{
      if(valor_pago > valor_total_iva){ 
            // ou remanscente < 0, significa q o valor pago eh maior q o remanescente_ref
            alert('O Valor a Pagar informado e maior do que o Valor Total da Saida)');
            $('#valor_pago').val(0);
            $('#remanescente').val(valor_total_iva);
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
      '<td><input type="text" name="preco_venda[]" class="form-control preco_venda"></td>'+
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
    	var id = tr.find('.descricao').val();
    	var dataId={'id':id};
    	$.ajax({
    		type  : 'GET',
    		url   : '{!!URL::route('findPrice')!!}',
    		dataType: 'json',
    		data  : dataId,
    		success:function(data){
          var quantidade_disponivel = (data.quantidade_dispo - data.quantidade_min)

          tr.find('.preco_venda').val(data.preco_venda);
          tr.find('.quantidade_dispo').val(quantidade_disponivel); //type="text", visivel a cada mudanca.
          tr.find('.qtd_dispo_original').val(quantidade_disponivel); // qtd total do produto necessaria para calcular o restante de acordo com a quantidade especificada no input. O restante eh total de produtos menos a quantidade minima de stock. type="hidden"

          var quantidade = tr.find('.quantidade').val();
          var preco_venda = tr.find('.preco_venda').val();
          var desconto = tr.find('.desconto').val();
          // O codigo abaixo obriga o recalculo apos selecionar outro produto na mesma linha depois de preencher os restanes campos
          
          var valor = (quantidade*preco_venda);
          var subtotal = (quantidade*preco_venda)-(quantidade*preco_venda*desconto)/100;
          tr.find('.valor').val(valor);
          tr.find('.subtotal').val(subtotal);
          total();

          // var valor_pago = $('#valor_pago').val();
          // var valor_total_iva = $('#valor_total_iva').val();
          // var remanescente = valor_total_iva - valor_pago;

          alertaremanescentePagamento();

          // $('#remanescente').val(remanescente);

          // if( remanescente < 0 ){
          //   document.getElementById('remanescente').style.backgroundColor = "red";
          //   document.getElementById('remanescente').style.color = "white";
          // }else{
          //   document.getElementById('remanescente').style.backgroundColor = "white";
          //   document.getElementById('remanescente').style.color = "black";

          // }

        },
        complete:function(data){
          //====trocar de focus para o proximo campo a preencher
          tr.find('.quantidade').focus();
        }
      });
    });

    //======pegar os valores dos campos e calcular o valor de cada produto====
    $('tbody').delegate('.quantidade,.preco_venda,.desconto, #confirmar_nr_referencia','keyup',function(){
    	var tr = $(this).parent().parent();
    	var quantidade = tr.find('.quantidade').val();
    	var preco_venda = tr.find('.preco_venda').val();
    	var valor = (quantidade*preco_venda);
    	var desconto = tr.find('.desconto').val();
    	var subtotal = (quantidade*preco_venda)-(quantidade*preco_venda*desconto)/100;


      var qtd_dispo_original = (tr.find('.qtd_dispo_original').val()*1);


      if(quantidade > qtd_dispo_original){
        alert('A quantidade especificada excedeu o limite');
        tr.find('.quantidade').val(0);

        var qtd_after_validation_fail = tr.find('.quantidade').val();
        var qtd_rest_after_validation_fail = qtd_dispo_original-qtd_after_validation_fail;


        var valor_after_validation_fail = (qtd_after_validation_fail*preco_venda);
        var subtotal_after_validation_fail = (qtd_after_validation_fail*preco_venda)-(qtd_after_validation_fail*preco_venda*desconto)/100;

        tr.find('.quantidade_dispo').val(qtd_rest_after_validation_fail);
        tr.find('.valor').val(valor_after_validation_fail);
        tr.find('.subtotal').val(subtotal_after_validation_fail);
        total();

      }else{
        tr.find('.quantidade').val(quantidade);
        var quantidade_dispo = (qtd_dispo_original-quantidade);
        tr.find('.quantidade_dispo').val(quantidade_dispo);
        tr.find('.valor').val(valor);
        tr.find('.subtotal').val(subtotal);
        total();
      }

      // var valor_pago = $('#valor_pago').val();
      // var valor_total_iva = $('#valor_total_iva').val();
      // var remanescente = valor_pago - valor_total_iva;

      // $('#remanescente').val(remanescente);

      // if( remanescente < 0 ){
      //   document.getElementById('remanescente').style.backgroundColor = "red";
      //   document.getElementById('remanescente').style.color = "white";
      // }else{
      //   document.getElementById('remanescente').style.backgroundColor = "white";
      //   document.getElementById('remanescente').style.color = "black";

      // }
      alertaremanescentePagamento();

    });

    //==calculo do total de todas as linhas
    function total()
    {
    	var total =0;
      var total_iva = 0;
    	$('.subtotal').each(function(i,e){
    		var subtotal = $(this).val()-0;
    		total +=subtotal;
        iva = (total*17)/100;
        total_iva = total + (total*17)/100;
    	})

      $('.valor_total').html(total.formatMoney(2,',','.')+ " Mtn");
      $('.iva').html(iva.formatMoney(2,',','.')+ " Mtn");
      $('.valor_total_iva_visual').html(total_iva.formatMoney(2,',','.')+ " Mtn");
      $('#valor_total_iva').val(total_iva); //cuidado, input importante para calculos
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


    //pegar dados e enviar para a rota que salva
    // $('#form_saida').submit(function(e){
    //   e.preventDefault();
    //   data = $(this).serialize();

    //   $.ajax({
    //     type : "POST",
    //     url : "saida_store",
    //     dataType : "JSON",
    //     data : data,
    //     success : function(data){
    //       if(data.status == 'success'){
    //         window.location.href="index"; // Foi necessario definir mais uma rota para o mesmo metodo index() por forma a chama-lo daqui como nao eh possivl aceder ao index() com metodo resource. E tb nao eh possivel especificar um nome de rota para "resources"
    //       }else{
    //         window.location.href="create"; // Necessario para actualizar as mensagens do flash(success ou error nas views ou routes)
    //       }
    //     },

    //     error : function(data){ // Automaticamente pega os erros de validacao do Form Request e devolve um json com uma mensagem padrao e o array contendo as validacoes que nao passaram no teste. Nao ha necessidade de fazer return response explicito no Controller

    //       // var errors = $.parseJSON(data.responseText);
    //       var errors = data.responseJSON;
    //       printErrorMsg(errors.errors);

    //     }


    //   });

    //   function printErrorMsg(msg){
    //     $(".print-error-msg").find("ul").html('');
    //     $(".print-error-msg").css('display', 'block');
    //     $.each(msg, function(key, value){
    //       $(".print-error-msg").find("ul").append('<li><strong>Erro!!</strong> '+value+'</li>');
    //     });
    //   }

    // });




  </script>
  @endsection
