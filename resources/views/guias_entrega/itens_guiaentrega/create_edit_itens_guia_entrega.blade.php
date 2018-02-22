@extends('layouts.empty_base')
@section('content')

<div class="container">
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
						<div class="col-md-6 text-right"> Data: {{$guia_entrega->created_at}} </div>
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
										<th class="text-center"><i class="icon_close_alt2"></i> Remover </th>
									</tr>
								</thead>
								<tbody>
									@foreach($guia_entrega->itensGuiantrega as $iten_guia_entrega)
									<tr>
										<td> {{$iten_guia_entrega->produto->descricao}}</td>

										<td class="text-center"> <button type="button" class="btn btn-sm" data-toggle="modal" data-target="#modalProdutoIten" data-guia_entrega_id={{ $guia_entrega->id }} data-produto_id={{ $iten_guia_entrega->produto->id }} data-descricao={{ $iten_guia_entrega->produto->descricao }} data-quantidade={{ $iten_guia_entrega->quantidade }} data-quantidade_rest_iten_saida={{ $iten_guia_entrega->quantidade_rest_iten_saida }} data-preco_venda={{ $iten_guia_entrega->produto->preco_venda }} data-valor={{$iten_guia_entrega->valor }} data-desconto={{ $iten_guia_entrega->desconto }} data-subtotal={{ $iten_guia_entrega->subtotal }} data-valor_total={{ $guia_entrega->valor_total }} data-user_id={{ Auth::user()->id }}> {{$iten_guia_entrega->quantidade}} </button> </td>

										<td> {{$iten_guia_entrega->produto->preco_venda}} </td>
										<td> {{$iten_guia_entrega->valor}} </td>
										{{ Form::open() }}
										<td class="text-center">
											{{ Form::button('<i class="icon_close_alt2"></i>', ['class'=>'btn btn-danger btn-sm', 'type'=>'submit'] )}}
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
									<td>{{$guia_entrega->subtotal}}</td>
								</tr>

								<tr>
									<td>IVA:</td>
									<td>17%</td>
								</tr>

								<tr>
									<td>Desconto:</td>
									<td>{{$guia_entrega->desconto}}</td>
								</tr>

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
						<div class="col-md-6 text-right"><a href="{{route('guia_entrega.index')}}" class="btn btn-warning">Cancelar</a>

						</div>
					</div>
				</div>


			</div>



		</div>
	</div>
</div>

<!-- MODAL EDITAR ITEM -->
<div class="modal fade" tabindex="-1" role="dialog" id="modalProdutoIten">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"><b>Guia de Entrega: </b>Editar Item<span id=""><span/></h4>
				</div>
				<div class="modal-body">

					{{Form::open(['route'=>['iten_guia_entrega.update', 'id'], 'method'=>'PUT'])}}

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
								{{Form::label('quantidade', 'Quantidade-Restante', ['class'=>'control-lable'])}}
								{{Form::text('quantidade_rest_iten_saida', null, ['class' => 'form-control', 'id'=>'quantidade_rest_iten_saida', 'readonly'])}}
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								{{Form::label('preco_venda', 'Preço Unitário', ['class'=>'control-lable'])}}
								{{Form::text('preco_venda', null, ['placeholder' => 'Preço Unitário', 'class' => 'form-control', 'id'=>'preco_venda', 'disabled'])}}
							</div>
						</div>

					</div>
					<div class="row">
						<div class="col-md-3">
							<div class="form-group">
								{{Form::label('valor', 'Valor', ['class'=>'control-lable'])}}
								{{Form::text('valor', null, ['placeholder' => 'Valor', 'class' => 'form-control', 'id'=>'valor', 'readonly'])}}

								{{ Form::hidden('guia_entrega_id', null, ['id'=>'guia_entrega_id']) }}
								{{ Form::hidden('produto_id', null, ['id'=>'produto_id']) }}
								{{ Form::hidden('user_id', null, ['id'=>'user_id']) }}
								{{ Form::hidden('qtd_rest_original', null, ['id'=>'qtd_rest_original', 'disabled']) }}
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								{{Form::label('desconto', 'Desconto', ['class'=>'control-lable'])}}
								{{Form::text('desconto', null, ['placeholder' => 'Desconto', 'class' => 'form-control', 'id'=>'desconto'])}}
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								{{Form::label('subtotal', 'Subtotal', ['class'=>'control-lable'])}}
								{{Form::text('subtotal', null, ['placeholder' => 'Subtotal', 'class' => 'form-control', 'id'=>'subtotal', 'readonly'])}}
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								{{ Form::hidden('valor_total', null, ['id'=>'valor_total']) }}
							</div>
						</div>
					</div>

				</div>
				<div class="modal-footer">
					<div class="row">
						<div class="col-md-6 text-left">
							<h5>Montante Geral da Guia: <b><span id="val_temp"></span></b></h5>
						</div>
						<div class="col-md-6 text-right">
							{{Form::button('Fechar', ['class'=>'btn btn-default', 'data-dismiss'=>'modal'])}}
							{{Form::submit('Actualizar', ['class'=>'btn btn-primary'])}}
						</div>
					</div>



					{{Form::close()}}
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	<!-- FIM MODAL EDITAR ITEM -->
	@endsection

	@section('script')

	<script type="text/javascript">
		$('#modalProdutoIten').on('show.bs.modal', function (event) {
				var button = $(event.relatedTarget) // Button that triggered the modal
				var dta_guia_entrega_id = button.data('guia_entrega_id')
				var dta_produto_id = button.data('produto_id')
				var dta_descricao = button.data('descricao')
				var dta_quantidade = button.data('quantidade')
				var dta_quantidade_rest_iten_saida = button.data('quantidade_rest_iten_saida')
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
				modal.find('.modal-body #quantidade_rest_iten_saida').val(dta_quantidade_rest_iten_saida);
				modal.find('.modal-body #qtd_rest_original').val(dta_quantidade_rest_iten_saida);
				modal.find('.modal-body #preco_venda').val(dta_preco_venda);
				modal.find('.modal-body #valor').val(dta_valor);
				modal.find('.modal-body #desconto').val(dta_desconto);
				modal.find('.modal-body #subtotal').val(dta_subtotal);
				modal.find('.modal-body #valor_total').val(dta_valor_total);
				modal.find('.modal-body #user_id').val(dta_user_id);

				

				$('#modalProdutoIten').delegate('#quantidade','keyup',function(){
					var quantidade = $('#quantidade').val();
					var qtd_rest_original = $('#qtd_rest_original').val();

					qtd_rest_original = (qtd_rest_original*1)+dta_quantidade;
      				// Se a quantidade especificada for maior que a quantidade disponivel, mostra um alerta impedindo de avancar e reseta a quantidade escolhida para a quantidade disponivel no iten_saida. Neste processo actualiza o valor e o subtotal de acordoo com a quantidade, tanto ao exceder o limite como nao
      				if(quantidade > qtd_rest_original){
      					alert('A quantidade especificada excedeu o limite');
      					$('#quantidade').val(qtd_rest_original);
        			//

	        			var qtd_after_validation_fail = $('#quantidade').val();
	        			var qtd_rest_after_validation_fail = qtd_rest_original-qtd_after_validation_fail;

        				$('#quantidade_rest_iten_saida').val(qtd_rest_after_validation_fail);

        			}else{

	        			$('#quantidade').val(quantidade);
	        			var quantidade_saida_rest = (qtd_rest_original-quantidade);
	        			$('#quantidade_rest_iten_saida').val(quantidade_saida_rest);
        			}



  				});

  				$('#modalProdutoIten').delegate('#quantidade,#preco_venda,#desconto','keyup',function(){
					//total();
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


				});
			});

		</script>
		@endsection