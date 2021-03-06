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
									Nome do Cliente: {{$guia_entrega->cliente->nome}}<br>
									Endereço: {{$guia_entrega->cliente->endereco}}<br>
									Nuit: {{$guia_entrega->cliente->nuit}}<br>
								</div>
							</div>
						</div>

						<div class="col-md-3">

							<div class="panel panel-default">
								<div class="panel-body text-center">
									<h2> <b> Numero de guia_entrega</b> </h2>
									<h4>Da Factura nr: {{$guia_entrega->saida->codigo}}</h4>
									 <hr>
									<h1>{{$guia_entrega->codigo}}</h1>
								</div>
							</div>


						</div>
					</div>
					<div class="row">
						<div class="col-md-6"> MAPUTO</div>
						<div class="col-md-6 text-right"> Data: {{date('d-m-Y', strtotime($guia_entrega->created_at))}} </div>
					</div>
				</div>


				<div class="panel-body">

					<div class="row">
						<div class="col-md-12">
							<table class="table table-striped table-advance table-hover">
								<tbody>

									<tr>
										<th>Quantidade</th>
										<th> Designação </th>
										<th> Preço Unitário (Mtn)</th>
										<th> Valor Total (Mtn)</th>
									</tr>

									@foreach($guia_entrega->itensGuiantrega as $iten_guia_entrega)
									<tr>
										<td> {{$iten_guia_entrega->quantidade}} </td>
										<td> {{$iten_guia_entrega->produto->descricao}} </td>
										<td> {{number_format($iten_guia_entrega->produto->preco_venda, 2, '.', ',')}} </td>
										<td> {{number_format($iten_guia_entrega->valor, 2, '.', ',')}} </td>

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


							<!-- <div class="panel panel-default">
								<div class="panel-heading">
									Motivo justificativo da não aplicação de imposto
								</div>
								<div class="panel-body">
								</div>
							</div> -->

						</div>

						<div class="col-md-6 text-right">
							<table class="pull-right">
								<tr>
									<td>Valor Total:</td>
									<td style="width: 10px"></td>
									<td><b>{{number_format($guia_entrega->valor_total, 2, '.', ',')}} Mtn</b></td>
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
						<div class="col-md-6"><a href="{{route('guia_entrega.show', $guia_entrega->id)}}/relatorio" class="btn btn-primary">Imprimir</a></div>
						<div class="col-md-6 text-right"><a href="{{route('guia_entrega.index')}}" class="btn btn-warning">Cancelar</a>

						</div>
					</div>
				</div>


			</div>



		</div>
	</div>
	<!-- </div> -->
	@endsection
