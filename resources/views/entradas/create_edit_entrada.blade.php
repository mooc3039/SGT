@extends('layouts.master')
@section('content')
<div class="row">
	<div class="col-lg-12">
		<h3 class="page-header"><i class="fa fa-file-text-o"></i>Entradas</h3>
		<ol class="breadcrumb">
			<li><i class="fa fa-home"></i><a href="#">Home</a></li>
			<li><i class="icon_document_alt"></i> Entrada </li>
			<li><i class="fa fa-file-text-o"></i>Gerenciar Entrada</li>
		</ol>
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
    
    <section class="panel panel-default">
        <!-- <header class="panel-heading">
          Gerenciamento das Entradas
        </header> -->


        {{ Form::open(['route'=>'entrada.store', 'method'=>'POST', 'id'=>'form_Entrada']) }}

        <div class="panel-body" style="border-bottom: 1px solid #ccc; ">
         <div class="row" style="margin-bottom: 15px">
          <div class="form-horizontal">

           <div class="col-md-4">
            {{Form::label('fornecedor_id', 'Fornecedor')}}
            <div class="input-group">
              {{Form::select('fornecedor_id', [''=>'Selecione Fornecedor',] + $fornecedor, null, ['class'=>'form-control select_search'] )}}
              {{Form::button('<i class="fa fa-plus"></i>', ['class'=>'input-group-addon', 'data-toggle'=>'modal', 'data-target'=>'#modalFornecedor', 'style'=>'width:auto; font-weight:lighter'])}}
            </div>
          </div>

          <div class="col-md-8">
            <legend>Pagamento: <b><span class="valor_visual pull-right" style="border:none"> </span></b></legend>
            <div class="row" style="margin-bottom: 5px">
             <div class="col-md-4">
              <div class="radio-inline">
                <!-- {{Form::radio('pago', '1', ['id'=>'pago', 'onclick'=>'javascript:pagoNaoPago();'])}} Pago -->
                <input type="radio" onclick="javascript:pagoNaoPago();" name="pago" value="1" id="pago"> <label for="pago">Pago</label>
              </div>
              <div class="radio-inline">
                <!-- {{Form::radio('pago', '0', ['id'=>'nao_pago', 'onclick'=>'javascript:pagoNaoPago();'])}} Não Pago -->
                <input type="radio" onclick="javascript:pagoNaoPago();" name="pago" value="0" id="nao_pago"> <label for="nao_pago">Não Pago</label>
              </div>

            </div>

            <div class="col-md-8" id="div_forma_pagamento" style="display:none">
              <div class="row">
                <div class="col-md-6">
                  {{ Form::label('valor_pago', 'Valor Pago')}}
                  <div class="input-group">
                    {{ Form::text('valor_pago', null, ['class'=>'form-control'])}}
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
                  {{Form::select('forma_pagamento_id', [''=>'Forma Pgamento',] + $formas_pagamento, null, ['class'=>'form-control'] )}}
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
   {{Form::submit('Salvar Entrada', ['class'=>'btn btn-primary', 'id'=>'salvar_entrada'])}}
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
          <th> Qtd-Disponível</th>
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
        <td><input type="text" name="quantidade_dispo[]" class="form-control quantidade_dispo" readonly><input type="hidden" name="qtd_dispo_original[]" class="form-control qtd_dispo_original"></td>
        <td><input type="text" name="preco_aquisicao[]" class="form-control preco_aquisicao" readonly></td>
        <td><input type="text" name="valor[]" class="form-control valor" value="0" readonly></td>
        <td><input type="text" name="desconto[]" class="form-control desconto" value="0"></td>
        <td><input type="text" name="subtotal[]" class="form-control subtotal" readonly></td>
        <td><a class="btn btn-danger remove" href="#"><i class="icon_close_alt2"></i></a></td>
      </tr>

    </tbody>
    <tfoot>
     <!-- <tr>
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
    </tr> -->
    <tr>
      <td style="border:none"></td>
      <td style="border:none"></td>
      <td style="border:none"></td>
      <td></td>
      <td></td>
      <td><b>Total</b></td>
      <td><b><div class="valor_total_visual" style="border:none"> </div></b></td>
      <td></td>
    </tr>
  </tfoot>
</table>
</div>
<div class="panel-footer">
  <div class="row">
    <div class="col-md-6"></div>
    <div class="col-md-6 text-right">
      <a href="{{ route('entrada.index') }}" class="btn btn-warning">Cancelar</a>
    </div>
  </div>
</div>
</section>
{{ Form::hidden('valor_total', 0, ['id'=>'valor_total']) }}
{{ Form::hidden('user_id', Auth::user()->id) }}
{!!Form::hidden('_token',csrf_token())!!}
{{ Form::close() }}
</section>
</div>
</div>

<!-- MODAL FORNECEDOR -->
<div class="modal fade" tabindex="-1" role="dialog" id="modalFornecedor">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Cadastrar Fornecedor</h4>
      </div>
      <div class="modal-body">

        {{Form::open(['route'=>'fornecedor_salvar_rback', 'method'=>'POST', 'onsubmit'=>'submitFormFornecedor.disabled = true; return true;'])}}
        <div class="form-group">
          {{Form::label('nome', 'Nome', ['class'=>'control-lable'])}}
          {{Form::text('nome', null, ['placeholder' => 'Nome', 'class' => 'form-control'])}}
        </div>
        <div class="form-group">
          {{Form::label('telefone', 'Telefone', ['class'=>'control-lable'])}}
          {{Form::text('telefone', null, ['placeholder' => 'Telefone', 'class' => 'form-control'])}}
        </div>
        <div class="form-group">
          {{Form::label('endereco', 'Endereço', ['class'=>'control-lable'])}}
          {{Form::text('endereco', null, ['placeholder' => 'Endereço', 'class' => 'form-control'])}}
        </div>
        <div class="form-group">
          {{Form::label('email', 'Email', ['class'=>'control-lable'])}}
          {{Form::text('email', null, ['placeholder' => 'Email', 'class' => 'form-control'])}}
        </div>
        <div class="form-group">
          {{Form::label('rubrica', 'Rubrica', ['class'=>'control-lable'])}}
          {{Form::text('rubrica', null, ['placeholder' => 'Rubrica', 'class' => 'form-control'])}}
        </div>
        <div class="radio-inline">
          <input type="radio" name="activo" value="1" id="activo"> <label for="activo">Activo</label>
        </div>
        <div class="radio-inline">
          <input type="radio" name="activo" value="0" id="inactivo"> <label for="inactivo">Inactivo</label>
        </div>

      </div>
      <div class="modal-footer">
        {{Form::button('Fechar', ['class'=>'btn btn-default', 'data-dismiss'=>'modal'])}}
        {{Form::submit('Salvar', ['class'=>'btn btn-primary submit_cliente', 'name'=>'submitFormFornecedor', 'id'=>'submitFormFornecedor'])}}
        <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
          <button type="button" class="btn btn-primary">Salvar</button> -->
          {{Form::close()}}
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
  <!--FIM MODAL FORNECEDOR -->

  @endsection
  @section('script')
  <script text="text/javascript">

    $('.submit_cliente').on('click',function(){
      $(".wait").css("display", "block");
    });

    $('#salvar_entrada').on('click',function(){
      $(".wait").css("display", "block");
    });

    $(document).ready(function(){
      $(document).ajaxStart(function(){
        $(".wait").css("display", "block");
      });
      $(document).ajaxComplete(function(){
        $(".wait").css("display", "none");
      });

      remanescenteRed();
      formataValoresMonetariosAoCarregarAPagina();
    });

    function formataValoresMonetariosAoCarregarAPagina(){
     $('#remanescente').val(Number.parseFloat(0).formatMoney()); // O remanescente eh zero porq ainda nao ha valores
     $('#valor_pago').val(Number.parseFloat(0).toFixed(2));
   }


     // Pagamento da Entrada
     function pagoNaoPago() {
      if (document.getElementById('pago').checked) {
        document.getElementById('div_forma_pagamento').style.display = 'block';
        $('#valor_pago').val(Number.parseFloat(0).toFixed(2));
        $('#forma_pagamento_id').val('');
        $('#nr_documento_forma_pagamento').val('');
        remanescenteRed();
        alertaremanescentePagamento();
      }
      else {
        document.getElementById('div_forma_pagamento').style.display = 'none';
        $('#valor_pago').val(Number.parseFloat(0).formatMoney());
        $('#remanescente').val(Number.parseFloat($('#valor_total').val()).formatMoney());
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
      var valor_pago = Number.parseFloat(($('#valor_pago').val()).replace(/[^0-9-.]/g, ''));
      var valor_total = Number.parseFloat($('#valor_total').val());
      var remanescente = (valor_total - valor_pago);

      if($('#valor_pago').val() === "" || $('#valor_pago').val() === null){
          $('#remanescente').val(Number.parseFloat(valor_total).formatMoney());
        }

      if(remanescente >= 0){
       $('#remanescente').val(remanescente.formatMoney());
       console.log(remanescente);
     }else{
      if(valor_pago > valor_total){ 
          // ou remanscente < 0, significa q o valor pago eh maior q o remanescente_ref
          alert('O Valor a Pagar informado e maior do que o Valor Total da Saida)');
          $('#valor_pago').val(Number.parseFloat(0).formatMoney());
          $('#remanescente').val(valor_total.formatMoney());
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
      '<td><input type="text" name="preco_aquisicao[]" class="form-control preco_aquisicao" readonly></td>'+
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
    		alert('A Entrada deve conter pelo menos um item');
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

          var quantidade_disponivel = ((Number.parseInt(data.quantidade_dispo)) - (Number.parseInt(data.quantidade_min)));

          tr.find('.preco_aquisicao').val((Number.parseFloat(data.preco_aquisicao)).formatMoney());
          tr.find('.quantidade_dispo').val(quantidade_disponivel) + quantidade; //type="text", visivel a cada mudanca.
          tr.find('.qtd_dispo_original').val(quantidade_disponivel); // qtd total do produto necessaria para calcular o restante de acordo com a quantidade especificada no input. O restante eh total de produtos menos a quantidade minima de stock. type="hidden"

          calcularIten(tr);
          alertaremanescentePagamento();

        },
        complete(data){
          tr.find('.quantidade').focus();
          // console.log(data);
        }
      });
    });

    //======pegar os valores dos campos e calcular o valor de cada produto====
    $('tbody').delegate('.quantidade,.preco_aquisicao,.desconto','keyup',function(){
    	var tr = $(this).parent().parent();

      calcularIten(tr);
      alertaremanescentePagamento();
      
    });

    function calcularIten(tr){

      var quantidade = Number.parseInt(0); // garante q a qtd seja um numero e nao NaN
      if( (tr.find('.quantidade').val()) === "" || (tr.find('.quantidade').val()) === null){
        quantidade = Number.parseInt(0);
      }else{
        quantidade = Number.parseInt(tr.find('.quantidade').val());
      }

      var preco_aquisicao = Number.parseFloat((tr.find('.preco_aquisicao').val()).replace(/[^0-9-.]/g, ''));
      var valor = Number.parseFloat((quantidade*preco_aquisicao));
      var desconto = Number.parseInt(tr.find('.desconto').val());
      var subtotal = Number.parseFloat(((quantidade*preco_aquisicao)-(quantidade*preco_aquisicao*desconto)/100));


      var qtd_dispo_original = (Number.parseInt(tr.find('.qtd_dispo_original').val()));

      tr.find('.quantidade').val(quantidade);
      var quantidade_dispo = (qtd_dispo_original+quantidade);
      tr.find('.quantidade_dispo').val(quantidade_dispo);
      tr.find('.valor').val(valor.formatMoney());
      tr.find('.subtotal').val(subtotal.formatMoney());
      total();

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

      $('.valor_visual').html(total.formatMoney()+ " Mtn");
    	$('.valor_total_visual').html(total.formatMoney()+ " Mtn");
    	$('#valor_total').val(total);
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
    findRowNum('.preco_aquisicao');
    findRowNum('.desconto');
    number('#valor_pago');

  </script>
  @endsection
