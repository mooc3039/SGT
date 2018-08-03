@extends('layouts.master')
@section('content')
<div class="row">
  <div class="col-lg-12">
    <h3 class="page-header"><i class="fa fa-file-text-o"></i>Parametrização do Usúario</h3>
    <ol class="breadcrumb">
      <li><i class="fa fa-home"></i><a href="#">Home</a></li>
      <li><i class="icon_document_alt"></i>Usúario</li>
      <li><i class="fa fa-file-text-o"></i>Gerenciar Usúario</li>
    </ol>
  </div>
</div>

<div class="row">
  <div class="col-lg-12">
    <section class="panel panel-default">
      <!-- <header class="panel-heading">
        Lista dos Fornecedores
      </header> -->


      

      
      <div class="panel-body">
        <div class="row" style="margin-bottom: 10px">
          <div class="col-md-8">
            <a href="{{ route('usuarios.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
          </div>
          <div class="col-md-4">
                <input type="text" id="pesq" class="form-control" placeholder="Pesquisa...">
              </div>
        </div>
        
        <div class="row">
          <div class="col-md-12">
            <table class="table table-striped table-advance table-hover" id="tbl_index_usuarios" data-order='[[ 0, "asc" ]]'>
          
          <thead>
            <tr>
              <th>Nome Completo</th>
              <th>Telefone</th>
              <th>Email</th>
              <th>Ocupação</th>
              <th>Activo </th>
              <th>Alterar Senha </th>
              <th class="text-right"><i class="icon_cogs"></i> Operações</th>
            </tr>
          </thead>

          <tbody>
            
            @foreach($usuarios as $usuario)
            <tr>
              <td> {{$usuario->name}}</td>
              <td>{{$usuario->telefone}}</td>
              <td>{{$usuario->email}}</td>
              <td>{{$usuario->occupation}}</td>
              <td>{{Form::checkbox('active', $usuario->active, $usuario->active, ['disabled'])}}</td>
              <td><a href="{{route('create_alterar_senha_usuario', $usuario->id)}}" class="btn btn-info btn-sm">Alterar Login</a></td>
              <td>
                <div class="btn-group btn-group-sm pull-right">

                    <a class="btn btn-primary" href="#"><i class="icon_plus_alt2"></i></a>
                    <a class="btn btn-success" href="{{route('usuarios.edit', $usuario->id)}}"><i class="fa fa-pencil"></i></a>

                    @if($usuario->active == true)
                    <a class="btn btn-danger" href="{{route('usuarios_desactivar', $usuario->id)}}"><i class="fa fa-lock"></i></a>
                    @else
                    <a class="btn btn-info" href="{{route('usuarios_activar', $usuario->id)}}"><i class="fa fa-unlock"></i></a>
                    @endif
                    {!!Form::close() !!}

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
    <a href="{{route('usuarios.index')}}" class="btn btn-info">
        Todos
      </a>
      <a href="{{route('usuarios_inactivos')}}" class="btn btn-danger">
        Inactivos
      </a>

      <a href="{{route('usuarios_activos')}}" class="btn btn-info">
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

    var titulo = "Usúarios";   
    var msg_bottom = "Papelaria Agenda & Serviços";

    var oTable = $('#tbl_index_usuarios').DataTable( {
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
