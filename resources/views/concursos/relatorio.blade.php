<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Relatório</title>
	<style type="text/css">
			.wena {
				border-collapse: collapse;
				text-align: center;
			}

			.linha {
				border: 2px solid black;

			}
			.right {
		    float: right;
		    width: 25%;

		}

		.clearfix {
				padding: 23px;

			}
        .total {
        		float: right;
        }
				.footer {
					position: absolute;
					right: 0;
					bottom: 0;
					left: 0;
					padding: 1rem;
					background-color: #efefef;
					text-align: right;
				}
	</style>

</head>
<body style="background-image:url('/img/baki.jpeg')">
<div style="width: 750px;">
<table style="height: 162px; width: 750px;">
<tbody>
<tr>
<td style="width: 619px;">
<table style="height: 153px; width: 750px;">
<tbody>
<tr style="height: 188px;">
<td style="width: 271px; text-align: center; height: 188px;">&nbsp;
<div style="border: 2px solid black; border-radius: 10px; text-align: center; height: 160px;">
&nbsp;<em><strong><span style="text-decoration: underline; font-size: 16px;">
<br>&nbsp;{{$empresa->nome}}</span></strong></em> <br />
<small><strong>{{$empresa->actuacao}}</strong></small> <br />
@foreach($empresa->enderecos as $endereco)
<small>{{$endereco->endereco}}</small> <br />
@endforeach
@foreach($empresa->telefones as $telefone)
<small>Telefone: {{$telefone->telefone}}</small><br />
@endforeach
@foreach($empresa->emails as $email)
<small> {{$email->email}}</small><br />
@endforeach
 <small> <strong>NUIT {{$empresa->nuit}}</strong></small></div>
&nbsp;</td>
<td style="width: 197px; text-align: center; height: 188px;">&nbsp;
<div style="border: 2px solid black; border-radius: 10px; height: 160px;">
<strong><em><span style="text-decoration: underline; font-size: 16px;"><br>
Dados do Cliente</span></em></strong><br />
<strong>Exmo (s)</strong>: {{$concurso->cliente->nome}}<br />
<strong>Morada</strong>: {{$concurso->cliente->endereco}}<br />
<strong>NUIT</strong>: {{$concurso->cliente->nuit}}</div>
&nbsp;</td>
<td style="width: 153px; height: 188px;">
<div class="" style="border: 2px solid black; border-radius: 10px; height: 45px;">
<h3 style="text-align: center;"><strong>CONCURSO</strong></h3>
</div>
<br />
<div style="border: 2px solid black; border-radius: 10px; height: 95px;"><br />
<h2 style="color: red; text-align: center;">N&ordm; {{$concurso->codigo_concurso}}</h2>
</div>
</td>
</tr>
<tr style="height: 46px;">
<td style="width: 271px; height: 46px;">
<div style="border: 2px solid black; border-radius: 3px;">
<p style="text-align: center;"><strong>MAPUTO </strong></p>
</div>
</td>
<td style="width: 197px; height: 46px; text-align: center;">
<div style="border: 2px solid black; border-radius: 3px;">
<p><strong>Data:</strong> {{date('d-m-Y', strtotime($concurso->created_at))}}</p>
</div>
</td>
<td style="width: 153px; height: 46px;">&nbsp;</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<table style="height: 51px; width: 750px;" class="wena linha">
<tbody>
<tr>
<td style="text-align: center;" class="linha"><strong>QUANTIDADE</strong></td>
<td style="width: 300px; text-align: center;" class="linha"><strong>DESIGNA&Ccedil;&Atilde;O</strong></td>
<td style="width: 129px; text-align: center;" class="linhawidth: 129px;">
<strong>PRE&Ccedil;O UNIT&Aacute;RIO</strong></td>
<td style="width: 161px; text-align: center;" class="linha"><strong>VALOR TOTAL</strong></td>
</tr>
@foreach($concurso->itensConcurso as $iten_concurso)
<tr>
<td style="text-align: center;" class="linha">{{$iten_concurso->quantidade}}</td>
<td style="width: 300px; text-align: center;" class="linha">{{$iten_concurso->produto->descricao}}</td>
<td style="width: 129px; text-align: center;" class="linha">{{number_format($iten_concurso->preco_venda,2)}}</td>
<td style="width: 161px; text-align: center;" class="linha">{{number_format($iten_concurso->valor,2)}} </td>
</tr>
@endforeach
</tbody>
</table>
<table class="total wena" style="height: 84px; width: 748px;">
<tbody>
<tr style="height: 18px;">
<td class="linha" style="width: 409px; height: 18px; text-align: center;">Motivo justicado da n&atilde;o aplica&ccedil;&atilde;o do imposto</td>
<td class="linha" style="width: 118px; height: 18px;text-align: right;">
<strong>&nbsp;SUB-TOTAL</strong></td>
<td class="linha" style="width: 148px; text-align: center;">{{number_format($concurso->valor_total,2)}}Mtn</td>
</tr>
<tr style="height: 17px;">

<td class="linha" style="width: ; height: 18px;">{{$concurso->motivo_justificativo_nao_iva}}</td>
<td class="linha" style="width:; height: 18px;text-align: right;"><strong>&nbsp;IVA 17%</strong></td>
<td class="linha" style="width: 148px; text-align: center;">{{number_format((($concurso->valor_total)*17)/100, 2)}}</td>
</tr>
<tr style="height: 18px;">

<td class="linha" style="width: ; height: 18px;">&nbsp;</td>
<td class="linha" style="width: ; height: 18px;text-align: right;"><strong>&nbsp;TOTAL</strong></td>
<td class="linha" style="width: 148px; text-align: center;">{{number_format($concurso->valor_iva,2)}}Mtn</td>
</tr>
<tr style="height: 18px;">

<td  style="width: ; height: 18px;">&nbsp;</td>
<td class="" style="width: ; height: 18px;text-align: right;"><strong>&nbsp;</strong></td>
<td class="" style="width: 148px; text-align: center;"></td>
</tr>

</tbody>
</table>


</div>
<br>
<footer style="margin-bottom: 30px;">
<table style=" width: 750px;">

	<tr>
	<td style="width: 450px;text-align: center;">&nbsp;</td>
	<td style="width: 280px; text-align: left;">
	<div >
    @foreach($empresa->contas as $conta)
    <strong>{{$conta->banco}}</strong>(MZN) {{$conta->numero}}&nbsp;<br />
     @endforeach
     </div>
	</td>
	</tr>

</table>
</footer>
<div class="footer"> <small>Processado por computador</small>.</div>
</body>
</html>
