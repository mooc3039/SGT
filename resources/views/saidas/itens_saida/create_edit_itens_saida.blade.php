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
										Nome do Cliente: {{$saida->cliente->nome}}<br>
										Endereço: {{$saida->cliente->endereco}}<br>
										Nuit: {{$saida->cliente->nuit}}<br>
									</div>
								</div>
							</div>

							<div class="col-md-3">

								<div class="panel panel-default">
									<div class="panel-body text-center">
										<h2> <b> Numero da Saída / Factura </b> </h2> <hr>
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
									<div class="col-md-12" style="margin-bottom: 10px">
										<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalInserirItem" data-new_valor_total={{ $saida->valor_total }} data-new_saida_id={{ $saida->id }}><i class="fa fa-plus"></i></button>
									</div>
								</div>
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
										@foreach($saida->itensSaida as $iten_saida)
											<tr>
												<td> {{$iten_saida->produto->descricao}} </td>

												<td class="text-center"> <button type="button" class="btn btn-sm" data-toggle="modal" data-target="#modalProdutoIten" data-saida_id={{ $saida->id }} data-produto_id={{ $iten_saida->produto->id }} data-descricao={{ $iten_saida->produto->descricao }} data-quantidade={{ $iten_saida->quantidade }} data-preco_venda={{ $iten_saida->produto->preco_venda }} data-valor={{$iten_saida->valor }} data-desconto={{ $iten_saida->desconto }} data-subtotal={{ $iten_saida->subtotal }} data-valor_total={{ $saida->valor_total }} data-quantidade_rest={{$iten_saida->quantidade_rest}} data-valor_rest={{$iten_saida->valor_rest}} data-subtotal_rest={{$iten_saida->subtotal_rest}} data-user_id={{ Auth::user()->id }}> {{$iten_saida->quantidade}} </button> </td>

												<td> {{$iten_saida->produto->preco_venda}} </td>
												<td> {{$iten_saida->valor}} </td>
												{{ Form::open(['route'=>['iten_saida.destroy', $iten_saida->id], 'method'=>'DELETE']) }}
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
										<td>{{$saida->subtotal}}</td>
									</tr>

									<tr>
										<td>IVA:</td>
										<td>17%</td>
									</tr>

									<tr>
										<td>Desconto:</td>
										<td>{{$saida->desconto}}</td>
									</tr>

									<tr><td> Valor Total:</td>
										<td><b>{{$saida->valor_total}}</b></td>
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
							<div class="col-md-6 text-right"><a href="{{route('saida.index')}}" class="btn btn-warning">Cancelar</a>

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
					<h4 class="modal-title"><b>Saída: </b>Editar Item<span id=""><span/></h4>
					</div>
					<div class="modal-body">

						{{Form::open(['route'=>['iten_saida.update', 'id'], 'method'=>'PUT'])}}

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
									{{Form::label('preco_venda', 'Preço Unitário', ['class'=>'control-lable'])}}
									{{Form::text('preco_venda', null, ['placeholder' => 'Preço Unitário', 'class' => 'form-control', 'id'=>'preco_venda', 'disabled'])}}
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									{{Form::label('valor', 'Valor', ['class'=>'control-lable'])}}
									{{Form::text('valor', null, ['placeholder' => 'Valor', 'class' => 'form-control', 'id'=>'valor', 'readonly'])}}

									{{ Form::hidden('saida_id', null, ['id'=>'saida_id']) }}
									{{ Form::hidden('produto_id', null, ['id'=>'produto_id']) }}
									{{ Form::hidden('user_id', null, ['id'=>'user_id']) }}
								</div>
							</div>
						</div>
						<div class="row">
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
									{{Form::hidden('quantidade_rest', null, ['placeholder' => 'Qtd-Rest', 'class' => 'form-control', 'id'=>'quantidade_rest', 'readonly'])}}

									{{Form::hidden('valor_rest', null, ['placeholder' => 'Sub-Rest', 'class' => 'form-control', 'id'=>'valor_rest', 'readonly'])}}

									{{Form::hidden('subtotal_rest', null, ['placeholder' => 'Sub-Rest', 'class' => 'form-control', 'id'=>'subtotal_rest', 'readonly'])}}
								</div>
							</div>
						</div>

					</div>
					<div class="modal-footer">
						<div class="row">
							<div class="col-md-6 text-left">
								<h5>Montante Geral da Cotação: <b><span id="val_temp"></span></b></h5>
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

		<!-- MODAL INSERIR ITEM -->
		<div class="modal fade" tabindex="-1" role="dialog" id="modalInserirItem">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title"><b>Saída: </b>Novo Item<span id=""><span/></h4>
						</div>
						<div class="modal-body">

							{{Form::open(['route'=>'iten_saida.store', 'method'=>'POST'])}}

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
										{{Form::label('preco_venda', 'Preço Unitário', ['class'=>'control-lable'])}}
										{{Form::text('preco_venda', null, ['placeholder' => 'Preço Unitário', 'class' => 'form-control', 'id'=>'new_preco_venda', 'disabled'])}}
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										{{Form::label('valor', 'Valor', ['class'=>'control-lable'])}}
										{{Form::text('valor', null, ['placeholder' => 'Valor', 'class' => 'form-control', 'id'=>'new_valor', 'readonly'])}}

										{{ Form::hidden('saida_id', null, ['id'=>'new_saida_id']) }}
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-3">
									<div class="form-group">
										{{Form::label('desconto', 'Desconto', ['class'=>'control-lable'])}}
										{{Form::text('desconto', 0, ['placeholder' => 'Desconto', 'class' => 'form-control', 'id'=>'new_desconto'])}}
									</div>
								</div>
								<div class="col-md-3">
									<div class="form-group">
										{{Form::label('subtotal', 'Subtotal', ['class'=>'control-lable'])}}
										{{Form::text('subtotal', null, ['placeholder' => 'Subtotal', 'class' => 'form-control', 'id'=>'new_subtotal', 'readonly'])}}
									</div>
								</div>
							</div>

						</div>
						<div class="modal-footer">
							<div class="row">
								<div class="col-md-6 text-left">
									<h5>Montante Geral da Cotação: <b><span id="new_val_temp"></span></b></h5>
								</div>
								<div class="col-md-6 text-right">
									{{Form::button('Fechar', ['class'=>'btn btn-default', 'data-dismiss'=>'modal'])}}
									{{Form::submit('Salvar', ['class'=>'btn btn-primary'])}}
								</div>
							</div>



							{{Form::close()}}
						</div>
					</div><!-- /.modal-content -->
				</div><!-- /.modal-dialog -->
			</div><!-- /.modal -->

			<!-- FIM MODAL INSERIR ITEM -->
		@endsection

		@section('script')
			<script>

			$('#modalProdutoIten').on('show.bs.modal', function (event) {
				var button = $(event.relatedTarget) // Button that triggered the modal
				var dta_saida_id = button.data('saida_id')
				var dta_produto_id = button.data('produto_id')
				var dta_descricao = button.data('descricao')
				var dta_quantidade = button.data('quantidade')
				var dta_preco_venda = button.data('preco_venda')
				var dta_valor = button.data('valor')
				var dta_desconto = button.data('desconto')
				var dta_subtotal = button.data('subtotal')
				var dta_valor_total = button.data('valor_total')


				var dta_quantidade_rest = button.data('quantidade_rest')
				var dta_valor_rest = button.data('valor_rest')
				var dta_subtotal_rest = button.data('subtotal_rest')

				var dta_user_id = button.data('user_id')
				var modal = $(this)

				modal.find('.modal-body #saida_id').val(dta_saida_id);
				modal.find('.modal-body #produto_id').val(dta_produto_id);
				modal.find('.modal-body #descricao').val(dta_descricao);
				modal.find('.modal-body #quantidade').val(dta_quantidade);
				modal.find('.modal-body #preco_venda').val(dta_preco_venda);
				modal.find('.modal-body #valor').val(dta_valor);
				modal.find('.modal-body #desconto').val(dta_desconto);
				modal.find('.modal-body #subtotal').val(dta_subtotal);
				modal.find('.modal-body #valor_total').val(dta_valor_total);
				modal.find('.modal-body #user_id').val(dta_user_id);

				modal.find('.modal-body #quantidade_rest').val(dta_quantidade_rest);
				modal.find('.modal-body #valor_rest').val(dta_valor_rest);
				modal.find('.modal-body #subtotal_rest').val(dta_subtotal_rest);

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

					// actualizacao dos valores restantes na iten_saidas atravez do formulario, para evitar um self-before-update trigger nos campos "...rest", que pode causar conflito com os triggers vindo de outras tabelas para fazer um UPDATE na iten_saidas. Isso faria com que o update dos tiggers vindo de fora disparasse o self-trigger que eh ou seria before/after "UPDATE".Este conflito anula as operacoes do primeiro update do trigger vindo de fora.
					// => quantidade_rest
					var quantidade_rest = dta_quantidade_rest;
					var valor_rest = dta_valor_rest;
					var subtotal_rest = dta_subtotal_rest;

					var qtd_incre_decre = 0;
					if(mdl_quantidade > dta_quantidade){

						qtd_incre_decre = (mdl_quantidade - dta_quantidade);
						quantidade_rest = (quantidade_rest + qtd_incre_decre);
						valor_rest = (quantidade_rest*mdl_preco_venda);
						subtotal_rest = ((quantidade_rest*mdl_preco_venda)-(quantidade_rest*mdl_preco_venda*mdl_desconto)/100);

					}else if(mdl_quantidade <= dta_quantidade){

						qtd_incre_decre = (dta_quantidade - mdl_quantidade);
						quantidade_rest = (quantidade_rest - qtd_incre_decre);
						valor_rest = (quantidade_rest*mdl_preco_venda);
						subtotal_rest = ((quantidade_rest*mdl_preco_venda)-(quantidade_rest*mdl_preco_venda*mdl_desconto)/100);

					}

					
					$('#quantidade_rest').val(quantidade_rest);
					$('#valor_rest').val(valor_rest);
					$('#subtotal_rest').val(subtotal_rest);


				});
			});

			//======pegar os valores dos campos e calcular o valor de cada produto====


			// function total()
			// {
			//   var total =0;
			//   $('#subtotal').each(function(i,e){
			//     var subtotal = $(this).val()-0;
			//     total +=subtotal;
			//   })
			//   $('.valor_visual').html(total.formatMoney(2,',','.')+ " Mtn");
			//   $('.valor_total').val(total);
			// };

			// MODAL NOVO ITEM

			$('#modalInserirItem').on('show.bs.modal', function (event) {
				var button = $(event.relatedTarget) // Button that triggered the modal
				var new_dta_valor_total = button.data('new_valor_total')
				var new_dta_saida_id = button.data('new_saida_id')

				var modal = $(this)
				modal.find('.modal-body #new_saida_id').val(new_dta_saida_id);

				$('#modalInserirItem').delegate('#new_quantidade,#new_preco_venda,#new_desconto','keyup',function(){
					//total();
					var new_quantidade = $('#new_quantidade').val();
					var new_preco_venda = $('#new_preco_venda').val();
					var new_desconto = $('#new_desconto').val();
					var new_subtotal = ((new_quantidade*new_preco_venda)-(new_quantidade*new_preco_venda*new_desconto)/100);
					var new_valor = (new_quantidade*new_preco_venda);

					var new_valor_total = (new_dta_valor_total*1);

					new_valor_total = new_valor_total + new_subtotal;


					$('#new_subtotal').val(new_subtotal);
					$('#new_valor').val(new_valor);
					$('#new_valor_total').val(new_valor_total);
					$('#new_val_temp').html(new_valor_total.formatMoney(2,',','.')+ " Mtn");


				});


				$('#modalInserirItem').delegate('#new_produto_id','change',function(){
					$('#new_quantidade').focus();

					var id = $('#new_produto_id').val();
					var dataId={'id':id};
					$.ajax({
						type  : 'GET',
						url   : '{!!URL::route('findPrice')!!}',
						dataType: 'json',
						data  : dataId,
						success:function(data){
							$('#new_preco_venda').val(data.preco_venda);
						}
					});
				});

			});
			// FIM MODAL NOVO ITEM
			</script>

		@endsection
