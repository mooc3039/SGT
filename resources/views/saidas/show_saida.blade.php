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
									Nome do Cliente: {{$saida->cliente->nome}}<br>
									Endereço: {{$saida->cliente->endereco}}<br>
									Nuit: {{$saida->cliente->nuit}}<br>
								</div>
							</div>
						</div>

						<div class="col-md-3">

							<div class="panel panel-default">
								<div class="panel-body text-center">
									<h2> <b> Numero Factura </b> </h2> <hr>
									<h1>{{$saida->codigo}}</h1>
								</div>
							</div>


						</div>
					</div>
					<div class="row">
						<div class="col-md-6"> MAPUTO</div>
						<div class="col-md-6 text-right"> Data: {{date('d-m-Y', strtotime($saida->data))}}  </div>
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

									@foreach($saida->itensSaida as $iten_saida)
									<tr>
										<td> {{$iten_saida->quantidade}} </td>
										<td> {{$iten_saida->produto->descricao}} </td>
										<td> {{number_format($iten_saida->produto->preco_venda, 2, '.', ',')}} </td>
										<td> {{number_format($iten_saida->valor, 2, '.', ',')}} </td>

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
								</div>
								<div class="panel-body">
									@if($saida->motivo_iva_id == null)
									{{""}}
									@else
									{{$saida->motivoIva->motivo_nao_aplicacao}}
									@endif
								</div>
							</div>

						</div>

						<div class="col-md-6 text-right">
							<table class="pull-right">
								@if($saida->aplicacao_motivo_iva == 1)
								<tr>
									<td>Valor Total:</td>
									<td style="width: 10px"></td>
									<td>{{number_format($saida->valor_total, 2, '.', ',')}} Mtn</td>
								</tr>
								@else
								<tr>
									<td>Sub-Total:</td>
									<td style="width: 10px"></td>
									<td>{{number_format($saida->valor_total, 2, '.', ',')}} Mtn</td>
								</tr>
								<tr>
									<td>IVA(17%):</td>
									<td></td>
									<td>{{number_format($saida->iva, 2, '.', ',')}} Mtn</td>
								</tr>
								<tr>
									<td>Valor Total:</td>
									<td></td>
									<td><b>{{number_format($saida->valor_iva, 2, '.', ',')}} Mtn</b></td>
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
									Datos bancarios
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
							<a href="{{route('saida.show', $saida->id)}}/relatorio" class="btn btn-primary">Imprimir Saída</a>
							<a href="{{route('nota_de_falta', $saida->id)}}" class="btn btn-info">Nota de Falta</a>

						</div>
						<div class="col-md-6 text-right"><a href="{{route('saida.index')}}" class="btn btn-warning">Cancelar</a>

						</div>
					</div>
				</div>


			</div>



		</div>
	</div>
	<!-- </div> -->
	@endsection
