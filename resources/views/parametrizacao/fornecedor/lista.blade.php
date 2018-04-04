@extends('layouts.master')
@section('content')
<div class="row">
  <div class="col-lg-12">
    <h3 class="page-header"><i class="fa fa-file-text-o"></i>Parametrização do Fornecedor</h3>
    <ol class="breadcrumb">
      <li><i class="fa fa-home"></i><a href="#">Home</a></li>
      <li><i class="icon_document_alt"></i>Fornecedor</li>
      <li><i class="fa fa-file-text-o"></i>Gerenciar Fornecedor</li>
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
            <a href="{{ route('fornecedores.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
          </div>
          <div class="col-md-4">
                <input type="text" id="pesq" class="form-control" placeholder="Pesquisa...">
              </div>
        </div>
        
        <div class="row">
          <div class="col-md-12">
            <table class="table table-striped table-advance table-hover" id="tbl_index_fornecedores" data-order='[[ 0, "asc" ]]'>
          
          <thead>
            <tr>
              <th><i class="icon_profile"></i>Nome do Fornecedor</th>
              <th><i class="icon_profile"></i>NUIT</th>
              <th><i class="icon_mobile"></i> Endereço</th>
              <th><i class="icon_mail_alt"></i> Email</th>
              <th><i class="icon_pin_alt"></i> Telefone</th>
              <th><i class="icon_calendar"></i> Rubrica</th>
              <th><i class="fa fa-unlock-alt"></i> Activo </th>
              <th class="text-right"><i class="icon_cogs"></i> Operações</th>
            </tr>
          </thead>

          <tbody>
            
            @foreach($fornecedores as $fornecedor)
            <tr>
              <td> {{$fornecedor->nome}}</td>
              <td> {{$fornecedor->nuit}}</td>
              <td>{{$fornecedor->endereco}}</td>
              <td>{{$fornecedor->email}}</td>
              <td>{{$fornecedor->telefone}}</td>
              <td>{{$fornecedor->rubrica}}</td>
              <td>{{Form::checkbox('activo', $fornecedor->activo, $fornecedor->activo, ['disabled'])}}</td>
              <td>
                <div class="btn-group btn-group-sm pull-right">



                  <a class="btn btn-primary" href="#"><i class="icon_plus_alt2"></i></a>
                  <a class="btn btn-success" href="{{route('fornecedores.edit', $fornecedor->id)}}"><i class="fa fa-pencil"></i></a>

                  @if($fornecedor->activo == true)
                  <a class="btn btn-danger" href="{{route('fornecedores_desactivar', $fornecedor->id)}}"><i class="fa fa-lock"></i></a>
                  @else
                  <a class="btn btn-info" href="{{route('fornecedores_activar', $fornecedor->id)}}"><i class="fa fa-unlock"></i></a>
                  @endif
               <!-- {!!Form::open(['route'=>['fornecedores.destroy', $fornecedor->fornecedor_id], 'method'=>'DELETE'])!!}
                {{Form::submit('Delete', ['class' => 'btn btn-danger'])}} -->
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

          @if($fornecedor->activo == true)

          <a href="{{route('fornecedores_inactivos')}}" class="btn btn-primary">
            Inactivos
          </a>

          @else

          <a href="{{route('fornecedores.index')}}" class="btn btn-primary">
            Activos
          </a>

          @endif

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

    var titulo = "Fornecedores";   
    var msg_bottom = "Papelaria Agenda & Serviços";

    var oTable = $('#tbl_index_fornecedores').DataTable( {
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

