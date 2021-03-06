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
									<h2> <b> Numero de Saida / Factura </b> </h2> <hr>
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
										{{$saida->subtotal}}
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
										{{$saida->desconto}}
									</td>
								</tr>

								<tr>
									<td>
										Valor Total:
									</td>
									<td>
										<b>{{$saida->valor_total}}</b>
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
				</div>


			</div>



		</div>
	</div>
</div>
@endsection



