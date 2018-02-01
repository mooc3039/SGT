@extends('layouts.master')
@section('content')
<div class="row">
  <div class="col-lg-12">
    <h3 class="page-header"><i class="fa fa-file-text-o"></i>Clientes</h3>
    <ol class="breadcrumb">
      <li><i class="fa fa-home"></i><a href="#">Home / Relatórios Gérais</a></li>
      <li><i class="icon_document_alt"></i>Clientes</li>
    </ol>
  </div>
</div>



<div class="row">
  <div class="col-lg-12">
    <section class="panel panel-default">
      <div class="panel-heading">
        <div class="row">
          <div class="col-md-12">

            <a href="#"><h5><b><i class="fa fa-print"></i>Imprimir </b></h5></a>

          </div>
        </div>
      </div>
      <div class="panel-body">

        <table class="table table-striped table-advance table-hover">
          <tbody>

            <tr>
              <th><i class="icon_mail_alt"></i> Nome </th>
              <th><i class="icon_profile"></i> Endereço </th>
              <th><i class="icon_mobile"></i> Email </th>
              <th><i class="icon_mobile"></i> Telefone </th>
              <th><i class="icon_mail_alt"></i> NUIT </th>
              <th><i class="icon_mail_alt"></i> Activo </th>

            </tr>

            @foreach($clientes as $cliente)
            <tr>

              <td> {{$cliente->nome}} </td>
              <td> {{$cliente->endereco}} </td>
              <td> {{$cliente->email}} </td>
              <td> {{$cliente->telefone}} </td>
              <td> {{$cliente->nuit}} </td>
              <td> @if($cliente->activo == true) Sim @else Não @endif </td>

            </tr>

            @endforeach
          </tbody>
        </table>

      </div>


    </section>
  </div>
</div>

@endsection
