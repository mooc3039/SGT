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
									<h2> <b> Numero de guia_entrega / Factura </b> </h2> <hr>
									<h1>{{$guia_entrega->id}}</h1>
								</div>
							</div>


						</div>
					</div>
					<div class="row">
						<div class="col-md-6"> MAPUTO</div>
						<div class="col-md-6 text-right"> Data: {{$guia_entrega->data}} </div>
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

									@foreach($guia_entrega->itensGuiantrega as $iten_guia_entrega)
									<tr>
										<td> {{$iten_guia_entrega->quantidade}} </td>
										<td> {{$iten_guia_entrega->produto->descricao}} </td>
										<td> {{$iten_guia_entrega->produto->preco_venda}} </td>
										<td> {{$iten_guia_entrega->valor}} </td>

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

								<tr>
									<td>Valor Total:</td>
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
						<div class="col-md-6">

					</div>
					<div class="col-md-6 text-right"><a href="{{route('guia_entrega.index')}}" class="btn btn-warning">Cancelar</a>

					</div>
					</div>
				</div>


			</div>



		</div>
	</div>
</div>
@endsection



