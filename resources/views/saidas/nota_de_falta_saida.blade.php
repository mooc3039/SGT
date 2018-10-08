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
									<h2> <b> Nota de Falta</b> </h2>
									<hr>
									<h2> <b> Número Factura </b> </h2>
									<h2>{{$saida->codigo}}</h2>
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
										<th class="text-right"> Preço Unitário (Mtn)</th>
										<th class="text-right"> Valor (Mtn)</th>
										<th class="text-right"> Desconto (%)</th>
										<th class="text-right"> Subtotal (Mtn)</th>
										
									</tr>

									@php
										$valor_total_itens = 0;

									@endphp

									@foreach($nota_falta->itensNotaFalta as $iten_nota_falta)
									<tr>
										<td> {{$iten_nota_falta->quantidade}} </td>
										<td> {{$iten_nota_falta->produto->descricao}} </td>
										<td class="text-right"> {{number_format($iten_nota_falta->produto->preco_venda, 2, '.', ',')}} </td>
										<td class="text-right"> {{number_format($iten_nota_falta->valor, 2, '.', ',')}} </td>
										<td class="text-right"> {{$iten_nota_falta->desconto}} </td>
										<td class="text-right"> {{number_format($iten_nota_falta->subtotal, 2, '.', ',')}} </td>

									</tr>
									@php
									$valor_total_itens = $valor_total_itens + $iten_nota_falta->subtotal_rest;
									@endphp
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
									@if($nota_falta->motivo_iva_id == null)
									{{""}}
									@else
									{{$nota_falta->motivoIva->motivo_nao_aplicacao}}
									@endif
								</div>
							</div>

						</div>

						<div class="col-md-6 text-right">
							<table class="pull-right">
								@if($nota_falta->aplicacao_motivo_iva == 1)
								
								<tr>
									<td>Valor Total da Nota de Falta:</td>
									<td style="width: 10px"></td>
									<td>{{number_format($nota_falta->valor_total, 2, '.', ',')}} Mtn</td>
								</tr>
								<tr>
									<td style="border-top: 1px solid #ccc"><b>Valor Total da Factura:</b></td>
									<td style="border-top: 1px solid #ccc; width: 10px"></td>
									<td style="border-top: 1px solid #ccc"><b>{{number_format($saida->valor_total, 2, '.', ',')}} Mtn</b></td>
								</tr>
								@else
								<tr>
									<td>Sub-Total da Nota de Falta:</td>
									<td style="width: 10px"></td>
									<td>{{number_format($nota_falta->valor_total, 2, '.', ',')}} Mtn</td>
								</tr>
								<tr>
									<td>IVA(17%) da Nota de Falta:</td>
									<td></td>
									<td>{{number_format($nota_falta->iva, 2, '.', ',')}} Mtn</td>
								</tr>
								<tr>
									<td>Valor Total da Nota de Falta:</td>
									<td style="width: 10px"></td>
									<td>{{number_format($nota_falta->valor_iva, 2, '.', ',')}} Mtn</td>
								</tr>
								<tr>
									<td style="border-top: 1px solid #ccc"><b>Valor Total da Factura:</b></td>
									<td style="border-top: 1px solid #ccc"></td>
									<td style="border-top: 1px solid #ccc"><b>{{number_format($saida->valor_iva, 2, '.', ',')}} Mtn</b></td>
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
							<a href="" class="btn btn-primary">Imprimir Nota de Falta</a>
							<a href="{{route('saida.show', $saida->id)}}" class="btn btn-info">Factura</a>

						</div>
						<div class="col-md-6 text-right"><a href="{{route('saida.index')}}" class="btn btn-warning">Listar Facturas</a>

						</div>
					</div>
				</div>


			</div>



		</div>
	</div>
	<!-- </div> -->
	@endsection
