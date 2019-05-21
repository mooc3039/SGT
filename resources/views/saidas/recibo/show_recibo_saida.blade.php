@extends('layouts.master')
@section('content')
<style type="text/css">

#recibo{
	font-size: 14px;
}
.tabela-espacada-vertical {
	border-collapse: separate;
	border-spacing: 0 8px;
	margin-top: -8px;
}
.tabela-espacada-vertical td{
	padding-left: 20px;
	padding-right: 20px;
	padding-top: 5px;
}
.centro{
	text-align: center;
}


input[type=checkbox]{
	display: inline;
}

.recibo-logo{
	width: 129;
	height: 70;
}

</style>

<div align="center" style="background-color: white; padding: 20px";>

	<section id="recibo">
		<div style="border: 1px solid black;">
			<table class="tabela-espacada-vertical">
				<tr>
					<td>
						<img src="{{asset('img/Logo-PSA.jpg')}}" class="recibo-logo" />
						<address>
							@foreach($empresa->enderecos as $endereco)
							{{$endereco->endereco}} / 
							@endforeach<br>
							@foreach($empresa->telefones as $telefone)
							{{$telefone->telefone}} / 
							@endforeach <br>
							@foreach($empresa->emails as $email)
							{{$email->email}} / 
							@endforeach <br>
						</address>
					</td>
					<td>
						Para
						<address>
							<strong>{{$saida->cliente->nome}}</strong><br>
							Endereco : {{$saida->cliente->endereco}}<br>
							NUIT : {{$saida->cliente->nuit}}<br>
							Email : {{$saida->cliente->email}}<br>
						</address>
					</td>
					<td>
						<b>Recibo N<sup>o</sup></b> <b style="color: red">  #007612</b><br>
						<b>Factura N<sup>o</sup> </b> {{$saida->codigo}}<br><br>
						<b>
							{{$pagamentos_saida->valor_pago}}
							MT
						</b>
					</td>
				</tr>
				<tr>
					<td colspan="3">
						<hr>
					</td>
				</tr>
			</table>

			<table class="tabela-espacada-vertical">
				<tr>
					<td>
						<div>
							<input type="checkbox" name="tipo_pagamento" disabled
							@if(stripos($pagamentos_saida->formaPagamento->descricao, 'dinheiro') !== FALSE)
							{{'checked'}}
							@endif
							/>
							Numerario
						</div>
					</td>
					<td>
						<div>
							<input type="checkbox" name="tipo_pagamento" disabled
							@if(stripos($pagamentos_saida->formaPagamento->descricao, 'dinheiro') !== FALSE)

							@elseif(stripos($pagamentos_saida->formaPagamento->descricao, 'cheque') !== FALSE)

							@else
							{{'checked'}}
							@endif
							/> 
							Outros
						</div>
					</td>
					<td align="center">
						Maputo, {{date('d-m-Y', strtotime($saida->data))}}
					</td>
				</tr>
				<tr>
					<td>
						<div> 
							<input type="checkbox" name="tipo_pagamento"
							@if(stripos($pagamentos_saida->formaPagamento->descricao, 'cheque') !== FALSE)
							{{'checked'}}
							@endif	
							disabled />
							CHEQUE N:
							@if(isset($pagamentos_saida->nr_documento_forma_pagamento))
							<u>{{$pagamentos_saida->nr_documento_forma_pagamento}}</u>
							@endif
						</div>
					</td>
					<td>Banco: 
						@if(isset($pagamentos_saida->banco->nome))
						<u>{{$pagamentos_saida->banco->nome}}</u>
						@endif

					</td>
					<td align="center">
						Assinatura e Carimbo
					</td>
				</tr>
				<tr>
					<td colspan="2" >

						@foreach($empresa->contas as $conta)
						<b>CONTA {{$conta->banco}}</b> (MZN) : {{$conta->numero}}   
						@endforeach 

					</td>
					<td align="center">_______________________________________</td>
				</tr>
			</table>
		</div>
		<br>
		<div style="border: 1px solid black;" align="left">
			<table class="tabela-espacada-vertical">
				<tr>
					<td>
						<b>Factura N<sup>o</sup>  {{$saida->codigo}}</b>
					</td>
				</tr>
			</table>

		</div>

		<!-- ./section invoice -->
	</section>
</div>
<br>
<div class="footer">
	<div class="row">
		<div class="col-md-12">
			<a href="{{route('imprimir_recibo_pagamento', [$pagamentos_saida->saida_id, $pagamentos_saida->id])}}" class="btn btn-info btn-sm">
				<i class="fa fa-print"></i>
				Imprimir
			</a>
		</div>
	</div>
</div>
@endsection
