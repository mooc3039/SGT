@extends('layouts.master')
@section('content')
<div class="row">
  <div class="col-lg-8">

    <h3 class="page-header"><i class="fa fa-file-text-o"></i>Guias de Entrega</h3>
    <ol class="breadcrumb">
      <li><i class="fa fa-home"></i><a href="#">Home</a></li>
      <li><i class="icon_document_alt"></i>Guias de Entrega</li>
    </ol>
  </div>
</div>

<div class="row">
  <div class="col-lg-12">
    
    <section class="panel panel-default">
      <!-- <header class="panel-heading">
        Guias de Entrega
      </header> -->
      <div class="panel-body">
        <div class="row">
          <div class="col-md-12">

            <div class="row" style="margin-bottom: 10px">
              <div class="col-md-8">
              </div>
              <div class="col-md-4">
                <input type="text" id="pesq" class="form-control" placeholder="Pesquisa...">
              </div>
            </div>

            <table class="table table-striped table-advance table-hover" id="index_guias_entrega" data-order='[[ 0, "desc" ]]'>
              <thead>
                <tr>
                  <th> Código da Guia </th>
                  <th> Código da Factura </th>
                  <th> Data de Emissão </th>
                  <th> Cliente </th>
                  <th> Valor Total (Mtn)</th>
                  <th class="text-right"><i class="icon_cogs"></i> Operações </th>
                </tr>
              </thead>
              <tbody>
                @foreach($guias_entrega as $guia_entrega)
                <tr>
                  <td> {{$guia_entrega->id}} </td>
                  <td> {{$guia_entrega->saida_id}} </td>
                  <td> {{date('d-m-Y', strtotime($guia_entrega->created_at))}} </td>
                  <td> {{$guia_entrega->cliente->nome}} </td>
                  <td> {{number_format($guia_entrega->valor_total, 2, '.', ',')}} </td>
                  <td class="text-right">
                    {{ Form::open(['route'=>['guia_entrega.destroy', $guia_entrega->id], 'method'=>'DELETE'])}}
                    {{ Form::button('Cancelar Guia', ['type'=>'submit', 'class'=>'btn btn-danger btn-sm submit_iten'])}}
                    <div class="btn-group btn-group-sm">
                      <a class="btn btn-success" href="{{route('guia_entrega.edit', $guia_entrega->id)}}"><i class="fa fa-pencil"></i></a>
                      <a class="btn btn-primary" href="{{route('guia_entrega.show', $guia_entrega->id)}}"><i class="fa fa-eye"></i></a>

                    </div>
                    {{Form::close()}}
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
          <div class="col-md-6">
            {{ $guias_entrega->links() }}
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

    var titulo = "Guias de Entrega";   
    var msg_bottom = "Papelaria Agenda & Serviços";

    var oTable = $('#index_guias_entrega').DataTable( {
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
