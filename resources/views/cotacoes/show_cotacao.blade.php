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
									<h1>{{$cotacao->id}}</h1>
								</div>
							</div>


						</div>
					</div>
					<div class="row">
						<div class="col-md-6"> MAPUTO</div>
						<div class="col-md-3 text-right"> Data: {{date('d-m-Y', strtotime($cotacao->created_at))}} </div>
						<div class="col-md-3 text-right"> Data Vencimento: {{date('d-m-Y', strtotime($cotacao->data_vencimento))}} </div>
					</div>
				</div>


				<div class="panel-body">

					<div class="row">
						<div class="col-md-12">
							<table class="table table-striped table-advance table-hover">
								<tbody>

									<tr>
										<th> Quantidade</th>
										<th> Designação </th>
										<th> Preço Unitário (Mtn)</th>
										<th> Valor Total (Mtn)</th>
									</tr>

									@foreach($cotacao->itensCotacao as $iten_cotacao)
									<tr>
										<td> {{$iten_cotacao->quantidade}} </td>
										<td> {{$iten_cotacao->produto->descricao}} </td>
										<td> {{number_format($iten_cotacao->produto->preco_venda, 2, '.', ',')}} </td>
										<td> {{number_format($iten_cotacao->valor, 2, '.', ',')}} </td>

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
						<div class="col-md-6"><a href="{{route('cotacao.show', $cotacao->id)}}/relatorio" class="btn btn-primary">Imprimir Saída</a>

						</div>
						<div class="col-md-6 text-right"><a href="{{route('cotacao.index')}}" class="btn btn-warning">Cancelar</a>

						</div>
					</div>
				</div>


			</div>



		</div>
	</div>
	<!-- </div> -->
	@endsection
