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
          <div class="col-md-6">

            <a href="#"><h5><b><i class="fa fa-print"></i>Imprimir </b></h5></a>

          </div>
          <div class="col-md-6">
            <span class="pull-right"> <h5><b> Valor Total das Saidas: {{$valor_total_saidas}} Mtn</b></h5> </span>

          </div>
        </div>
      </div>
      <div class="panel-body">

        <table class="table table-striped table-advance table-hover">
          <tbody>

            <tr>
              <th><i class="icon_profile"></i>Código da Saída </th>
              <th><i class="icon_mobile"></i> Data de Emissão </th>
              <th><i class="icon_mail_alt"></i> Cliente </th>
              <th><i class="icon_mail_alt"></i> Valor Total </th>
            </tr>

            @foreach($saidas as $saida)
            <tr>

              <td> {{$saida->id}} </td>
              <td> {{$saida->data}} </td>
              <td> {{$saida->cliente->nome}} </td>
              <td> {{$saida->valor_total}} </td>

            </tr>

            @endforeach
          </tbody>
        </table>

      </div>


    </section>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function(){
    $('#saidas').change( function() {
      location.href = url('/entradas/report_geral_entradas/teste/'+$(this).val());
    });
  });
</script>

@endsection
