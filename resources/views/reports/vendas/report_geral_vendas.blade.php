@extends('layouts.master')
@section('content')
<div class="row">
	<div class="col-lg-12">
		<h3 class="page-header"><i class="fa fa-file-text-o"></i>vendas</h3>
		<ol class="breadcrumb">
			<li><i class="fa fa-home"></i><a href="#">Home / Relatórios Gérais</a></li>
			<li><i class="icon_document_alt"></i>Vendas</li>
		</ol>
	</div>
</div>

<div class="row">
	<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12" id="valores_venda" style="display: block">
		<div class="info-box green-bg">
			<i class="fa fa-shopping-cart"></i><br>
			@if(isset($mes))
			Mês : <b>{{$mes}}</b>
			@endif

			@if(isset($ano))
			Ano: <b>{{$ano}}</b>
			@endif
			<div class="count"><span class="valor_total"></span></div>
			<div class="title">Pago: <span class="valor_pago"></span></div>
		</div>
	</div>
</div>



<div class="row">
	<div class="col-lg-12">
		<section class="panel panel-default">

			<div class="panel-body">
				<div class="row" style="margin-bottom: 10px">
					<div class="col-md-3">
						<a href="{{route('rg_vendas')}}" class="btn btn-default pull-left" style="width: auto; height: 28px; margin-left: 3px; font-size: 15px; font-weight: normal; padding: 3px 10px;"> <i class="fa fa-list"></i> Listar Todos </a>
					</div>
					<div class="col-md-3">
						{{Form::open(['route'=>'listar_vend_mes', 'method'=>'POST'])}}
						<div class="input-group">
							{{Form::select('mes_id', [''=>'Por Mês',] + $meses, null, ['class'=>'form-control', 'id'=>'mes_id'] )}}
							<span class="input-group-btn">
								{{Form::button('<i class="fa fa-search"></i>', ['type'=>'submit', 'class'=>'btn btn-primary'])}}
							</span>
						</div>
						{{Form::close()}}
					</div>
					<div class="col-md-3">
						{{Form::open(['route'=>'listar_vend_ano', 'method'=>'POST'])}}
						<div class="input-group">
							{{Form::select('ano_id', [''=>'Por Ano',] + $anos, null, ['class'=>'form-control', 'id'=>'ano_id'] )}}
							<span class="input-group-btn">
								{{Form::button('<i class="fa fa-search"></i>', ['type'=>'submit', 'class'=>'btn btn-primary'])}}
							</span>
							{{Form::close()}}
						</div>
					</div>
					<div class="col-md-3">
						<input type="text" id="pesq" class="form-control" placeholder="Pesquisa...">
					</div>
				</div>

				<table class="table table-striped table-advance table-hover" id="report_vendas" data-order='[[ 0, "desc" ]]'>
					<thead>

						<tr>
							<th><i class="icon_profile"></i>Código da venda </th>
							<th><i class="icon_mobile"></i> Data de venda </th>
							<th><i class="icon_mail_alt"></i> Valor </th>
							<th><i class="icon_mail_alt"></i> Cliente </th>
							<th><i class="icon_mail_alt"></i> Usúario Cadastrante </th>
						</tr>
					</thead>
					<tbody id="data">
						@foreach($vendas as $venda)
						<tr>

							<td> {{$venda->id}} </td>
							<td> {{date('d-m-Y', strtotime($venda->created_at))}} </td>
							<td> {{$venda->valor_iva}} </td>
							<td> {{$venda->cliente->nome}} </td>
							<td> {{$venda->user->name}} </td>

						</tr>

						@endforeach
					</tbody>
					<tbody id="data-ajax">

					</tbody>
					<tfoot id="data-footer-ajax">
						<tr>
							<td></td>
							<td></td>
							<td></td>
							<td>Valor Total</td>
							<td><span class="valor_total">{{ $valor_venda }}</span></td>
						</tr>
						<tr>
							<td style="border:none"></td>
							<td style="border:none"></td>
							<td style="border:none"></td>
							<td>Valor Pago</td>
							<td><span class="valor_pago">{{ $valor_venda_pago }}</span></td>
						</tr>
					</tfoot>
				</table>

			</div>


		</section>
	</div>
</div>
{{Form::hidden('mes', $mes , ['id'=>'mes'])}}
{{Form::hidden('ano', $ano , ['id'=>'ano'])}}
{{Form::hidden('valor_total', $valor_venda , ['id'=>'valor_total'])}}
{{Form::hidden('valor_pago', $valor_venda_pago, ['id'=>'valor_pago'])}}

@endsection

@section('script')
<script type="text/javascript">

	$(document).ready(function() {
		
		var mes = $('#mes').val();
		var ano = $('#ano').val();
		var titulo = "Vendas";

		if(mes === "" && ano === ""){
			titulo = "Vendas Totais - Papelaria Agenda & Serviços";
		}else{
			if(mes !== ""){
				titulo = "Vendas Mensais - Papelaria Agenda & Serviços";
			}
			if(ano !== ""){
				titulo = "Vendas Anuais - Papelaria Agenda & Serviços";
			}
			
		}

		var msg_top = "Valor das Vendas "+$('#valor_total').val()+" Mtn.  "+
		"Valor Pago "+$('#valor_pago').val()+" Mtn";
		var msg_bottom = "Papelaria Agenda & Serviços";

		var oTable = $('#report_vendas').DataTable( {
			"processing": true,
			"pagingType": "full_numbers",
			"dom": 'Brtpl',
			buttons: [
            // 'print',
            // 'excelHtml5',
            // 'pdfHtml5'
            {
            	text: 'Imprimir',
            	extend: 'print',
            	title: titulo,
            	messageTop: msg_top,
            	messageBottom: msg_bottom,
            	className: 'btn btn-defaul btn-sm'
            },
            {
            	text: 'Excel',
            	extend: 'excelHtml5',
            	title: titulo,
            	messageTop: msg_top,
            	messageBottom: msg_bottom,
            	className: 'btn btn-defaul btn-sm'
            },
            {
            	text: 'PDF',
            	extend: 'pdfHtml5',
            	title: titulo,
            	messageTop: msg_top,
            	messageBottom: msg_bottom,
            	className: 'btn btn-defaul btn-sm'
            }
            ]
        });

		$('#pesq').keyup(function(){
			oTable.search($(this).val()).draw();
		});


		var valor_total_vend = $('#valor_total').val()*1;
		var valor_pago_vend = $('#valor_pago').val()*1;
		$('.valor_total').html(valor_total_vend.formatMoney(2,',','.')+ " Mtn");
		$('.valor_pago').html(valor_pago_vend.formatMoney(2,',','.')+ " Mtn");
	} );

</script>
@endsection