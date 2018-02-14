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
										<h1>{{$cotacao->id}}</h1>
									</div>
								</div>


							</div>
						</div>
						<div class="row">
							<div class="col-md-6"> MAPUTO</div>
							<div class="col-md-6 text-right"> Data: {{$cotacao->data}} </div>
						</div>
					</div>


					<div class="panel-body">

						<div class="row">
							<div class="col-md-12">
								<table class="table table-striped table-advance table-hover">
									<tbody>

										<tr>
											<th><i class="icon_profile"></i>Quantidade</th>
											<th><i class="icon_mobile"></i> Designação </th>
											<th><i class="icon_mail_alt"></i> Preço Unitário </th>
											<th><i class="icon_cogs"></i> Valor Total </th>
											<th><i class="fa fa-pencil"></i> Editar </th>
										</tr>

										@foreach($cotacao->itensCotacao as $iten_cotacao)
											<tr>
												<td> {{$iten_cotacao->quantidade}} </td>
												<td> {{$iten_cotacao->produto->descricao}} </td>
												<td> {{$iten_cotacao->produto->preco_venda}} </td>
												<td> {{$iten_cotacao->valor}} </td>
												<td> <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modalProdutoIten" data-produto_id={{ $iten_cotacao->produto->id }} data-descricao={{ $iten_cotacao->produto->descricao }} data-quantidade={{ $iten_cotacao->quantidade }} data-preco_venda={{ $iten_cotacao->produto->preco_venda }} data-valor={{ $iten_cotacao->valor }} ><i class="fa fa-pencil"></i></button> </td>

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
										<td>
											Sub-Total:
										</td>
										<td>
											{{$cotacao->subtotal}}
										</td>
									</tr>


									<tr>
										<td>
											IVA:
										</td>
										<td>
											17%
										</td>
									</tr>

									<tr>
										<td>
											Desconto:
										</td>
										<td>
											{{$cotacao->desconto}}
										</td>
									</tr>

									<tr>
										<td>
											Valor Total:
										</td>
										<td>
											<b>{{$cotacao->valor_total}}</b>
										</td>
									</tr>
								</table>

							</div>

						</div>
						<br><br>
						<div class="row">

							<div class="col-md-6">

								<div class="panel panel-info">
									<div class="panel-heading">
										Datos bancarios
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
							<div class="col-md-6 text-right"><a href="{{route('cotacao.index')}}" class="btn btn-warning">Cancelar</a>

							</div>
						</div>
					</div>


				</div>



			</div>
		</div>
	</div>

	<!-- MODAL CATEGORIA -->
	<div class="modal fade" tabindex="-1" role="dialog" id="modalProdutoIten">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Editar Item</h4>
				</div>
				<div class="modal-body">

					{{Form::open()}}

					<div class="row">
						<div class="col-md-3">
							<div class="form-group">
								{{Form::label('produto_id', 'Designação', ['class'=>'control-lable'])}}
								{{Form::text('produto_id', null, ['placeholder' => 'Nome', 'class' => 'form-control', 'id'=>'produto_id', 'readonly'])}}
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
								{{Form::text('preco_venda', null, ['placeholder' => 'Preço Unitário', 'class' => 'form-control', 'id'=>'preco_venda'])}}
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
								{{Form::label('valor', 'Valor', ['class'=>'control-lable'])}}
								{{Form::text('valor', null, ['placeholder' => 'Valor', 'class' => 'form-control', 'id'=>'valor'])}}
							</div>
						</div>
					</div>

				</div>
				<div class="modal-footer">

					{{Form::button('Fechar', ['class'=>'btn btn-default', 'data-dismiss'=>'modal'])}}
					{{Form::submit('Salvar', ['class'=>'btn btn-primary'])}}

					{{Form::close()}}
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	<!-- FIM MODAL CATEGORIA -->
@endsection

@section('script')
	<script>

	$('#modalProdutoIten').on('show.bs.modal', function (event) {
		var button = $(event.relatedTarget) // Button that triggered the modal
		var produto_id = button.data('produto_id')
		var descricao = button.data('descricao')
		var quantidade = button.data('quantidade')
		var preco_venda = button.data('preco_venda')
		var valor = button.data('valor')
		var modal = $(this)

		modal.find('.modal-body #produto_id').val(descricao);
		modal.find('.modal-body #quantidade').val(quantidade);
		modal.find('.modal-body #preco_venda').val(preco_venda);
		modal.find('.modal-body #valor').val(valor);
	})
	</script>

@endsection
