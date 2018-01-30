@extends('layouts.master')
@section('content')
<div class="row">
  <div class="col-lg-12">
    <h3 class="page-header"><i class="fa fa-file-text-o"></i>Saídas</h3>
    <ol class="breadcrumb">
      <li><i class="fa fa-home"></i><a href="#">Home / Relatórios Gérais</a></li>
      <li><i class="icon_document_alt"></i>Saídas</li>
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
              <th><i class="icon_profile"></i> Descricão </th>
              <th><i class="icon_mobile"></i> Quantidade Disponivel </th>
              <th><i class="icon_mobile"></i> Quantidade Minima </th>
              <th><i class="icon_mail_alt"></i> Preco Venda </th>
              <th><i class="icon_mail_alt"></i> Preco Aquisicao </th>
              <th><i class="icon_mail_alt"></i> Fornecdor </th>
              <th><i class="icon_mail_alt"></i> Categoria </th>

            </tr>

            @foreach($produtos as $produto)
            <tr>

              <td> {{$produto->descricao}} </td>
              <td> {{$produto->quantidade_dispo}} </td>
              <td> {{$produto->quantidade_min}} </td>
              <td> {{$produto->preco_venda}} </td>
              <td> {{$produto->preco_aquisicao}} </td>
              <td> {{$produto->fornecedor->nome}} </td>
              <td> {{$produto->categoria->nome}} </td>

            </tr>

            @endforeach
          </tbody>
        </table>

      </div>


    </section>
  </div>
</div>

@endsection
