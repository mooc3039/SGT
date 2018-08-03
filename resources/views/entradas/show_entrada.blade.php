@extends('layouts.master')
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
									@include('layouts.empresa.dados_empresa')
								</div>
							</div>

						</div>

						<div class="col-md-4">

							<div class="panel panel-default">
								<div class="panel-body text-center">

									Usúario do Sistema:
									{{$entrada->user->name}}

								</div>
							</div>
						</div>

						<div class="col-md-3">

							<div class="panel panel-default">
								<div class="panel-body text-center">
									<h2> <b> Numero da Entrada / Factura </b> </h2> <hr>
									<h1>{{$entrada->codigo}}</h1>
								</div>
							</div>


						</div>
					</div>
					<div class="row">
						<div class="col-md-6"> MAPUTO</div>
						<div class="col-md-6 text-right"> Data: {{date('d-m-Y', strtotime($entrada->created_at))}} </div>
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
										<th> Preço Aquisição (Mtn)</th>

									</tr>

									@foreach($entrada->itensEntrada as $iten_entrada)
									<tr>
										<td> {{$iten_entrada->quantidade}} </td>
										<td> {{$iten_entrada->produto->descricao}} </td>
										<td> {{number_format($iten_entrada->produto->preco_aquisicao, 2, '.', ',')}} </td>


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
								<div class="panel-body">
									Motivo Justificativo da não aplicação de imposto:
								</div>
							</div> -->

						</div>

						<div class="col-md-6 text-right">
							<table class="pull-right">

								<tr>
									<td>Valor Total:</td>
									<td style="width: 10px"></td>
									<td><b>{{number_format($entrada->valor_total, 2, '.', ',')}} Mtn</b></td>
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
						<div class="col-md-6"><a href="{{route('entrada.show', $entrada->id)}}/relatorio" class="btn btn-primary">Imprimir Entrada</a>

					</div>
					<div class="col-md-6 text-right"><a href="{{route('entrada.index')}}" class="btn btn-warning">Cancelar</a>

					</div>
					</div>
				</div>


			</div>



		</div>
	</div>
</div>
@endsection
