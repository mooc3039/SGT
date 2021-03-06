@extends('layouts.master')
@section('content')
<div class="row">
  <div class="col-lg-12">
    <h3 class="page-header"><i class="fa fa-file-text-o"></i>Facturas <b style="color: red">Normais</b></h3>
    <ol class="breadcrumb">
      <li><i class="fa fa-home"></i><a href="#">Home / Relatórios Gérais</a></li>
      <li><i class="icon_document_alt"></i>Facturas</li>
    </ol>
  </div>
</div>

<div class="row">
  <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12" id="valores_venda" style="display: block">
    <div class="info-box brown-bg">
      <i class="fa fa-share-square-o"></i><br>
      @if(isset($mes))
      Mês : <b>{{$mes}}</b>
      @endif

      @if(isset($ano))
      Ano: <b>{{$ano}}</b>
      @endif
      <div class="count"><span class="valor_total_visual"></span></div>
      <div class="title">Pago: <span class="valor_pago_visual"></span></div>
    </div>
  </div>
</div>



<div class="row">
  <div class="col-lg-12">
    <section class="panel panel-default">
      <div class="panel-body">
        <div class="row" style="margin-bottom: 10px">
          <div class="col-md-3">
            <!-- <a href="{{route('rg_saidas')}}" class="btn btn-default pull-left" style="width: auto; height: 28px; margin-left: 3px; font-size: 15px; font-weight: normal; padding: 3px 10px;"> <i class="fa fa-list"></i> Listar Todos </a> -->
            <div class="btn-group btn-group-sm">
              <a href="{{route('rg_saidas')}}" class="btn btn-info">
                Facturas Normais
              </a>

              <a href="{{route('rg_saidas_de_concurso')}}" class="btn btn-info">
                Facturas de Concursos
              </a>
            </div>
          </div>
          <div class="col-md-2">
            {{Form::open(['route'=>'listar_saida_mes', 'method'=>'POST'])}}
            <div class="input-group">
              {{Form::select('mes_id', [''=>'Por Mês',] + $meses, null, ['class'=>'form-control', 'id'=>'mes_id'] )}}
              <span class="input-group-btn">
                {{Form::button('<i class="fa fa-search"></i>', ['type'=>'submit', 'class'=>'btn btn-primary'])}}
              </span>
            </div>
            {{Form::close()}}
          </div>
          <div class="col-md-2">
            {{Form::open(['route'=>'listar_saida_ano', 'method'=>'POST'])}}
            <div class="input-group">
              {{Form::select('ano_id', [''=>'Por Ano',] + $anos, null, ['class'=>'form-control', 'id'=>'ano_id'] )}}
              <span class="input-group-btn">
                {{Form::button('<i class="fa fa-search"></i>', ['type'=>'submit', 'class'=>'btn btn-primary'])}}
              </span>
              {{Form::close()}}
            </div>
          </div>
          <div class="col-md-2">
            <a href="{{route('rg_saidas')}}" class="btn btn-primary">
                <i class="fa fa-search"></i> Todas Facturas
              </a>
          </div>
          <div class="col-md-3">
            <input type="text" id="pesq" class="form-control" placeholder="Pesquisa...">
          </div>
        </div>

        <table class="table table-striped table-advance table-hover" id="tbl_report_vendas" data-order='[[ 0, "desc" ]]'>
         <thead>

          <tr>
            <th>Código da Factura </th>
            <th> Data de Emissão </th>
            <th> Cliente </th>
            <th> Valor Total (Mtn)</th>
            <th> Valor Total - IVA (Mtn)</th>
          </tr>
        </thead>

        <tbody>

          @foreach($saidas as $saida)
          <tr>

            <td> {{$saida->codigo}} </td>
            <td> {{date('d-m-Y', strtotime($saida->data))}} </td>
            <td> {{$saida->cliente->nome}} </td>
            <td> {{number_format($saida->valor_total, 2, '.', ',')}} </td>
            <td>
              @if($saida->aplicacao_motivo_iva == 1)
              {{""}}
              @else
              {{number_format($saida->valor_iva, 2, '.', ',')}}
              @endif
            </td>

          </tr>

          @endforeach
        </tbody>
      </table>

    </div>


  </section>
</div>
</div>

{{Form::hidden('mes', $mes , ['id'=>'mes'])}}
{{Form::hidden('ano', $ano , ['id'=>'ano'])}}
{{Form::hidden('valor_total', $valor_saida , ['id'=>'valor_total'])}}
{{Form::hidden('valor_pago', $valor_saida_pago, ['id'=>'valor_pago'])}}

@endsection

@section('script')
<script type="text/javascript">

  $(document).ready(function() {

    var mes = $('#mes').val();
    var ano = $('#ano').val();
    var titulo = "Facturas";

    if(mes === "" && ano === ""){
      titulo = "Facturas Totais - Papelaria Agenda & Serviços";
    }else{
      if(mes !== ""){
        titulo = "Facturas Mensais - Papelaria Agenda & Serviços";
      }
      if(ano !== ""){
        titulo = "Facturas Anuais - Papelaria Agenda & Serviços";
      }
      
    }

    var msg_top = "Valor das Facturas "+$('#valor_total').val()+" Mtn.  "+
    "Valor Pago "+$('#valor_pago').val()+" Mtn";
    var msg_bottom = "Papelaria Agenda & Serviços";

    var oTable = $('#tbl_report_vendas').DataTable( {
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


    var valor_total_vend = Number.parseFloat($('#valor_total').val());
    var valor_pago_vend = Number.parseFloat($('#valor_pago').val());
    $('.valor_total_visual').html(valor_total_vend.formatMoney()+ " Mtn");
    $('.valor_pago_visual').html(valor_pago_vend.formatMoney()+ " Mtn");
  } );

</script>
@endsection
