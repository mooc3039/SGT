@extends('layouts.master')
@section('content')

<!-- <div class="container"> -->
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
									Nome do Cliente: {{$cotacao->cliente->nome}}<br>
									Endereço: {{$cotacao->cliente->endereco}}<br>
									Nuit: {{$cotacao->cliente->nuit}}<br>
								</div>
							</div>
						</div>

						<div class="col-md-3">

							<div class="panel panel-default">
								<div class="panel-body text-center">
									<h2> <b> Numero de Cotação / Factura </b> </h2> <hr>
									<h1>{{$cotacao->codigo}}</h1>
								</div>
							</div>


						</div>
					</div>
					<div class="row">
						<div class="col-md-6"> MAPUTO</div>
						<div class="col-md-6 text-right"> Data: {{date('d-m-Y', strtotime($cotacao->created_at))}} </div>
					</div>
				</div>


				<div class="panel-body">

					<div class="row">
						<div class="col-md-12">
							<div class="row" style="margin-bottom: 10px">
								<div class="col-md-8">
									<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalInserirItem" data-new_valor_total={{ $cotacao->valor_total }} data-new_cotacao_id={{ $cotacao->id }} data-new_aplicacao_motivo_iva={{ $cotacao->aplicacao_motivo_iva }}><i class="fa fa-plus"></i></button>
								</div>
								<div class="col-md-4">
									<input type="text" id="pesq" class="form-control" placeholder="Pesquisa...">
								</div>
							</div>
							<table class="table table-striped table-advance table-hover" id="tbl_create_edit_itens_cotacoes" data-order='[[ 0, "desc" ]]'>
								<thead>
									<tr>
										<th> Designação </th>
										<th> Quantidade</th>
										<th> Preço Unitário (Mtn)</th>
										<th> Valor Total (Mtn)</th>
										<th><i class="icon_close_alt2"></i> Remover </th>
									</tr>
								</thead>
								<tbody>
									@foreach($cotacao->itensCotacao as $iten_cotacao)
									<tr>
										<td> {{$iten_cotacao->produto->descricao}} </td>

										<td class="text-center"> <button type="button" class="btn btn-sm" data-toggle="modal" data-target="#modalProdutoIten" data-cotacao_id={{ $cotacao->id }} data-produto_id={{ $iten_cotacao->produto->id }} data-descricao={{ $iten_cotacao->produto->descricao }} data-quantidade={{ $iten_cotacao->quantidade }} data-preco_venda={{ $iten_cotacao->produto->preco_venda }} data-valor={{$iten_cotacao->valor }} data-desconto={{ $iten_cotacao->desconto }} data-subtotal={{ $iten_cotacao->subtotal }} data-valor_total={{ $cotacao->valor_total }} data-aplicacao_motivo_iva={{ $cotacao->aplicacao_motivo_iva }} data-user_id={{ Auth::user()->id }}> {{$iten_cotacao->quantidade}} </button> </td>

										<td> {{number_format($iten_cotacao->produto->preco_venda, 2, '.', ',')}} </td>
										<td> {{number_format($iten_cotacao->valor, 2, '.', ',')}} </td>
										{{ Form::open(['route'=>['iten_cotacao.destroy', $iten_cotacao->id], 'method'=>'DELETE']) }}
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
								<div class="panel-heading">
									Motivo Justificativo da não aplicação de imposto 
									<button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#modalMotivoJustificativo" data-cotacao_id={{ $cotacao->id }}>
										<span><i class="fa fa-pencil"></i></span> 
									</button>
								</div>
								<div class="panel-body">
									<!-- Formulario(arranjado) para conseguir levar o texto inteiro ao modal, o que nao eh possivel com o data-atributies do botao do modal -->
									{{Form::open()}}
									{{Form::hidden('motivo_justificativo_nao_iva', $cotacao->motivo_justificativo_nao_iva, ['disabled', 'id'=>'motivo_justificativo_nao_iva'])}}
									{{Form::close()}}

									@if($cotacao->motivo_iva_id == null)
									{{""}}
									@else
									{{$cotacao->motivoIva->motivo_nao_aplicacao}}
									@endif
								</div>
							</div>

						</div>

						<div class="col-md-6 text-right">

							<table class="pull-right">
								@if($cotacao->aplicacao_motivo_iva == 1)
								<tr>
									<td>Valor Total:</td>
									<td style="width: 10px"></td>
									<td>{{number_format($cotacao->valor_total, 2, '.', ',')}} Mtn</td>
								</tr>
								@else
								<tr>
									<td>Sub-Total:</td>
									<td style="width: 10px"></td>
									<td>{{number_format($cotacao->valor_total, 2, '.', ',')}} Mtn</td>
								</tr>
								<tr>
									<td>IVA(17%):</td>
									<td></td>
									<td>{{number_format($cotacao->iva, 2, '.', ',')}} Mtn</td>
								</tr>
								<tr>
									<td>Valor Total:</td>
									<td></td>
									<td><b>{{number_format($cotacao->valor_iva, 2, '.', ',')}} Mtn</b></td>
								</tr>
								@endif
							</table>

						</div>

					</div>
					<br>
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
						<div class="col-md-6"><a href="" class="btn btn-primary">Imprimir Saída</a>

						</div>
						<div class="col-md-6 text-right"><a href="{{route('cotacao.index')}}" class="btn btn-warning">Voltar</a>

						</div>
					</div>
				</div>


			</div>



		</div>
	</div>
	<!-- </div> -->

	<!-- MODAL EDITAR ITEM -->
	<div class="modal fade" tabindex="-1" role="dialog" id="modalProdutoIten">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title"><b>Cotação: </b>Editar Item<span id=""><span/></h4>
					</div>
					<div class="modal-body">

						{{Form::open(['route'=>['iten_cotacao.update', 'id'], 'method'=>'PUT', 'onsubmit'=>'submitFormCotacao.disabled = true; return true;'])}}

						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									{{Form::label('descricao', 'Designação', ['class'=>'control-lable'])}}
									{{Form::text('descricao', null, ['placeholder' => 'Nome', 'class' => 'form-control', 'id'=>'descricao', 'disabled'])}}
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									{{Form::label('quantidade', 'Quantidade', ['class'=>'control-lable'])}}
									{{Form::text('quantidade', null, ['placeholder' => 'Quantidade', 'class' => 'form-control', 'id'=>'quantidade'])}}
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									{{Form::label('preco_venda', 'Preço Unitário (Mtn)', ['class'=>'control-lable'])}}
									{{Form::text('preco_venda', null, ['placeholder' => 'Preço Unitário', 'class' => 'form-control', 'id'=>'preco_venda', 'disabled'])}}
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									{{Form::label('valor', 'Valor (Mtn)', ['class'=>'control-lable'])}}
									{{Form::text('valor', null, ['placeholder' => 'Valor', 'class' => 'form-control', 'id'=>'valor', 'readonly'])}}

									{{ Form::hidden('cotacao_id', null, ['id'=>'cotacao_id']) }}
									{{ Form::hidden('produto_id', null, ['id'=>'produto_id']) }}
									{{ Form::hidden('user_id', null, ['id'=>'user_id']) }}
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-3">
								<div class="form-group">
									{{Form::label('desconto', 'Desconto (%)', ['class'=>'control-lable'])}}
									{{Form::text('desconto', null, ['placeholder' => 'Desconto', 'class' => 'form-control', 'id'=>'desconto'])}}
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									{{Form::label('subtotal', 'Subtotal (Mtn)', ['class'=>'control-lable'])}}
									{{Form::text('subtotal', null, ['placeholder' => 'Subtotal', 'class' => 'form-control', 'id'=>'subtotal', 'readonly'])}}
								</div>
							</div>
						</div>

					</div>
					<div class="modal-footer">
						<div class="row">
							<div class="col-md-6 text-left">	
								<table>
									<tr>
										<td><h5>Montante Geral da Cotação </h5></td>
										<td></td>
										<td> <h5><b>: <span class="val_total_sem_iva"></span></b></h5></td>
									</tr>
									<tr>
										<td class="hide_iva"><h5>IVA(17%) </h5> </td>
										<td></td>
										<td class="hide_iva"><h5><b>: <span class="iva"></span></b></h5> </td>
									</tr>
									<tr>
										<td class="hide_iva"><h5> Montante Geral da Cotação </h5></td>
										<td></td>
										<td class="hide_iva"><h5><b>: <span class="valor_total_iva"></span></b></h5></td>
									</tr>
								</table>
							</div>
							<div class="col-md-6 text-right">
								{{Form::button('Fechar', ['class'=>'btn btn-default', 'data-dismiss'=>'modal'])}}
								{{Form::submit('Actualizar', ['class'=>'btn btn-primary submit_iten', 'name'=>'submitFormCotacao'])}}
							</div>
						</div>



						{{Form::close()}}
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->

		<!-- FIM MODAL EDITAR ITEM -->

		<!-- MODAL INSERIR ITEM -->
		<div class="modal fade" tabindex="-1" role="dialog" id="modalInserirItem">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title"><b>Cotação: </b>Novo Item<span id=""><span/></h4>
						</div>
						<div class="modal-body">

							{{Form::open(['route'=>'iten_cotacao.store', 'method'=>'POST', 'onsubmit'=>'submitFormCotacao.disabled = true; return true;'])}}

							<div class="row">
								<div class="col-md-3">
									<div class="form-group">
										{{Form::label('descricao', 'Designação', ['class'=>'control-lable'])}}
										{{ Form::select('produto_id', [''=>'Produto',] + $produtos, null, ['class'=>'form-control', 'id'=>'new_produto_id']) }}
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										{{Form::label('quantidade', 'Quantidade', ['class'=>'control-lable'])}}
										{{Form::text('quantidade', null, ['placeholder' => 'Quantidade', 'class' => 'form-control', 'id'=>'new_quantidade'])}}
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										{{Form::label('preco_venda', 'Preço Unitário (Mtn)', ['class'=>'control-lable'])}}
										{{Form::text('preco_venda', null, ['placeholder' => 'Preço Unitário', 'class' => 'form-control', 'id'=>'new_preco_venda', 'disabled'])}}
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										{{Form::label('valor', 'Valor (Mtn)', ['class'=>'control-lable'])}}
										{{Form::text('valor', null, ['placeholder' => 'Valor', 'class' => 'form-control', 'id'=>'new_valor', 'readonly'])}}

										{{ Form::hidden('cotacao_id', null, ['id'=>'new_cotacao_id']) }}
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-3">
									<div class="form-group">
										{{Form::label('desconto', 'Desconto (%)', ['class'=>'control-lable'])}}
										{{Form::text('desconto', 0, ['placeholder' => 'Desconto', 'class' => 'form-control', 'id'=>'new_desconto'])}}
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										{{Form::label('subtotal', 'Subtotal (Mtn)', ['class'=>'control-lable'])}}
										{{Form::text('subtotal', null, ['placeholder' => 'Subtotal', 'class' => 'form-control', 'id'=>'new_subtotal', 'readonly'])}}
									</div>
								</div>
							</div>

						</div>
						<div class="modal-footer">
							<div class="row">
								<div class="col-md-6 text-left">
									<table>
										<tr>
											<td><h5>Montante Geral da Cotação </h5></td>
											<td></td>
											<td> <h5><b>: <span class="new_valor_total_sem_iva"></span></b></h5></td>
										</tr>
										<tr>
											<td class="hide_iva"><h5>IVA(17%) </h5> </td>
											<td></td>
											<td class="hide_iva"><h5><b>: <span class="new_iva"></span></b></h5> </td>
										</tr>
										<tr>
											<td class="hide_iva"><h5> Montante Geral da Cotação </h5></td>
											<td></td>
											<td class="hide_iva"><h5><b>: <span class="new_valor_total_iva"></span></b></h5></td>
										</tr>
									</table>
								</div>
								<div class="col-md-6 text-right">
									{{Form::button('Fechar', ['class'=>'btn btn-default', 'data-dismiss'=>'modal'])}}
									{{Form::submit('Salvar', ['class'=>'btn btn-primary submit_iten', 'name'=>'submitFormCotacao'])}}
								</div>
							</div>



							{{Form::close()}}
						</div>
					</div><!-- /.modal-content -->
				</div><!-- /.modal-dialog -->
			</div><!-- /.modal -->

			<!-- FIM MODAL INSERIR ITEM -->

			<!-- MODAL EDITAR JUSTIFICATIVA -->
			<div class="modal fade" tabindex="-1" role="dialog" id="modalMotivoJustificativo">
				<div class="modal-dialog modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title"><b>Motivo justificativo da não aplicação de imposto: </b>Editar<span id=""><span/></h4>
							</div>
							<div class="modal-body">

								{{Form::open(['route'=>'editar_motivo_cotacao', 'method'=>'POST', 'onsubmit'=>'submitFormMotivoJustificativo.disabled = true; return true;'])}}

								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											
											{{Form::textarea('motivo_justificativo_nao_iva', null, ['class' => 'form-control', 'id'=>'motivo_justificativo_nao_iva'])}}

											{{Form::hidden('cotacao_id', null, ['class' => 'form-control', 'id'=>'cotacao_id'])}}
										</div>
									</div>
								</div>



								<div class="modal-footer">
									<div class="row">
										<div class="col-md-6 text-left">

										</div>
										<div class="col-md-6 text-right">
											{{Form::button('Fechar', ['class'=>'btn btn-default', 'data-dismiss'=>'modal'])}}
											{{Form::submit('Salvar', ['class'=>'btn btn-primary submit_iten', 'name'=>'submitFormMotivoJustificativo'])}}
										</div>
									</div>



									{{Form::close()}}
								</div>
							</div>
						</div><!-- /.modal-content -->
					</div><!-- /.modal-dialog -->
				</div><!-- /.modal -->

				<!-- FIM MODAL EDITAR JUSTIFICATIVA -->

				{{Form::hidden('codigo_cotacao', $cotacao->id, ['id'=>'codigo_cotacao', 'disabled'])}}
				@endsection

				@section('script')
				<script>

				 // DataTables Inicio
				 $(document).ready(function() {

				 	var codigo_cotacao = $('#codigo_cotacao').val();
				 	var titulo = "Itens da Venda "+codigo_cotacao;   
				 	var msg_bottom = "Papelaria Agenda & Serviços";

				 	var oTable = $('#tbl_create_edit_itens_cotacoes').DataTable( {
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
  		$('#new_quantidade').focus();
  	});
  });

  $('#modalProdutoIten').on('show.bs.modal', function (event) {
				var button = $(event.relatedTarget) // Button that triggered the modal
				var dta_cotacao_id = button.data('cotacao_id')
				var dta_produto_id = button.data('produto_id')
				var dta_descricao = button.data('descricao')
				var dta_quantidade = button.data('quantidade')
				var dta_preco_venda = button.data('preco_venda')
				var dta_valor = button.data('valor')
				var dta_desconto = button.data('desconto')
				var dta_subtotal = button.data('subtotal')
				var dta_valor_total = button.data('valor_total')
				var dta_aplicacao_motivo_iva = button.data('aplicacao_motivo_iva')

				var dta_user_id = button.data('user_id')
				var modal = $(this)

				modal.find('.modal-body #cotacao_id').val(dta_cotacao_id);
				modal.find('.modal-body #produto_id').val(dta_produto_id);
				modal.find('.modal-body #descricao').val(dta_descricao);
				modal.find('.modal-body #quantidade').val(dta_quantidade);
				modal.find('.modal-body #preco_venda').val(Number.parseFloat(dta_preco_venda).formatMoney());
				modal.find('.modal-body #valor').val(Number.parseFloat(dta_valor).formatMoney());
				modal.find('.modal-body #desconto').val(dta_desconto);
				modal.find('.modal-body #subtotal').val(Number.parseFloat(dta_subtotal).formatMoney());
				// modal.find('.modal-body #valor_total').val(Number.parseFloat(dta_valor_total).formatMoney());
				modal.find('.modal-body #user_id').val(dta_user_id);

				calcularIten();

				if(dta_aplicacao_motivo_iva == 1){
					hideIva();

				}
				
				$('#modalProdutoIten').delegate('#quantidade,#preco_venda,#desconto','keyup',function(){
					numberOnly('#quantidade'); // Validacao. Campos aceitam numeros e pontos apenas
					numberOnly('#desconto');

					calcularIten();
					
					if(dta_aplicacao_motivo_iva == 1){
						hideIva();
					}

				});

				function calcularIten(){

					var mdl_quantidade = Number.parseInt(0);
					if( ($('#quantidade').val()) === "" || ($('#quantidade').val()) === null){
						mdl_quantidade = Number.parseInt(0);
					}else{
						mdl_quantidade = Number.parseInt($('#quantidade').val());
					}

					var mdl_preco_venda = Number.parseFloat(($('#preco_venda').val()).replace(/[^0-9-.]/g, ''));
					var mdl_desconto = Number.parseInt($('#desconto').val());
					var mdl_subtotal = Number.parseFloat(((mdl_quantidade*mdl_preco_venda)-(mdl_quantidade*mdl_preco_venda*mdl_desconto)/100));
					var mdl_valor = Number.parseFloat((mdl_quantidade*mdl_preco_venda));

					var mdl_valor_total = Number.parseFloat(dta_valor_total);

					var valor_incre_decre = Number.parseFloat(0);

					if(mdl_subtotal > dta_subtotal){

						valor_incre_decre = (mdl_subtotal - dta_subtotal);
						mdl_valor_total = (mdl_valor_total + valor_incre_decre);

					}else if(mdl_subtotal <= dta_subtotal){

						valor_incre_decre = (dta_subtotal - mdl_subtotal);
						mdl_valor_total = (mdl_valor_total - valor_incre_decre);

					}

					var iva = Number.parseFloat(Number.parseFloat((mdl_valor_total*17)/100).toFixed(2));
					var valor_total_iva = (mdl_valor_total + iva);

					$('#subtotal').val(mdl_subtotal.formatMoney());
					$('#valor').val(mdl_valor.formatMoney());
					$('#valor_total').val(mdl_valor_total);
					$('.val_total_sem_iva').html(mdl_valor_total.formatMoney()+ " Mtn");
					$('.iva').html(iva.formatMoney()+ " Mtn");
					$('.valor_total_iva').html(valor_total_iva.formatMoney()+ " Mtn");
				}

				
			});

			// MODAL NOVO ITEM

			$('#modalInserirItem').on('show.bs.modal', function (event) {
				var button = $(event.relatedTarget) // Button that triggered the modal
				var new_dta_valor_total = button.data('new_valor_total')
				var new_dta_cotacao_id = button.data('new_cotacao_id')
				var new_aplicacao_motivo_iva = button.data('new_aplicacao_motivo_iva')

				var modal = $(this)
				modal.find('.modal-body #new_cotacao_id').val(new_dta_cotacao_id);

				$('#modalInserirItem').delegate('#new_quantidade,#new_preco_venda,#new_desconto','keyup',function(){
					numberOnly('#new_quantidade');
					numberOnly('#new_desconto');
					calcularValores(); // calcula e preenche todos campos dinamicos.
					if(new_aplicacao_motivo_iva == 1){
						hideIva();
					}

				});


				$('#modalInserirItem').delegate('#new_produto_id','change',function(){
					

					var id = $('#new_produto_id').val();
					var dataId={'id':id};
					$.ajax({
						type  : 'GET',
						url   : '{!!URL::route('findPrice')!!}',
						dataType: 'json',
						data  : dataId,
						success:function(data){
							$('#new_preco_venda').val(data.preco_venda);
							calcularValores();

							if(new_aplicacao_motivo_iva == 1){
								hideIva();
							}
						},
						complete:function(data){
							$('#new_quantidade').focus();
						}
					});
				});

				function calcularValores(){

					var new_quantidade = Number.parseInt(0);
					if( ($('#new_quantidade').val()) === "" || ($('#new_quantidade').val()) === null){
						new_quantidade = Number.parseInt(0);
					}else{
						new_quantidade = Number.parseInt($('#new_quantidade').val());
					}

					var new_preco_venda = Number.parseFloat(($('#new_preco_venda').val()).replace(/[^0-9-.]/g, ''));
					var new_desconto = Number.parseInt($('#new_desconto').val());
					var new_subtotal = Number.parseFloat((new_quantidade*new_preco_venda)-(new_quantidade*new_preco_venda*new_desconto)/100);
					var new_valor = Number.parseFloat(new_quantidade*new_preco_venda);

					var new_valor_total = Number.parseFloat(new_dta_valor_total);

					new_valor_total = new_valor_total + new_subtotal;
					var new_iva = Number.parseFloat(Number.parseFloat((new_valor_total*17)/100).toFixed(2));

					var new_valor_total_iva = (new_valor_total + new_iva);

					$('#new_subtotal').val(new_subtotal.formatMoney());
					$('#new_valor').val(new_valor.formatMoney());
					$('.new_valor_total_sem_iva').html(new_valor_total.formatMoney() + "Mtn");
					$('.new_iva').html(new_iva.formatMoney() + "Mtn");
					$('.new_valor_total_iva').html(new_valor_total_iva.formatMoney() + " Mtn");
				}

			});
			// FIM MODAL NOVO ITEM

			// $('#modalMotivoJustificativo').on('show.bs.modal', function (event) {

			// 	var button = $(event.relatedTarget); // Button that triggered the modal
			// 	var dta_cotacao_id = button.data('cotacao_id')
			// 	var motivo_justificativo_nao_iva = $('#motivo_justificativo_nao_iva').val();

			// 	var modal = $(this);

			// 	modal.find('.modal-body #cotacao_id').val(dta_cotacao_id);
			// 	modal.find('.modal-body #motivo_justificativo_nao_iva').val(motivo_justificativo_nao_iva);
			// 	// console.log(dta_motivo_justificativo_nao_iva);
			// });

			function hideIva(){

				var hide_iva = document.getElementsByClassName('hide_iva');
				var show_iva = document.getElementsByClassName('show_iva');

				for(i=0; i<hide_iva.length; i++){
					hide_iva[i].style.display = "none";
				}

				for(i=0; i<show_iva.length; i++){
					show_iva[i].style.display = "block";
				}

			}

		</script>

		@endsection
