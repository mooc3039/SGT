@extends('layouts.empty_base')

<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="row" style="background-color: white">
						<div class="col-md-5 border">
							P&SA<br>
							Papelaria e Serviços Agenda

						</div>

						<div class="col-md-4">
							Nome do Cliente: {{$saida->cliente->nome}}<br>
							Endereço: {{$saida->cliente->endereco}}<br>
							Nuit: {{$saida->cliente->nuit}}<br>
						</div>

						<div class="col-md-3">

							Numero da Saida: {{$saida->id}}<br>

						</div>
					</div>

					<div class="row" style="background-color: red">
						<div class="col-md-5"> MAPUTO</div>
						<div class="col-md-4"> Data: {{$saida->data}} </div>
						<div class="col-md-3"></div>
					</div>
				</div>




				<div class="row">
					<div class="col-md-12">
						<table class="table table-striped table-advance table-hover">
							<tbody>

								<tr>
									<th><i class="icon_profile"></i>Quantidade</th>
									<th><i class="icon_mobile"></i> Designação </th>
									<th><i class="icon_mail_alt"></i> Preço Unitário </th>
									<th><i class="icon_cogs"></i> Valor Total </th>
								</tr>

								@foreach($saida->itensSaida as $iten_saida)
								<tr>
									<td> {{$iten_saida->quantidade}} </td>
									<td> {{$iten_saida->produto->descricao}} </td>
									<td> {{$iten_saida->produto->preco_venda}} </td>
									<td> {{$iten_saida->valor}} </td>

								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>

				<div class="row">

					<div class="col-md-6">

						Motivo Justificativo da não aplicação de imposto.

					</div>

					<div class="col-md-6 text-right">

						Sub-Total: {{$saida->subtotal}}<br>
						Desconto: {{$saida->desconto}}<br>
						Valor Total: {{$saida->valor_total}}<br>

					</div>

				</div>

				<div class="row">

					<div class="col-md-12">

						Conta BCI (MZN) 54169166 10 1<br>
						Conta BIM (MZN) 5299/07<br>

					</div>

				</div>
			</div>
		</div>
	</div>
</div>




