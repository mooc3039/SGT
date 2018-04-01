@extends('layouts.master')
@section('content')
<div class="row">
  <div class="col-lg-12">
    <h3 class="page-header"><i class="fa fa-file-text-o"></i>Entradas</h3>
    <ol class="breadcrumb">
      <li><i class="fa fa-home"></i><a href="#">Home / Relatórios Gérais</a></li>
      <li><i class="icon_document_alt"></i>Entradas</li>
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
              <th><i class="icon_profile"></i>Código da Entrada </th>
              <th><i class="icon_mobile"></i> Data de Entrada </th>
              <th><i class="icon_mail_alt"></i> Valor </th>
              <th><i class="icon_mail_alt"></i> Usúario Cadastrante </th>
            </tr>
          </thead>
          <tbody>
            @foreach($entradas as $entrada)
            <tr>

              <td> {{$entrada->id}} </td>
              <td> {{$entrada->data}} </td>
              <td> {{$entrada->valor}} </td>
              <td> {{$entrada->user->name}} </td>

            </tr>

            @endforeach
          </tbody>
        </table>

      </div>


    </section>
  </div>
</div>

@endsection
