@extends('layouts.master')
@section('content')


<div class="row">
	<div class="col-md-12">

		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="row">
					<div class="col-md-5 border">
						<div class="panel panel-default">

							<div class="panel-body">
								@include('layouts.empresa.dados_empresa')
							</div>
						</div>



					</div>

					<div class="col-md-4">

						<div class="panel panel-default">
							<div class="panel-body text-center">
								<h2> <b> Dados do Cliente </b></h2> <hr>
								Nome do Cliente: {{$saida->cliente->nome}}<br>
								Endereço: {{$saida->cliente->endereco}}<br>
								Nuit: {{$saida->cliente->nuit}}<br>
							</div>
						</div>
					</div>

					<div class="col-md-3">

						<div class="panel panel-default">
							<div class="panel-body text-center">
								<h2> <b> Numero da Factura </b> </h2> <hr>
								<h1>{{$saida->id}}</h1>
							</div>
						</div>


					</div>
				</div>
				<div class="row">
					<div class="col-md-6"> MAPUTO</div>
					<div class="col-md-6 text-right"> Data: {{$saida->data}} </div>
				</div>
			</div>


			<div class="panel-body">

				<div class="row">
					<div class="col-md-12">
						<div class="row" >
							<div class="col-md-8" style="margin-bottom: 10px">
								<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalInserirItem" data-new_valor_total={{ $saida->valor_total }} data-new_saida_id={{ $saida->id }}><i class="fa fa-plus"></i></button>
							</div>
							<div class="col-md-4">
								<input type="text" id="pesq" class="form-control" placeholder="Pesquisa...">
							</div>
						</div>
						<table class="table table-striped table-advance table-hover" id="tbl_create_edit_itens_saida" data-order='[[ 0, "desc" ]]'>
							<thead>
								<tr>
									<th><i class="icon_mobile"></i> Designação </th>
									<th class="text-center"><i class="icon_profile"></i>Quantidade</th>
									<th><i class="icon_mail_alt"></i> Preço Unitário </th>
									<th><i class="icon_cogs"></i> Valor Total </th>
									<th class="text-center"><i class="icon_close_alt2"></i> Remover </th>
								</tr>
							</thead>
							<tbody>
								@foreach($saida->itensSaida as $iten_saida)
								<tr>
									<td> {{$iten_saida->produto->descricao}} </td>

									<td class="text-center"> <button type="button" class="btn btn-sm" data-toggle="modal" data-target="#modalProdutoIten" data-saida_id={{ $saida->id }} data-produto_id={{ $iten_saida->produto->id }} data-descricao={{ $iten_saida->produto->descricao }} data-quantidade={{ $iten_saida->quantidade }} data-quantidade_rest={{ $iten_saida->quantidade_rest }} data-qtd_referencial={{ $iten_saida->produto->quantidade_dispo }} data-qtd_min={{ $iten_saida->produto->quantidade_min }} data-preco_venda={{ $iten_saida->produto->preco_venda }} data-valor={{$iten_saida->valor }} data-desconto={{ $iten_saida->desconto }} data-subtotal={{ $iten_saida->subtotal }} data-valor_total={{ $saida->valor_total }} data-user_id={{ Auth::user()->id }}> {{$iten_saida->quantidade}} </button> </td>

									<td> {{$iten_saida->produto->preco_venda}} </td>
									<td> {{$iten_saida->valor}} </td>
									{{ Form::open(['route'=>['iten_saida.destroy', $iten_saida->id], 'method'=>'DELETE']) }}
									<td class="text-center">
										{{ Form::button('<i class="icon_close_alt2"></i>', ['class'=>'btn btn-danger btn-sm submit_iten', 'type'=>'submit'] )}}
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

					<div class="col-md-6 border">


						<div class="panel panel-default">
							<div class="panel-body">
								Motivo Justificativo da não aplicação de imposto:
							</div>
						</div>

					</div>

					<div class="col-md-6 text-right">

						<table class="pull-right">
							<tr>
								<td>Sub-Total:</td>
								<td style="width: 10px"></td>
								<td>{{$saida->valor_total}}</td>
							</tr>
							<tr>
								<td>IVA(17%):</td>
								<td></td>
								<td>{{(($saida->valor_total)*17)/100}}</td>
							</tr>
							<tr>
								<td>Valor Total:</td>
								<td></td>
								<td><b>{{$saida->valor_iva}}</b></td>
							</tr>
						</table>

					</div>

				</div>
				<br><br>
				<div class="row">

					<div class="col-md-6">

						<div class="panel panel-info">
							<div class="panel-heading">
								Dados bancarios
							</div>
							<div class="panel-body">
								@include('layouts.empresa.dados_bancarios_empresa')
							</div>
						</div>

					</div>

					<div class="col-md-6">



					</div>

				</div>
				<div class="row">
					<div class="col-md-6">
						<!-- <a href="" class="btn btn-primary">Imprimir Saída</a> -->

					</div>
					<div class="col-md-6 text-right"><a href="{{route('saida.index')}}" class="btn btn-warning">Voltar</a>

					</div>
				</div>
			</div>


		</div>



	</div>
</div>
<!-- </div> -->

<!-- MODAL INSERIR ITEM -->
@include('saidas.itens_saida.modals.frm_modal_inserir_iten_saida')
<!-- FIM MODAL INSERIR ITEM -->

<!-- MODAL EDITAR ITEM -->
@include('saidas.itens_saida.modals.frm_modal_editar_iten_saida')
<!-- FIM MODAL EDITAR ITEM -->

{{Form::hidden('codigo_saida', $saida->id, ['id'=>'codigo_saida', 'disabled'])}}

@endsection

@section('script')
<script>

	// DataTables Inicio
	$(document).ready(function() {

		var codigo_saida = $('#codigo_saida').val();
		var titulo = "Itens da Factura "+codigo_saida;   
		var msg_bottom = "Papelaria Agenda & Serviços";

		var oTable = $('#tbl_create_edit_itens_saida').DataTable( {
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

  $(document).ready(function(){
  	$(document).ajaxStart(function(){
  		$(".wait").css("display", "block");
  		document.getElementById("new_quantidade").disabled = true;
  	});
  	$(document).ajaxComplete(function(){
  		$(".wait").css("display", "none");
  		document.getElementById("new_quantidade").disabled = false;
			$('#new_quantidade').focus(); // Nao esta no find price por tratar-se de modal aqui.
		});
  });

		//JAVASCRIPT MODAL NOVO ITEM

		$('#modalInserirItem').on('show.bs.modal', function (event) {
				var button = $(event.relatedTarget) // Button that triggered the modal
				var new_dta_valor_total = button.data('new_valor_total')
				var new_dta_saida_id = button.data('new_saida_id')
				var modal = $(this)

				modal.find('.modal-body #new_saida_id').val(new_dta_saida_id);


				$('#modalInserirItem').delegate('#new_produto_id','change',function(){
					// Achar o preco e as quantidades do produto selecionado

					var id = $('#new_produto_id').val();
					var dataId={'id':id};
					$.ajax({
						type  : 'GET',
						url   : '{!!URL::route('findPrice')!!}',
						dataType: 'json',
						data  : dataId,
						success:function(data){
							$('#new_preco_venda').val(data.preco_venda);
							$('#new_quantidade_dispo').val(data.quantidade_dispo - data.quantidade_min);
							$('#new_qtd_referencial').val(data.quantidade_dispo - data.quantidade_min);
							newValidarQuantidadeEspecificada();
							newCalcularValores();
						},
						complete:function(data){
							$('#new_quantidade').focus();
						}
					});
				});

				$('#modalInserirItem').delegate('#new_quantidade','keyup',function(){

					// validar a qtd actual/especificada de acordo com os limites, qtd existente no stock
					newValidarQuantidadeEspecificada();
					
				});


				$('#modalInserirItem').delegate('#new_quantidade,#new_preco_venda,#new_desconto','keyup',function(){
					numberOnly('#new_quantidade');
					numberOnly('#new_desconto');
					
					//calcular os valores de acordo com a qtd e o preco para o NovoItem antes e apos as validacoes acima feitas;
					newCalcularValores();
					


				});

				function newValidarQuantidadeEspecificada(){
					var new_quantidade = $('#new_quantidade').val();
					var new_qtd_referencial = $('#new_qtd_referencial').val();

					new_qtd_referencial = (new_qtd_referencial*1);
      				// Se a quantidade especificada for maior que a quantidade disponivel, mostra um alerta impedindo de avancar e reseta a quantidade escolhida para a quantidade zero
      				if(new_quantidade > new_qtd_referencial){
      					alert('A quantidade especificada excedeu o limite');
      					$('#new_quantidade').val(0);

      					var new_qtd_after_validation_fail = $('#new_quantidade').val();
      					var new_qtd_rest_after_validation_fail = new_qtd_referencial-new_qtd_after_validation_fail;

      					$('#new_quantidade_dispo').val(new_qtd_rest_after_validation_fail);

      				}else{

      					$('#new_quantidade').val(new_quantidade);
      					var new_quantidade_saida_rest = (new_qtd_referencial-new_quantidade);
      					$('#new_quantidade_dispo').val(new_quantidade_saida_rest);
      				}

      			};

      			function newCalcularValores(){

      				var new_quantidade = $('#new_quantidade').val();
      				var new_preco_venda = $('#new_preco_venda').val();
      				var new_desconto = $('#new_desconto').val();
      				var new_subtotal = ((new_quantidade*new_preco_venda)-(new_quantidade*new_preco_venda*new_desconto)/100);
      				var new_valor = (new_quantidade*new_preco_venda);

      				var new_valor_total = (new_dta_valor_total*1);

      				new_valor_total = new_valor_total + new_subtotal;

      				var new_valor_total_iva = (new_valor_total + (new_valor_total*17)/100);

      				$('#new_subtotal').val(new_subtotal);
      				$('#new_valor').val(new_valor);
      				$('#new_valor_total').val(new_valor_total);
      				$('.new_valor_total_iva').html(new_valor_total_iva.formatMoney(2,',','.')+ " Mtn");
      				$('#new_val_temp').html(new_valor_total.formatMoney(2,',','.')+ " Mtn");

      			}


      		});
			// JAVASCRIPT FIM MODAL NOVO ITEM

			// JAVASCRIPT MODAL EDITAR ITEM
			$('#modalProdutoIten').on('show.bs.modal', function (event) {
				var button = $(event.relatedTarget) // Button that triggered the modal
				var dta_saida_id = button.data('saida_id')
				var dta_produto_id = button.data('produto_id')
				var dta_descricao = button.data('descricao')
				var dta_quantidade = button.data('quantidade')
				var dta_dtd_dispo = button.data('qtd_referencial')
				var dta_qtd_min = button.data('qtd_min')
				var dta_quantidade_dispo = (dta_dtd_dispo - dta_qtd_min)
				var dta_qtd_rest = button.data('quantidade_rest')
				var dta_preco_venda = button.data('preco_venda')
				var dta_valor = button.data('valor')
				var dta_desconto = button.data('desconto')
				var dta_subtotal = button.data('subtotal')
				var dta_valor_total = button.data('valor_total')
				var dta_user_id = button.data('user_id')
				var modal = $(this)

				modal.find('.modal-body #saida_id').val(dta_saida_id);
				modal.find('.modal-body #produto_id').val(dta_produto_id);
				modal.find('.modal-body #descricao').val(dta_descricao);
				modal.find('.modal-body #quantidade').val(dta_quantidade);
				modal.find('.modal-body #old_quantidade').val(dta_quantidade);
				modal.find('.modal-body #quantidade_dispo').val((dta_quantidade - dta_qtd_rest)+' - '+dta_quantidade_dispo); //qtd_min deve ser a != entre a qtd e a qtd_restante => min=aquela que ja foi usada pelos itens_guiaentrega
				modal.find('.modal-body #preco_venda').val(dta_preco_venda);
				modal.find('.modal-body #valor').val(dta_valor);
				modal.find('.modal-body #desconto').val(dta_desconto);
				modal.find('.modal-body #subtotal').val(dta_subtotal);
				modal.find('.modal-body #valor_total').val(dta_valor_total);
				modal.find('.modal-body #user_id').val(dta_user_id);
				
				// os dois inputs abaixo sao para efeitos de validacao da qtd no controller
				modal.find('.modal-body #qtd_referencial').val(((dta_quantidade_dispo*1)+dta_quantidade));
				modal.find('.modal-body #qtd_referencial_min_iten_saida').val((dta_quantidade - dta_qtd_rest));



				$('#modalProdutoIten').delegate('#quantidade','keyup',function(){
					// validar a qtd actual/especificada de acordo com os limites, qtd existente no stock
					editValidarQuantidadeEspecificada();

				});

				$('#modalProdutoIten').delegate('#quantidade,#preco_venda,#desconto','keyup',function(){
					
					numberOnly('#quantidade');
					numberOnly('#desconto');

					editCalcularValores();
				});

				function editValidarQuantidadeEspecificada(){

					var mdl_quantidade = $('#quantidade').val();
					var mdl_preco_venda = $('#preco_venda').val();
					var mdl_desconto = $('#desconto').val();
					var mdl_subtotal = ((mdl_quantidade*mdl_preco_venda)-(mdl_quantidade*mdl_preco_venda*mdl_desconto)/100);
					var mdl_valor = (mdl_quantidade*mdl_preco_venda);

					var mdl_valor_total = (dta_valor_total*1);

					var valor_incre_decre = 0;
					
					if(mdl_subtotal > dta_subtotal){

						valor_incre_decre = (mdl_subtotal - dta_subtotal);
						mdl_valor_total = (mdl_valor_total + valor_incre_decre);

					}else if(mdl_subtotal <= dta_subtotal){

						valor_incre_decre = (dta_subtotal - mdl_subtotal);
						mdl_valor_total = (mdl_valor_total - valor_incre_decre);

					}

					var valor_total_iva = (mdl_valor_total + (mdl_valor_total*17)/100);

					$('#subtotal').val(mdl_subtotal);
					$('#valor').val(mdl_valor);
					$('#valor_total').val(mdl_valor_total);
					$('.valor_total_iva').html(valor_total_iva.formatMoney(2,',','.')+ " Mtn");
					$('#val_temp').html(mdl_valor_total.formatMoney(2,',','.')+ " Mtn");
				};

				function editCalcularValores(){
					var quantidade = $('#quantidade').val();
					var qtd_referencial = ((dta_quantidade_dispo*1)+dta_quantidade);
					var qtd_referencial_min_iten_saida = (dta_quantidade - dta_qtd_rest);

					
      				// Se a quantidade especificada for maior que a quantidade disponivel, mostra um alerta impedindo de avancar e reseta a quantidade escolhida para a quantidade inicial a ser ditada.
      				if(quantidade > qtd_referencial){
      					alert('A quantidade especificada excedeu o limite.'+
      						'Quantidade Minima para este item: '+qtd_referencial_min_iten_saida+
      						' Quantidade Maxima para este item: '+qtd_referencial);
      					$('#quantidade').val(dta_quantidade);
        			//

        			var qtd_after_validation_fail = $('#quantidade').val();
        			var qtd_referencial_after_validation_fail = qtd_referencial-qtd_after_validation_fail;

        			$('#quantidade_dispo').val(qtd_referencial_min_iten_saida+'-'+qtd_referencial_after_validation_fail);

        		}else{

        			$('#quantidade').val(quantidade);
        			var quantidade_saida_dispo = (qtd_referencial-quantidade);
        			$('#quantidade_dispo').val(qtd_referencial_min_iten_saida+'-'+quantidade_saida_dispo);
        		}
        	};
        });
		// JAVASCRIPT FIM MODAL EDITAR ITEM

	</script>

	@endsection
