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

									Usúario do Sistema:
									{{$entrada->user->name}}

								</div>
							</div>
						</div>

						<div class="col-md-3">

							<div class="panel panel-default">
								<div class="panel-body text-center">
									<h2> <b> Numero da Entrada / Factura </b> </h2> <hr>
									<h1>{{$entrada->id}}</h1>
								</div>
							</div>


						</div>
					</div>
					<div class="row">
						<div class="col-md-6"> MAPUTO</div>
						<div class="col-md-6 text-right"> Data: {{$entrada->data}} </div>
					</div>
				</div>


				<div class="panel-body">

					<div class="row">
						<div class="col-md-12">
							<table class="table table-striped table-advance table-hover">
								<tbody>

									<tr>
										<th><i class="icon_profile"></i>Quantidade</th>
										<th><i class="icon_mobile"></i> Valor </th>
										<th><i class="icon_mobile"></i> Preço Aquisição </th>
										
									</tr>

									@foreach($entrada->itensEntrada as $iten_entrada)
									<tr>
										<td> {{$iten_entrada->quantidade}} </td>
										<td> {{$iten_entrada->produto->descricao}} </td>
										<td> {{$iten_entrada->produto->preco_aquisicao}} </td>
										

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
										IVA:
									</td>
									<td>
										17%
									</td>
								</tr>

								<tr>
									<td>
										Valor Total:
									</td>
									<td>
										<b>{{$entrada->valor}}</b>
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
					<div class="row">
						<div class="col-md-6"><a href="" class="btn btn-primary">Imprimir Saída</a>

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



