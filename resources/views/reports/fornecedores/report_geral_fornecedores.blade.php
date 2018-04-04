@extends('layouts.master')
@section('content')
<div class="row">
  <div class="col-lg-12">
    <h3 class="page-header"><i class="fa fa-file-text-o"></i>Fornecedores</h3>
    <ol class="breadcrumb">
      <li><i class="fa fa-home"></i><a href="#">Home / Relatórios Gérais</a></li>
      <li><i class="icon_document_alt"></i>Fornecedores</li>
    </ol>
  </div>
</div>



<div class="row">
  <div class="col-lg-12">
    <section class="panel panel-default">
      <div class="panel-body">
       <div class="row">
        <div class="col-md-8"></div>
        <div class="col-md-4">
          <input type="text" id="pesq" class="form-control" placeholder="Pesquisa...">
        </div>
      </div>

      <table class="table table-striped table-advance table-hover" id="tbl_report_fornecedores" data-order='[[ 0, "desc" ]]'>
       
        <thead>
          <tr>
            <th><i class="icon_mail_alt"></i> Nome </th>
            <th><i class="icon_profile"></i> Endereço </th>
            <th><i class="icon_mobile"></i> Email </th>
            <th><i class="icon_mobile"></i> Telefone </th>
            <th><i class="icon_mail_alt"></i> Activo </th>

          </tr>
        </thead>
        <tbody>
          @foreach($fornecedores as $fornecedor)
          <tr>

            <td> {{$fornecedor->nome}} </td>
            <td> {{$fornecedor->endereco}} </td>
            <td> {{$fornecedor->email}} </td>
            <td> {{$fornecedor->telefone}} </td>
            <td> @if($fornecedor->activo == true) Sim @else Não @endif </td>

          </tr>

          @endforeach
        </tbody>
      </table>

    </div>


  </section>
</div>
</div>

@endsection

@section('script')
<script type="text/javascript">

  $(document).ready(function() {

    var titulo = "Fornecedores";   
    var msg_bottom = "Papelaria Agenda & Serviços";

    var oTable = $('#tbl_report_fornecedores').DataTable( {
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

</script>
@endsection
