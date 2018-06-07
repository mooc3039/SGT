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
									Nome do Cliente: {{$venda->cliente->nome}}<br>
									Endereço: {{$venda->cliente->endereco}}<br>
									Nuit: {{$venda->cliente->nuit}}<br>
								</div>
							</div>
						</div>

						<div class="col-md-3">

							<div class="panel panel-default">
								<div class="panel-body text-center">
									<h2> <b> Numero da Venda </b> </h2> <hr>
									<h1>{{$venda->id}}</h1>
								</div>
							</div>


						</div>
					</div>
					<div class="row">
						<div class="col-md-6"> MAPUTO</div>
						<div class="col-md-6 text-right"> Data: {{date('d-m-Y', strtotime($venda->created_at))}}  </div>
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

									@foreach($venda->itensvenda as $iten_venda)
									<tr>
										<td> {{$iten_venda->quantidade}} </td>
										<td> {{$iten_venda->produto->descricao}} </td>
										<td> {{number_format($iten_venda->produto->preco_venda, 2, '.', ',')}} </td>
										<td> {{number_format($iten_venda->valor, 2, '.', ',')}} </td>

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
									Motivo justificativo da não aplicação de imposto
								</div>
								<div class="panel-body">
									{{$venda->motivo_justificativo_nao_iva}}
								</div>
							</div>

						</div>

						<div class="col-md-6 text-right">
							<table class="pull-right">
								<tr>
									<td>Sub-Total:</td>
									<td style="width: 10px"></td>
									<td>{{number_format($venda->valor_total, 2, '.', ',')}} Mtn</td>
								</tr>
								<tr>
									<td>IVA(17%):</td>
									<td></td>
									<td>{{number_format($venda->iva, 2, '.', ',')}} Mtn</td>
								</tr>
								<tr>
									<td>Valor Total:</td>
									<td></td>
									<td><b>{{number_format($venda->valor_iva, 2, '.', ',')}} Mtn</b></td>
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
									@include('layouts.empresa.dados_bancarios_empresa')
								</div>
							</div>

						</div>

						<div class="col-md-6">

							

						</div> 

					</div>
					<div class="row">
						<div class="col-md-6"><a href="{{route('venda.show', $venda->id)}}/relatorio" class="btn btn-primary">Imprimir Saída</a>

						</div>
						<div class="col-md-6 text-right"><a href="{{route('venda.index')}}" class="btn btn-warning">Cancelar</a>

						</div>
					</div>
				</div>


			</div>



		</div>
	</div>
	<!-- </div> -->
	@endsection



