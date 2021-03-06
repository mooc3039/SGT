@extends('layouts.master')
@section('content')
<div class="row">
	<div class="col-lg-12">
		<h3 class="page-header"><i class="fa fa-file-text-o"></i>Parametrização da Categoria</h3>
		<ol class="breadcrumb">
			<li><i class="fa fa-home"></i><a href="#">Home</a></li>
			<li><i class="icon_document_alt"></i>Categorias</li>
			<li><i class="fa fa-file-text-o"></i>Gerenciar Categorias</li>
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
            <a href="{{ route('categoria.create') }}" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i></a>
          </div>
          <div class="col-md-4">
                <input type="text" id="pesq" class="form-control" placeholder="Pesquisa...">
              </div>
        </div>

    	<div class="row">
         <div class="col-md-12">
             <table class="table table-striped table-advance table-hover" id="tbl_index_categorias" data-order='[[ 0, "asc" ]]''>

            <thead>
                <tr>
                    <th>Nome da Categoria </th>
                    <th class="text-right"><i class="icon_cogs"></i> Operações</th>
                </tr>
            </thead>

            <tbody>

                @foreach($categorias as $categoria)
                <tr>
                    <td> {{$categoria->nome}} </td>
                    <td class="text-right">
                        {{Form::open(['route'=>['categoria.destroy', $categoria->id], 'method'=>'DELETE'])}}
                        <div class="btn-group btn-group-sm">
                            <a class="btn btn-primary" href="#"><i class="fa fa-eye"></i></a>
                            <a class="btn btn-success" href="{{route('categoria.edit', $categoria->id)}}"><i class="fa fa-pencil"></i></a>
                            <!-- <a class="btn btn-danger" href="{{route('categoria.destroy', $categoria->id)}}"><i class="fa fa-pencil"></i></a> -->
                            {{Form::button('<i class="icon_close_alt2"></i>', ['type'=>'submit', 'class'=>'btn btn-danger'])}}

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
    		<div class="col-md-6 text-left">

    		</div>
    		<div class="col-md-6">


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

    var titulo = "Categorias";   
    var msg_bottom = "Papelaria Agenda & Serviços";

    var oTable = $('#tbl_index_categorias').DataTable( {
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
