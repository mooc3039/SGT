@extends('layouts.master')
@section('content')

<!-- <div class="container"> -->
	<div class="row">
		<div class="col-md-12">
			
			<div class="row">
				<div class="col-md-12">

					<div class="panel panel-default">
						<div class="panel-heading">
							<div class="row">
								<div class="col-md-5 border">
									<div class="panel panel-default">

										<div class="panel-body">
											Papelaria e Serviços Agenda<hr>
											Emal: papelaria@gmail.com<br>
											Telefone: +218293503 / +258840294826<br>
											Endereco: Av. 24 de Julho<br>
										</div>
									</div>



								</div>

								<div class="col-md-4">

									<div class="panel panel-default">
										<div class="panel-body text-center">
											<h2> <b> Dados do Cliente </b></h2> <hr>
											Nome do Cliente: {{$guia_entrega->cliente->nome}}<br>
											Endereço: {{$guia_entrega->cliente->endereco}}<br>
											Nuit: {{$guia_entrega->cliente->nuit}}<br>
										</div>
									</div>
								</div>

								<div class="col-md-3">

									<div class="panel panel-default">
										<div class="panel-body text-center">
											<h2> <b> Numero da Guia de Entrega / Factura </b> </h2> <hr>
											<h1>{{$guia_entrega->id}}</h1>
										</div>
									</div>


								</div>
							</div>
							<div class="row">
								<div class="col-md-6"> MAPUTO</div>
								<div class="col-md-6 text-right"> Data: {{date('d-m-Y', strtotime($guia_entrega->created_at))}} </div>
							</div>
						</div>


						<div class="panel-body">

							<div class="row">
								<div class="col-md-12">
									<table class="table table-striped table-advance table-hover">
										<thead>
											<tr>
												<th><i class="icon_mobile"></i> Designação </th>
												<th class="text-center"><i class="icon_profile"></i>Quantidade</th>
												<th><i class="icon_mail_alt"></i> Preço Unitário </th>
												<th><i class="icon_cogs"></i> Valor Total </th>
												<!-- <th class="text-center"><i class="icon_close_alt2"></i> Remover </th> -->
											</tr>
										</thead>
										<tbody>
											@foreach($guia_entrega->itensGuiantrega as $iten_guia_entrega)
											<tr>
												<td> {{$iten_guia_entrega->produto->descricao}}</td>

												<td class="text-center"> <button type="button" class="btn btn-sm" data-toggle="modal" data-target="#modalProdutoIten" data-guia_entrega_id={{ $guia_entrega->id }} data-produto_id={{ $iten_guia_entrega->produto->id }} data-descricao={{ $iten_guia_entrega->produto->descricao }} data-quantidade={{ $iten_guia_entrega->quantidade }}  data-qtd_rest_iten_saida={{ $iten_guia_entrega->itenSaida->quantidade_rest}} data-preco_venda={{ $iten_guia_entrega->produto->preco_venda }} data-valor={{$iten_guia_entrega->valor }} data-desconto={{ $iten_guia_entrega->desconto }} data-subtotal={{ $iten_guia_entrega->subtotal }} data-valor_total={{ $guia_entrega->valor_total }} data-user_id={{ Auth::user()->id }}> {{$iten_guia_entrega->quantidade}} </button> </td>

												<td> {{$iten_guia_entrega->produto->preco_venda}} </td>
												<td> {{$iten_guia_entrega->valor}} </td>
										<!-- {{ Form::open() }}
										<td class="text-center">
											{{ Form::button('<i class="icon_close_alt2"></i>', ['class'=>'btn btn-danger btn-sm', 'type'=>'submit'] )}}
										</td>
										{{ Form::close() }} -->

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
								<tr><td> Valor Total:</td>
									<td><b>{{$guia_entrega->valor_total}}</b></td>
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
									Conta BCI (MZN) 54169166 10 1<br>
									Conta BIM (MZN) 5299/07<br>
								</div>
							</div>

						</div>

						<div class="col-md-6">



						</div>

					</div>
					<div class="row">
						<div class="col-md-6"><a href="" class="btn btn-primary">Imprimir Saída</a>

						</div>
						<div class="col-md-6 text-right"><a href="{{route('show_guia_entrega', $guia_entrega->saida_id)}}" class="btn btn-warning">Cancelar</a>

						</div>
					</div>
				</div>


			</div>



		</div>
	</div>
	<!-- </div> -->

	<!-- MODAL EDITAR ITEM -->
	@include('guias_entrega.itens_guiaentrega.modals.frm_modal_editar_iten_guia_entrega')
	<!-- FIM MODAL EDITAR ITEM -->


	@endsection

	@section('script')

	<script type="text/javascript">

		$(document).ready(function(){
			$('.submit_iten').on('click',function(){
				$("#wait").css("display", "block");
			});
		});

		$('#modalProdutoIten').on('show.bs.modal', function (event) {
				var button = $(event.relatedTarget) // Button that triggered the modal
				var dta_guia_entrega_id = button.data('guia_entrega_id')
				var dta_produto_id = button.data('produto_id')
				var dta_descricao = button.data('descricao')
				var dta_quantidade = button.data('quantidade')
				var dta_qtd_rest_iten_saida = button.data('qtd_rest_iten_saida')
				var dta_preco_venda = button.data('preco_venda')
				var dta_valor = button.data('valor')
				var dta_desconto = button.data('desconto')
				var dta_subtotal = button.data('subtotal')
				var dta_valor_total = button.data('valor_total')

				var dta_user_id = button.data('user_id')
				var modal = $(this)

				modal.find('.modal-body #guia_entrega_id').val(dta_guia_entrega_id);
				modal.find('.modal-body #produto_id').val(dta_produto_id);
				modal.find('.modal-body #descricao').val(dta_descricao);
				modal.find('.modal-body #quantidade').val(dta_quantidade);
				modal.find('.modal-body #qtd_rest_iten_saida').val(dta_qtd_rest_iten_saida);
				modal.find('.modal-body #preco_venda').val(dta_preco_venda);
				modal.find('.modal-body #valor').val(dta_valor);
				modal.find('.modal-body #desconto').val(dta_desconto);
				modal.find('.modal-body #subtotal').val(dta_subtotal);
				modal.find('.modal-body #valor_total').val(dta_valor_total);
				modal.find('.modal-body #user_id').val(dta_user_id);


				// o inputs abaixo eh para efeitos de validacao da qtd no controller. Esta qtd_referencial eh o limite que o usuario pode especificar, e tendo em conta que o input tras uma qtd, esse limite sera a qtd disponivel mais a qtd que vem no input para edicao.
				modal.find('.modal-body #qtd_referencial').val((dta_qtd_rest_iten_saida*1)+dta_quantidade);

				

				$('#modalProdutoIten').delegate('#quantidade','keyup',function(){
					
					EditValidarQuantidadeEspecificada();

				});

				$('#modalProdutoIten').delegate('#quantidade,#preco_venda,#desconto','keyup',function(){
					
					numberOnly('#quantidade');
					number('#desconto');
					EditCalcularValores();

				});

				function EditValidarQuantidadeEspecificada(){

					var quantidade = $('#quantidade').val();
					var qtd_referencial = dta_qtd_rest_iten_saida;

					qtd_referencial = (qtd_referencial*1)+dta_quantidade;
      				// Se a quantidade especificada for maior que a quantidade disponivel, mostra um alerta impedindo de avancar e reseta a quantidade escolhida para a quantidade inicial a ser editada.
      				if(quantidade > qtd_referencial){
      					alert('A quantidade especificada excedeu o limite');
      					$('#quantidade').val(dta_quantidade);

      					var qtd_after_validation_fail = $('#quantidade').val();
      					var qtd_rest_after_validation_fail = qtd_referencial-qtd_after_validation_fail;

      					$('#qtd_rest_iten_saida').val(qtd_rest_after_validation_fail);

      				}else{

      					$('#quantidade').val(quantidade);
      					var quantidade_saida_rest = (qtd_referencial-quantidade);
      					$('#qtd_rest_iten_saida').val(quantidade_saida_rest);
      				}
      			}

      			function EditCalcularValores(){

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

      				$('#subtotal').val(mdl_subtotal);
      				$('#valor').val(mdl_valor);
      				$('#valor_total').val(mdl_valor_total);
      				$('#val_temp').html(mdl_valor_total.formatMoney(2,',','.')+ " Mtn");
      			}
      		});


      	</script>
      	@endsection