@extends('layouts.master')
@section('content')
<div class="row">
  <div class="col-lg-12">
    <h3 class="page-header"><i class="fa fa-file-text-o"></i>Cotações</h3>
    <ol class="breadcrumb">
      <li><i class="fa fa-home"></i><a href="#">Home / Relatórios Gérais</a></li>
      <li><i class="icon_document_alt"></i>Cotações</li>
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
              <th><i class="icon_profile"></i>Código da Cotação </th>
              <th><i class="icon_mobile"></i> Data de Emissão </th>
              <th><i class="icon_mail_alt"></i> Cliente </th>
              <th><i class="icon_mail_alt"></i> Valor Total </th>
            </tr>
          </thead>
          <tbody>
            @foreach($cotacoes as $cotacao)
            <tr>

              <td> {{$cotacao->id}} </td>
              <td> {{$cotacao->data}} </td>
              <td> {{$cotacao->cliente->nome}} </td>
              <td> {{$cotacao->valor_total}} </td>

            </tr>

            @endforeach
          </tbody>
        </table>

      </div>


    </section>
  </div>
</div>

@endsection
