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
									Nome do Cliente: {{$concurso->cliente->nome}}<br>
									Endereço: {{$concurso->cliente->endereco}}<br>
									Nuit: {{$concurso->cliente->nuit}}<br>
								</div>
							</div>
						</div>

						<div class="col-md-3">

							<div class="panel panel-default">
								<div class="panel-body text-center">
									<h2> <b> Numero do Concurso </b> </h2> <hr>
									<h1>{{$concurso->codigo_concurso}}</h1>
								</div>
							</div>


						</div>
					</div>
					<div class="row">
						<div class="col-md-6"> MAPUTO</div>
						<div class="col-md-6 text-right"> Data: {{date('d-m-Y', strtotime($concurso->created_at))}}  </div>
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
										<th> Preço Unitário </th>
										<th> Valor Total </th>
									</tr>

									@foreach($concurso->itensConcurso as $iten_concurso)
									<tr>
										<td> {{$iten_concurso->quantidade}} </td>
										<td> {{$iten_concurso->produto->descricao}} </td>
										<td> {{number_format($iten_concurso->preco_venda, 2, '.', ',')}} </td>
										<td> {{number_format($iten_concurso->valor, 2, '.', ',')}} </td>

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
									<td>{{number_format($concurso->valor_total, 2, '.', ',')}}</td>
								</tr>
								<tr>
									<td>IVA(17%):</td>
									<td></td>
									<td>{{number_format($concurso->iva, 2, '.', ',')}}</td>
								</tr>
								<tr>
									<td>Valor Total:</td>
									<td></td>
									<td><b>{{number_format($concurso->valor_iva, 2, '.', ',')}}</b></td>
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
						<div class="col-md-6"><a href="{{route('concurso.show', $concurso->id)}}/relatorio" class="btn btn-primary">Imprimir Concurso</a>

						</div>
						<div class="col-md-6 text-right"><a href="{{route('concurso.index')}}" class="btn btn-warning">Cancelar</a>

						</div>
					</div>
				</div>


			</div>



		</div>
	</div>
	<!-- </div> -->
	@endsection



