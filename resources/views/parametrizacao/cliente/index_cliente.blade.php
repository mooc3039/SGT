@extends('layouts.master')
@section('content')
<div class="row">
  <div class="col-lg-12">
    <h3 class="page-header"><i class="fa fa-file-text-o"></i>Parametrização do Cliente</h3>
    <ol class="breadcrumb">
      <li><i class="fa fa-home"></i><a href="#">Home</a></li>
      <li><i class="icon_document_alt"></i>Clientes</li>
      <li><i class="fa fa-file-text-o"></i>Gerenciar Clientes</li>
    </ol>
  </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <section class="panel panel-default">
      <!-- <header class="panel-heading">
        Parametrizar Cliente
      </header> -->

      <div class="panel-body">
        <div class="row" style="margin-bottom: 10px">
          <div class="col-md-8">
            <a href="{{ route('cliente.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
          </div>
          <div class="col-md-4">
            <input type="text" id="pesq" class="form-control" placeholder="Pesquisa...">
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            <table class="table table-striped table-advance table-hover" id="tbl_index_clientes" data-order='[[ 0, "asc" ]]'>

              <thead>
                <tr>
                  <th>Nome do Cliente</th>
                  <th>Endereço</th>
                  <th>Telefone</th>
                  <th>Email</th>
                  <th>NUIT</th>
                  <th>Tipo Cliente</th>
                  <th>Activo</th>
                  <th class="text-center"><i class="icon_cogs"></i> Operações</th>
                </tr>
              </thead>

              <tbody>

                @foreach($clientes as $cliente)
                <tr>
                  <td> {{$cliente->nome}} </td>
                  <td> {{$cliente->endereco}} </td>
                  <td> {{$cliente->telefone}} </td>
                  <td> {{$cliente->email}}</td>
                  <td> {{$cliente->nuit}}</td>
                  <td> {{$cliente->tipo_cliente->tipo_cliente}}</td>
                  <td>{{Form::checkbox('activo', $cliente->activo, $cliente->activo, ['disabled'])}}
                    <td class="text-right">
                      <div class="btn-group btn-group-sm">
                        <a class="btn btn-primary" href="#"><i class="icon_plus_alt2"></i></a>
                        <a class="btn btn-success" href="{{route('cliente.edit', $cliente->id)}}"><i class="fa fa-pencil"></i></a>
                        @if($cliente->activo == true)
                        <a href="{{route('clientes_desactivar', $cliente->id)}}" class="btn btn-danger"><i class="fa fa-lock"></i></a>
                        @else
                        <a href="{{route('clientes_activar', $cliente->id)}}" class="btn btn-info"><i class="fa fa-unlock"></i></a>
                        @endif

                      </div>
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
            <div class="col-md-6 text-left">
            </div>
            <div class="col-md-6 text-right">
              <div class="btn-group btn-group-sm">
                <a href="{{route('cliente.index')}}" class="btn btn-info">
                  Todos
                </a>
                <a href="{{route('clientes_inactivos')}}" class="btn btn-danger">
                  Inactivos
                </a>

                <a href="{{route('clientes_activos')}}" class="btn btn-info">
                  Activos
                </a>
              </div>

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

      var titulo = "Clientes";   
      var msg_bottom = "Papelaria Agenda & Serviços";

      var oTable = $('#tbl_index_clientes').DataTable( {
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
</script>
@endsection

