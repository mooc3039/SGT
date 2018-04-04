@extends('layouts.master')
@section('content')
<div class="row">
  <div class="col-lg-12">
    <h3 class="page-header"><i class="fa fa-file-text-o"></i>Clientes
      @if(isset($privado))
      : <b>{{$privado}}</b>
      @endif

      @if(isset($publico))
      : <b>{{$publico}}</b>
      @endif
    </h3>
    <!-- <ol class="breadcrumb">
      <li><i class="fa fa-home"></i><a href="#">Home / Relatórios Gérais</a></li>
      <li><i class="icon_document_alt"></i>Clientes</li>
    </ol> -->
  </div>
</div>
<div class="row">
  
  <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
    <div class="info-box yellow-bg">
      <a href="{{ route('rg_clientes') }}" style="color: white"><i class="fa fa-users"></i></a>
      <div class="count"><a href="{{ route('rg_clientes') }}" style="color: white"><span>{{$total_cliente_todos}}</span></a></div>
      <div class="title"><a href="{{ route('rg_clientes') }}" style="color: white">Todos</a></div>
    </div>
  </div>

  <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
    <div class="info-box green-bg">
      <a href="{{ route('cliente_publico') }}" style="color: white"><i class="fa fa-users"></i></a>
      <div class="count"><a href="{{ route('cliente_publico') }}" style="color: white"><span>{{$total_cliente_publico}}</span></a></div>
      <div class="title"><a href="{{ route('cliente_publico') }}" style="color: white">Estado</a></div>
    </div>
  </div>

  <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
    <div class="info-box red-bg">
      <a href="{{ route('cliente_privado') }}" style="color: white"><i class="fa fa-users"></i></a>
      <div class="count"><a href="{{ route('cliente_privado') }}" style="color: white"><span>{{$total_cliente_privado}}</span></a></div>
      <div class="title"><a href="{{ route('cliente_privado') }}" style="color: white">Privado</a></div>
    </div>
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

        <table class="table table-striped table-advance table-hover" id="tbl_report_clientes" data-order='[[ 0, "desc" ]]'>
          <thead>

            <tr>
              <th><i class="icon_mail_alt"></i> Nome </th>
              <th><i class="icon_profile"></i> Endereço </th>
              <th><i class="icon_mobile"></i> Email </th>
              <th><i class="icon_mobile"></i> Telefone </th>
              <th><i class="icon_mail_alt"></i> NUIT </th>
              <th><i class="icon_mail_alt"></i> Activo </th>
              <th><i class="icon_mail_alt"></i> Tipo Cliente </th>

            </tr>
            </thead>
            <tbody>

            @foreach($clientes as $cliente)
            <tr>

              <td> {{$cliente->nome}} </td>
              <td> {{$cliente->endereco}} </td>
              <td> {{$cliente->email}} </td>
              <td> {{$cliente->telefone}} </td>
              <td> {{$cliente->nuit}} </td>
              <td> @if($cliente->activo == true) Sim @else Não @endif </td>
              <td> {{$cliente->tipo_cliente->descricao}} </td>
 
            </tr>

            @endforeach
          </tbody>
        </table>

      </div>


    </section>
  </div>
</div>

{{Form::hidden('privado', $privado , ['id'=>'privado'])}}
{{Form::hidden('publico', $publico , ['id'=>'publico'])}}

@endsection

@section('script')
<script type="text/javascript">

  $(document).ready(function() {

    var privado = $('#privado').val();
    var publico = $('#publico').val();
    var titulo = "Clientes";   
    var msg_bottom = "Papelaria Agenda & Serviços";

    if(privado === "" && publico === ""){
      titulo = "Clientes - Papelaria Agenda & Serviços";
    }else{
      if(privado !== ""){
        titulo = "Clientes Privados - Papelaria Agenda & Serviços";
      }
      if(publico !== ""){
        titulo = "Clientes: Instituições Públicas/Estado - Papelaria Agenda & Serviços";
      }
      
    }


    var oTable = $('#tbl_report_clientes').DataTable( {
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