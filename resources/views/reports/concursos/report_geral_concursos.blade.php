@extends('layouts.master')
@section('content')
<div class="row">
  <div class="col-lg-12">
    <h3 class="page-header"><i class="fa fa-file-text-o"></i>Concursos</h3>
    <ol class="breadcrumb">
      <li><i class="fa fa-home"></i><a href="#">Home / Relatórios Gérais</a></li>
      <li><i class="icon_document_alt"></i>Concursos</li>
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

        <table class="mostrar table table-striped table-advance table-hover">
         <thead>

          <tr>
            <th><i class="icon_profile"></i>Código do Concurso </th>
            <th><i class="icon_mobile"></i> Data de Registo </th>
            <th><i class="icon_mail_alt"></i> Cliente </th>
            <th><i class="icon_mail_alt"></i> Valor Total </th>
            <th><i class="icon_mail_alt"></i> Facturas </th>
          </tr>
        </thead>

        <tbody>

          @foreach($concursos as $concurso)
          <tr>

            <td> {{$concurso->codigo_concurso}} </td>
            <td> {{$concurso->created_at}} </td>
            <td> {{$concurso->cliente->nome}} </td>
            <td> {{$concurso->valor_iva}} </td>
            <td> 
              <a class="btn btn-primary btn-sm" href="{{ route('facturasConcurso', $concurso->id)}}">F</a>
            </td>

          </tr>

          @endforeach
        </tbody>
      </table>

    </div>


  </section>
</div>
</div>

@endsection
