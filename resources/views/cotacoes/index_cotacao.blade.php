@extends('layouts.master')
@section('content')
<style type="text/css">
.red{
  color: red;
}
</style>
<div class="row">
  <div class="col-lg-12">
    <h3 class="page-header"><i class="fa fa-file-text-o"></i>Cotações</h3>
    <ol class="breadcrumb">
      <li><i class="fa fa-home"></i><a href="#">Home</a></li>
      <li><i class="icon_document_alt"></i>Cotações</li>
    </ol>
  </div>
</div>

<div class="row">
  <div class="col-lg-12">

    <section class="panel panel-default">

      <div class="panel-body">
        <div class="row" style="margin-bottom: 10px">
          <div class="col-md-8">
            <a href="{{ route('cotacao.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
          </div>
          <div class="col-md-4">
            <input type="text" id="pesq" class="form-control" placeholder="Pesquisa...">
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            <table class="table table-striped table-advance table-hover" id="tbl_index_cotacoes" data-order='[[ 0, "desc" ]]'>
              <thead>
                <tr>
                  <th> Código da Cotação </th>
                  <th> Data de Emissão </th>
                  <th> Data de Vencimento </th>
                  <th> Cliente </th>
                  <th> Valor Total (Mtn)</th>
                  <th> Valor Total - IVA (Mtn)</th>
                  <th class="text-right"><i class="icon_cogs"></i> Operações </th>
                </tr>
              </thead>

              <tbody>
                @foreach($cotacoes as $cotacao)
                <tr
                <?php 

                $hoje = strtotime(date('y-m-d'));
                $d_registo = strtotime($cotacao->created_at);
                $dias_validade = $cotacao->validade;
                $resultado = $dias_validade - ($hoje - $d_registo) / 86400;
                  // dd($d_registo);

                if($resultado < 0){
                  echo 'style="color: red"';
                }

                ?>

                >
                
                <td> {{$cotacao->id}} </td>
                <td> {{date('d-m-Y', strtotime($cotacao->created_at))}} </td>
                <td> {{date('d-m-Y', strtotime($cotacao->data_vencimento))}} </td>
                <td> {{$cotacao->cliente->nome}} </td>
                <td> {{number_format($cotacao->valor_total, 2, '.', ',')}} </td>
                <td> {{number_format($cotacao->valor_iva, 2, '.', ',')}} </td>
                <td class="text-right">
                  {{ Form::open(['route'=>['cotacao.destroy', $cotacao->id], 'method'=>'DELETE']) }}
                  <div class="btn-group btn-group-sm">
                    <a class="btn btn-primary" href="{{route('cotacao.show', $cotacao->id)}}"><i class="icon_plus_alt2"></i></a>
                    <a class="btn btn-success" href="{{route('cotacao.edit', $cotacao->id)}}"><i class="fa fa-pencil"></i></a>
                    {{ Form::button('<i class="icon_close_alt2"></i>', ['type'=>'submit', 'class'=>'btn btn-danger submit_iten']) }}

                  </div>
                  {{ Form::close() }}
                </td>

              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>

    </div>

    <div class="panel-footer">
      <div class="row">
        <div class="col-md-12">
          {{ $cotacoes->links() }}
        </div>
      </div>
    </div>

  </section>
</div>
</div>

@endsection

@section('script')
<script type="text/javascript">

  // DataTables Inicio
  $(document).ready(function() {

    var titulo = "Cotações";   
    var msg_bottom = "Papelaria Agenda & Serviços";

    var oTable = $('#tbl_index_cotacoes').DataTable( {
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
              messageBottom: msg_bottom,
              className: 'btn btn-defaul btn-sm'
            },
            {
              text: 'Excel',
              extend: 'excelHtml5',
              title: titulo,
              messageBottom: msg_bottom,
              className: 'btn btn-defaul btn-sm'
            },
            {
              text: 'PDF',
              extend: 'pdfHtml5',
              title: titulo,
              messageBottom: msg_bottom,
              className: 'btn btn-defaul btn-sm'
            }
            ]
          });

    $('#pesq').keyup(function(){
      oTable.search($(this).val()).draw();
    });

  } );
  // DataTables Fim

  $(document).ready(function(){
    $('.submit_iten').on('click',function(){
      $(".wait").css("display", "block");
    });
  });
</script>
@endsection
