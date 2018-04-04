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
<div style="border: 2px solid black; border-radius: 10px; height: 100px;"><br />
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
<td style="width: 129px; text-align: center;" class="linha">{{$iten_concurso->preco_venda}}</td>
<td style="width: 161px; text-align: center;" class="linha">{{$iten_concurso->valor}} </td>
</tr>
@endforeach
</tbody>
</table>
<table class="total wena" style="height: 84px; width: 750px;">
<tbody>
<tr style="height: 18px;">
<td  style="width: 159px; height: 18px;">&nbsp;</td>
<td  style="width: 270px; height: 18px;">&nbsp;</td>
<td class="linha" style="width: 120px; height: 18px;text-align: right;">
<strong>&nbsp;SUB-TOTAL</strong></td>
<td class="linha" style="width: 155px; text-align: center;">{{$concurso->valor_total}}Mtn</td>
</tr>
<tr style="height: 17px;">
<td  style="width: 159px; height: 17px;">&nbsp;</td>
<td  style="width: ; height: 17px;">&nbsp;</td>
<td class="linha" style="width:; height: 17px;text-align: right;"><strong>&nbsp;IVA 17%</strong></td>
<td class="linha" style="width: 155px; text-align: center;">{{(($concurso->valor_total)*17)/100}}</td>
</tr>
<tr style="height: 18px;">
<td style="width: 159px; height: 18px;">&nbsp;</td>
<td  style="width: ; height: 18px;">&nbsp;</td>
<td class="linha" style="width: ; height: 18px;text-align: right;"><strong>&nbsp;TOTAL</strong></td>
<td class="linha" style="width: 155px; text-align: center;">{{$concurso->valor_iva}}Mtn</td>
</tr>
<tr style="height: 18px;">
<td  style="width: 159px; height: 18px;">&nbsp;</td>
<td  style="width: ; height: 18px;">&nbsp;</td>
<td class="" style="width: ; height: 18px;text-align: right;"><strong>&nbsp;</strong></td>
<td class="" style="width: 155px; text-align: center;"></td>
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

</body>
</html>
